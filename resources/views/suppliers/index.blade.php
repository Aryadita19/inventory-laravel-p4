@extends('layouts.app')
@section('title', 'Supplier')

@section('content')
<div class="top"><h1>Supplier</h1><a class="btn" href="{{ route('suppliers.create') }}">+ Tambah Supplier</a></div>
<div class="card">
    <table>
        <tr><th>Nama</th><th>Telepon</th><th>Email</th><th>Aksi</th></tr>
        @foreach ($suppliers as $s)
            <tr>
                <td>{{ $s->name }}</td><td>{{ $s->phone }}</td><td>{{ $s->email }}</td>
                <td>
                    <a class="btn btn-sm btn-gray" href="{{ route('suppliers.edit', $s) }}">Edit</a>
                    <form method="POST" action="{{ route('suppliers.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Hapus supplier ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
