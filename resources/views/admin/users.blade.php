@extends('layouts.app')

@section('title', 'Kelola Role')

@section('content')
    <h2>Kelola Role Pengguna</h2>

    @if ($errors->any())
        <div class="alert err">{{ $errors->first() }}</div>
    @endif

    <table>
        <thead>
            <tr><th>ID</th><th>Nama</th><th>Username</th><th>Role</th><th>Ubah role</th></tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->id_user }}</td>
                    <td>{{ $u->nama_lengkap }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                        <form class="inline" method="POST" action="{{ route('admin.users.role.update', $u->id_user) }}">
                            @csrf
                            @method('PATCH')
                            <select name="role">
                                <option value="customer" @selected($u->role === 'customer')>customer</option>
                                <option value="staff" @selected($u->role === 'staff')>staff</option>
                            </select>
                            <button type="submit">Simpan</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection