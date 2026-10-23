@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<h1>Tambah Kategori</h1>
<div class="card">@include('categories._form', ['action' => route('categories.store')])</div>
@endsection
