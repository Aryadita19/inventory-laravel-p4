@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<h1>Edit Produk</h1>
<div class="card">
    @include('products._form', ['action' => route('products.update', $product)])
</div>
@endsection
