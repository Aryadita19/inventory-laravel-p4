@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="top"><h1>Kategori</h1><a class="btn" href="{{ route('categories.create') }}">+ Tambah Kategori</a></div>
<div class="card">
    <table>
        <tr><th>Nama</th><th>Deskripsi</th><th class="right">Jumlah Produk</th><th>Aksi</th></tr>
        @foreach ($categories as $c)
            <tr>
                <td>{{ $c->name }}</td><td>{{ $c->description }}</td><td class="right">{{ $c->products_count }}</td>
                <td>
                    <a class="btn btn-sm btn-gray" href="{{ route('categories.edit', $c) }}">Edit</a>
                    <form method="POST" action="{{ route('categories.destroy', $c) }}" style="display:inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
