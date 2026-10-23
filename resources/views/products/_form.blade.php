<form action="{{ $action }}" method="POST">
    @csrf
    @if(isset($product) && $product->exists)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product?->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="sku" class="form-label">SKU</label>
        <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product?->sku) }}" required>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nama Produk</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product?->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="purchase_price" class="form-label">Harga Beli</label>
        <input type="number" name="purchase_price" id="purchase_price" class="form-control" value="{{ old('purchase_price', $product?->purchase_price) }}" required>
    </div>

    <div class="mb-3">
        <label for="selling_price" class="form-label">Harga Jual</label>
        <input type="number" name="selling_price" id="selling_price" class="form-control" value="{{ old('selling_price', $product?->selling_price) }}" required>
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product?->stock) }}" required>
    </div>

    <div class="mb-3">
        <label for="minimum_stock" class="form-label">Stok Minimum</label>
        <input type="number" name="minimum_stock" id="minimum_stock" class="form-control" value="{{ old('minimum_stock', $product?->minimum_stock) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
</form>