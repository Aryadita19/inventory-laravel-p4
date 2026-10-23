@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<h1>Edit Supplier</h1>
<div class="card">@include('suppliers._form', ['action' => route('suppliers.update', $supplier)])</div>
@endsection
