# Arsitektur MVC Project Inventory Laravel

## Alur umum
```
Request -> routes/web.php -> Middleware (auth, EnsureRole) -> Controller -> Model (Eloquent) -> Database
        <- Response (Blade view / redirect) <-
```

## Pembagian tanggung jawab
| Layer | File | Tugas |
|-------|------|-------|
| Route | `routes/web.php` | Menghubungkan URL + HTTP method ke controller; grup `auth` dan `EnsureRole:admin`. |
| Middleware | `app/Http/Middleware/EnsureRole.php` | Authorization di server: staff yang membuka halaman admin mendapat **403**. |
| Controller | `app/Http/Controllers/*Controller.php` | Menerima request, validasi (`$request->validate`), memanggil model/service, memilih response. |
| Model | `app/Models/*` | Representasi tabel + relationship (`Category hasMany Product`, `Product belongsToMany Supplier`, dst). |
| Service | `app/Services/StockService.php` | Business logic barang masuk/keluar dalam `DB::transaction` (dipindahkan dari P4). |
| View | `resources/views/*` | Blade: layout, component (`x-alert`, `x-field-error`, `x-sort-link`), form, loop. |
| Database | `database/migrations`, `factories`, `seeders` | Struktur tabel (version control), data dummy, data demo. |

## Pemetaan P4 -> P5
| P4 PHP Native | P5 Laravel |
|---------------|------------|
| `database/schema.sql` | `database/migrations/*` |
| Form PHP manual + validasi manual | Blade form + `$request->validate()` + `@error` |
| Query PDO | Eloquent (`Product::with('category')->paginate()`) |
| File CRUD terpisah | Resource controller (`Route::resource`) |
| `$_SESSION` manual | `Auth::attempt()` + middleware `auth` |
| `include header.php` | `@extends('layouts.app')` + `@include` + component |
| `record_movement()` | `StockService::move()` |

## Business rule yang tetap berjalan
1. SKU unik (`Rule::unique` + `unique()` di migration).
2. Harga dan quantity tidak negatif (validasi `min:0` / `min:1`, kolom `unsigned`).
3. Barang keluar tidak boleh melebihi stok (`StockService`, dengan `lockForUpdate`).
4. Stok tidak boleh negatif (rule 3 + kolom `unsignedInteger`).
5. Produk yang punya histori tidak boleh dihapus (cek `stockMovements()->exists()` + FK `restrictOnDelete`).
6. Kategori/supplier yang masih dipakai tidak boleh dihapus.
7. Halaman internal butuh login (`auth` middleware).
8. Staff tidak boleh ke administrasi (`EnsureRole::class.':admin'`).
9. Sorting hanya kolom allowlist (`ProductController::index`).
10. `stock` tidak ada di `$fillable` sehingga stok hanya berubah lewat transaksi.

## Demo satu alur lengkap: tambah produk
1. **Buka form** - `GET /products/create` -> `ProductController@create` -> view `products.create`.
2. **Validasi** - submit `POST /products` -> `ProductController@store` -> `$request->validate()`. Jika gagal, Laravel redirect kembali ke form dengan `@error` dan `old()`.
3. **Simpan** - `Product::create($validated)` dan `suppliers()->sync()` di dalam `DB::transaction`.
4. **Redirect** - `redirect()->route('products.index')->with('success', ...)`.
5. **Tampilkan data** - `GET /products` -> `ProductController@index` -> produk baru muncul di tabel dengan pesan sukses (`x-alert`).
