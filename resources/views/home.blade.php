@extends('layouts.app')

@section('title', 'Beranda - ' . config('app.name', 'MBG Monitor'))

@section('content')
    <section>
        <h2>Selamat datang</h2>
        <p>Anda berhasil masuk ke {{ config('app.name', 'MBG Monitor') }}.</p>
    </section>
@endsection