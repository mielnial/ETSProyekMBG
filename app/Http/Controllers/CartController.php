<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $jumlah) {
            if (! isset($products[$id])) {
                continue;
            }

            $product = $products[$id];
            $subtotal = $product->harga * $jumlah;
            $total += $subtotal;

            $items[] = [
                'product'  => $product,
                'jumlah'   => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        return view('keranjang.index', compact('items', 'total'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stok < 1) {
            return back()->with('error', 'Stok barang habis.');
        }

        $cart = session('cart', []);
        $jumlah = ($cart[$id] ?? 0) + 1;

        if ($jumlah > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stok . ').');
        }

        $cart[$id] = $jumlah;
        session(['cart' => $cart]);

        return back()->with('status', $product->nama_barang . ' dimasukkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['aksi' => ['required', 'in:tambah,kurang']]);

        $cart = session('cart', []);

        if (! isset($cart[$id])) {
            return back();
        }

        $product = Product::findOrFail($id);
        $jumlah = $cart[$id] + ($request->input('aksi') === 'tambah' ? 1 : -1);

        if ($jumlah > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stok . ').');
        }

        if ($jumlah <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $jumlah;
        }

        session(['cart' => $cart]);

        return back();
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back()->with('status', 'Barang dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('status', 'Keranjang dikosongkan.');
    }
}