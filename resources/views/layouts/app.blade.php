<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Toko Alat Tulis')</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; }
        header { background: #1a57a0; color: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.6rem; }
        header a { color: #fff; }
        nav { display: flex; gap: 1rem; align-items: center; }
        nav form { margin: 0; }
        main { max-width: 1000px; margin: 1.5rem auto; padding: 0 1rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }
        .card { background: #fff; border-radius: 8px; padding: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
        .card img { width: 100%; height: 150px; object-fit: cover; border-radius: 4px; }
        .card h3 { margin: .5rem 0 0; font-size: 1rem; }
        .harga { font-weight: bold; margin: .5rem 0 .25rem; }
        .habis { color: #c0392b; font-weight: bold; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert.ok { background: #e3f6e8; color: #1a7f37; }
        .alert.err { background: #fdeaea; color: #c0392b; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: .6rem .75rem; border-bottom: 1px solid #ddd; text-align: left; }
        form.inline { display: inline; }
        .total { text-align: right; font-size: 1.2rem; font-weight: bold; margin: 1rem 0; }
    </style>
</head>
<body>
    <header>
        <h1><a href="{{ route('produk.index') }}" style="text-decoration:none">Toko Alat Tulis</a></h1>
             <nav>
            @auth
                <a href="{{ route('pesanan.index') }}">Pesanan Saya</a>
                <a href="{{ route('keranjang.index') }}">Keranjang ({{ array_sum(session('cart', [])) }})</a>
                <span>Halo, {{ Auth::user()->nama_lengkap }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
            @endauth
        </nav>
    </header>

    <main>
        @if (session('status'))
            <div class="alert ok">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="alert err">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>