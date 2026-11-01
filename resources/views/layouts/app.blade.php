<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'MBG Monitor'))</title>
    <style>
        body { font-family: sans-serif; margin: 0; background: #f5f5f5; color: #222; }
        header { background: #1a57a0; color: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.4rem; }
        header a { color: #fff; }
        nav { display: flex; gap: 1rem; align-items: center; }
        nav form { margin: 0; }
        main { max-width: 1000px; margin: 1.5rem auto; padding: 0 1rem; }
        button { cursor: pointer; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert.ok { background: #e3f6e8; color: #1a7f37; }
        .alert.err { background: #fdeaea; color: #c0392b; }
    </style>
</head>
<body>
    <header>
        <h1>{{ config('app.name', 'MBG Monitor') }}</h1>
        <nav>
            @auth
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