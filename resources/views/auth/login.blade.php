<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'MBG Monitor') }}</title>
    <style>
        body { font-family: sans-serif; background: #f5f5f5; margin: 0; color: #222; }
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
        <h1>{{ config('app.name', 'MBG Monitor') }}</h1>
        <p>Masuk untuk melanjutkan.</p>

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
    </div>
</body>
</html>