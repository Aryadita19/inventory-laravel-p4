@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<h1>Manajemen User</h1>
<div class="card">
    <table>
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Dibuat</th></tr>
        @foreach ($users as $u)
            <tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->role }}</td><td>{{ $u->created_at }}</td></tr>
        @endforeach
    </table>
</div>
@endsection
