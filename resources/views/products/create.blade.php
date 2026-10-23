@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="container">
    <h1>Tambah Produk</h1>

    {{-- Menampilkan pesan error validasi jika ada input yang kurang/salah --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @include('products._form', ['action' => route('products.store')])
        </div>
    </div>
</div>
@endsection