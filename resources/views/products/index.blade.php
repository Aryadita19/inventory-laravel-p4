@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<div class="top">
    <h1>Produk</h1>
    @if (auth()->user()->isAdmin())
        <a class="btn" href="{{ route('products.create') }}">+ Tambah Produk</a>
    @endif
</div>

<div class="card">
    <form method="GET" action="{{ route('products.index') }}" class="filters">
        <input name="search" placeholder="Cari nama atau SKU..." value="{{ $search }}">
        <select name="category_id">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <select name="sort">
            @foreach (['name' => 'Nama', 'sku' => 'SKU', 'price' => 'Harga', 'stock' => 'Stok'] as $key => $label)
                <option value="{{ $key }}" @selected($sort === $key)>Urut: {{ $label }}</option>
            @endforeach
        </select>
        <select name="dir">
            <option value="asc" @selected($dir === 'asc')>Naik (ASC)</option>
            <option value="desc" @selected($dir === 'desc')>Turun (DESC)</option>
        </select>
        <button class="btn">Terapkan</button>
    </form>

    <table>
        <tr>
            <th><x-sort-link column="sku" label="SKU" /></th>
            <th><x-sort-link column="name" label="Nama" /></th>
            <th>Kategori</th>
            <th class="right"><x-sort-link column="price" label="Harga" /></th>
            <th class="right"><x-sort-link column="stock" label="Stok" /></th>
            <th>Aksi</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->sku }}</td>
                <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                <td>{{ $product->category->name }}</td>
                <td class="right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                <td class="right">
                    {{ $product->stock }}
                    @if ($product->isLowStock()) <span class="badge low">rendah</span> @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-gray" href="{{ route('products.show', $product) }}">Detail</a>
                    @if (auth()->user()->isAdmin())
                        <a class="btn btn-sm btn-gray" href="{{ route('products.edit', $product) }}">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">Belum ada produk yang cocok.</td></tr>
        @endforelse
    </table>

    <p class="muted">Total {{ $products->total() }} produk &middot; Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</p>
    {{ $products->links('pagination.custom') }}
</div>
@endsection
