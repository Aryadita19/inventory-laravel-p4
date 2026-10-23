@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<div class="grid">
    <div class="stat">
        <small>Total Produk</small>
        <div class="n">{{ $totalProducts }}</div>
    </div>
    <div class="stat">
        <small>Nilai Inventory</small>
        <div class="n">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</div>
    </div>
    <div class="stat">
        <small>Produk Stok Rendah</small>
        <div class="n">{{ $lowStockProducts->count() }}</div>
    </div>
    <div class="stat">
        <small>Total Kategori</small>
        <div class="n">{{ $totalCategories }}</div>
    </div>
    <div class="stat">
        <small>Total Supplier</small>
        <div class="n">{{ $totalSuppliers }}</div>
    </div>
</div>

<div class="card" style="margin-top: 20px;">
    <h3>Produk Stok Rendah (Stok &le; Minimum)</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Min. Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lowStockProducts as $p)
                <tr>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? '-' }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>{{ $p->minimum_stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada produk dengan stok rendah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection