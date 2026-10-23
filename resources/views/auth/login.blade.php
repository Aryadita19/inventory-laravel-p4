@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="card login">
    <h2>Login Inventory</h2>
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" autofocus>
        <x-field-error name="email" />

        <label for="password">Password</label>
        <input id="password" name="password" type="password">
        <x-field-error name="password" />

        <p><button class="btn" type="submit">Masuk</button></p>
    </form>
    <p class="muted">Demo: admin@inventory.test / password &middot; staff@inventory.test / password</p>
</div>
@endsection
