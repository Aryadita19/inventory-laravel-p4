@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<h1>Tambah Supplier</h1>
<div class="card">@include('suppliers._form', ['action' => route('suppliers.store')])</div>
@endsection
