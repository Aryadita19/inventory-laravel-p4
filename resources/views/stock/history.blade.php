@extends('layouts.app')
@section('title', 'Histori Stok')

@section('content')
<h1>Histori Barang Masuk / Keluar</h1>
<div class="card">
    <form method="GET" action="{{ route('stock.history') }}" class="filters">
        <select name="type">
            <option value="">Semua tipe</option>
            <option value="IN" @selected($type === 'IN')>Masuk (IN)</option>
            <option value="OUT" @selected($type === 'OUT')>Keluar (OUT)</option>
        </select>
        <button class="btn">Filter</button>
    </form>

    <table>
        <tr><th>Waktu</th><th>Tipe</th><th>SKU</th><th>Produk</th><th class="right">Jumlah</th><th>Oleh</th><th>Catatan</th></tr>
        @forelse ($movements as $m)
            <tr>
                <td>{{ $m->created_at }}</td>
                <td><span class="badge {{ $m->type === 'IN' ? 'in' : 'out' }}">{{ $m->type }}</span></td>
                <td>{{ $m->product->sku }}</td><td>{{ $m->product->name }}</td>
                <td class="right">{{ $m->quantity }}</td><td>{{ $m->user->name }}</td><td>{{ $m->note }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted">Belum ada transaksi.</td></tr>
        @endforelse
    </table>
    {{ $movements->links('pagination.custom') }}
</div>
@endsection
