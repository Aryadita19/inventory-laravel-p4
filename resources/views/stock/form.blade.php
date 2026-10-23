@extends('layouts.app')
@section('title', $label)

@section('content')
<h1>{{ $label }}</h1>
<div class="card">
    <form method="POST" action="{{ route('stock.store', $type) }}">
        @csrf
        <label>Produk</label>
        <select name="product_id">
            <option value="">-- pilih produk --</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->sku }} - {{ $p->name }} (stok: {{ $p->stock }})</option>
            @endforeach
        </select>
        <x-field-error name="product_id" />

        <label>Jumlah</label>
        <input name="quantity" value="{{ old('quantity') }}">
        <x-field-error name="quantity" />

        <label>Catatan (opsional)</label>
        <input name="note" value="{{ old('note') }}">
        <x-field-error name="note" />

        <p><button class="btn" type="submit">Simpan {{ $label }}</button></p>
    </form>
</div>
@endsection
