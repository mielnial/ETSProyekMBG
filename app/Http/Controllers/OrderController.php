<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('id_user', Auth::id())
            ->orderByDesc('tanggal_order')
            ->get();

        return view('pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('details.product')
            ->where('id_order', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        return view('pesanan.show', compact('order'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong.');
        }

        $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $jumlah) {
            if (! isset($products[$id])) {
                continue;
            }

            $subtotal = $products[$id]->harga * $jumlah;
            $total += $subtotal;

            $items[] = [
                'product'  => $products[$id],
                'jumlah'   => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:500'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $request) {
                $products = Product::whereIn('id_barang', array_keys($cart))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_barang');

                $total = 0;

                foreach ($cart as $id => $jumlah) {
                    $product = $products[$id] ?? null;

                    if (! $product) {
                        throw new \RuntimeException('Ada barang di keranjang yang sudah tidak tersedia.');
                    }

                    if ($jumlah > $product->stok) {
                        throw new \RuntimeException(
                            'Stok ' . $product->nama_barang . ' tidak mencukupi (tersisa ' . $product->stok . ').'
                        );
                    }

                    $total += $product->harga * $jumlah;
                }

                $order = Order::create([
                    'id_order'          => 'ORD' . now()->format('ymd') . str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT),
                    'id_user'           => Auth::id(),
                    'tanggal_order'     => now(),
                    'total_harga'       => $total,
                    'alamat_pengiriman' => $request->input('alamat_pengiriman'),
                ]);

                foreach ($cart as $id => $jumlah) {
                    $product = $products[$id];

                    $order->details()->create([
                        'id_barang'    => $id,
                        'harga_satuan' => $product->harga,
                        'jumlah_beli'  => $jumlah,
                    ]);

                    $product->decrement('stok', $jumlah);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('keranjang.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('pesanan.show', $order->id_order)
            ->with('status', 'Pesanan berhasil dibuat.');
    }
}