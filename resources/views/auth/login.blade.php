<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Toko Alat Tulis</title>
    <style>
        body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
        .box { max-width: 340px; margin: 4rem auto; background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
        h1 { margin-top: 0; }
        label { display: block; margin-top: .75rem; }
        input { width: 100%; padding: .5rem; box-sizing: border-box; margin-top: .25rem; }
        button { margin-top: 1rem; padding: .5rem 1rem; }
        .error { color: #c0392b; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Login</h1>
        <p>Masuk untuk berbelanja.</p>

        @error('login')
            <p class="error">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>

        <p><a href="{{ route('produk.index') }}">&laquo; Kembali ke toko</a></p>
    </div>
</body>
</html>