<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'purchase_price',
        'selling_price',
        'stock',
        'minimum_stock',
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Many-to-Many ke Supplier dengan pivot supplier_price
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
                    ->withPivot('supplier_price')
                    ->withTimestamps();
    }

    // Relasi ke Stock Movements / Riwayat Stok
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'product_id');
    }

    // Relasi ke Purchase Items (opsional sesuai ERD UTS)
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // Relasi ke Sale Items (opsional sesuai ERD UTS)
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Method untuk mengecek apakah stok produk sudah rendah
    public function isLowStock()
    {
        return $this->stock <= $this->minimum_stock;
    }
}