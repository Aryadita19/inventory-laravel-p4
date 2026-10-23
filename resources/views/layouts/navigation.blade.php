<nav class="nav">
    <strong>📦 Inventory</strong>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('products.index') }}">Produk</a>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('categories.index') }}">Kategori</a>
        <a href="{{ route('suppliers.index') }}">Supplier</a>
        <a href="{{ route('users.index') }}">User</a>
    @endif
    <a href="{{ route('stock.create', 'in') }}">Barang Masuk</a>
    <a href="{{ route('stock.create', 'out') }}">Barang Keluar</a>
    <a href="{{ route('stock.history') }}">Histori</a>
    <span class="spacer"></span>
    <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button class="btn btn-sm">Logout</button>
    </form>
</nav>
