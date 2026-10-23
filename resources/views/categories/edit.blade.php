@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<h1>Edit Kategori</h1>
<div class="card">@include('categories._form', ['action' => route('categories.update', $category)])</div>
@endsection
