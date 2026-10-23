@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="top">
    <h1>{{ $product->name }}</h1>
    <a class="btn btn-gray" href="{{ route('products.index') }}">&larr; Kembali</a>
</div>

<div class="card">
    <table>
        <tr><th style="width:200px">SKU</th><td>{{ $product->sku }}</td></tr>
        <tr><th>Kategori</th><td>{{ $product->category->name ?? '-' }}</td></tr>
        <tr><th>Harga</th><td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td></tr>
        <tr><th>Stok</th><td>{{ $product->stock }} @if ($product->isLowStock()) <span class="badge low">rendah</span> @endif</td></tr>
        <tr><th>Stok minimum</th><td>{{ $product->minimum_stock }}</td></tr>
    </table>
</div>

<div class="card">
    <h3>Supplier</h3>
    <table>
        <tr><th>Nama</th><th class="right">Harga dari supplier</th></tr>
        @forelse ($product->suppliers ?? [] as $s)
            <tr>
                <td>{{ $s->name }}</td>
                <td class="right">{{ $s->pivot->supplier_price ? 'Rp ' . number_format($s->pivot->supplier_price, 0, ',', '.') : '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="2" class="muted">Belum ada supplier.</td></tr>
        @endforelse
    </table>
</div>

<div class="card">
    <h3>5 Transaksi Terakhir</h3>
    <table>
        <tr><th>Waktu</th><th>Tipe</th><th class="right">Jumlah</th><th>Oleh</th></tr>
        @forelse ($movements ?? [] as $m)
            <tr>
                <td>{{ $m->created_at }}</td>
                <td><span class="badge {{ $m->type === 'IN' ? 'in' : 'out' }}">{{ $m->type }}</span></td>
                <td class="right">{{ $m->quantity }}</td>
                <td>{{ $m->user->name ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">Belum ada transaksi.</td></tr>
        @endforelse
    </table>
</div>
@endsection