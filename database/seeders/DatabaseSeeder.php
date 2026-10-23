<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User
        $admin = User::updateOrCreate(
            ['email' => 'admin@inventory.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $staff = User::updateOrCreate(
            ['email' => 'staff@inventory.test'],
            [
                'name' => 'Staff Gudang',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // 2. Kategori
        $elektronik = Category::create(['name' => 'Elektronik & Gadget']);
        $pakaian    = Category::create(['name' => 'Pakaian & Fashion']);
        $makanan    = Category::create(['name' => 'Makanan & Minuman']);
        $aksesoris  = Category::create(['name' => 'Aksesoris Komputer']);

        // 3. Supplier
        $sup1 = Supplier::create([
            'name'           => 'PT Jaya Tech Indonesia',
            'contact_person' => 'Budi Santoso',
            'phone'          => '081234567890',
            'email'          => 'budi@jayatech.co.id',
            'address'        => 'Jl. Merdeka No. 10, Jakarta',
        ]);

        $sup2 = Supplier::create([
            'name'           => 'CV Makmur Bersama',
            'contact_person' => 'Siti Rahma',
            'phone'          => '089876543210',
            'email'          => 'siti@makmurbersama.com',
            'address'        => 'Jl. Gatot Subroto No. 45, Medan',
        ]);

        $sup3 = Supplier::create([
            'name'           => 'PT Global Distribusi',
            'contact_person' => 'Andi Wijaya',
            'phone'          => '085211223344',
            'email'          => 'sales@globaldistribusi.com',
            'address'        => 'Jl. Ahmad Yani No. 12, Surabaya',
        ]);

        // 4. Produk
        $p1 = Product::create([
            'category_id'    => $elektronik->id,
            'sku'            => 'PRD-ELEK-001',
            'name'           => 'Laptop Asus Vivobook 14',
            'purchase_price' => 7000000,
            'selling_price'  => 8500000,
            'stock'          => 12,
            'minimum_stock'  => 5,
        ]);

        $p2 = Product::create([
            'category_id'    => $aksesoris->id,
            'sku'            => 'PRD-AKS-001',
            'name'           => 'Mouse Wireless Logitech M170',
            'purchase_price' => 120000,
            'selling_price'  => 175000,
            'stock'          => 3, // Stok rendah (triggers warning)
            'minimum_stock'  => 5,
        ]);

        $p3 = Product::create([
            'category_id'    => $pakaian->id,
            'sku'            => 'PRD-PAK-001',
            'name'           => 'Kaos Polos Cotton Combed 30s',
            'purchase_price' => 35000,
            'selling_price'  => 60000,
            'stock'          => 45,
            'minimum_stock'  => 10,
        ]);

        $p4 = Product::create([
            'category_id'    => $makanan->id,
            'sku'            => 'PRD-MAK-001',
            'name'           => 'Kopi Arabika Gayo 250g',
            'purchase_price' => 45000,
            'selling_price'  => 75000,
            'stock'          => 2, // Stok rendah
            'minimum_stock'  => 8,
        ]);

        $p5 = Product::create([
            'category_id'    => $aksesoris->id,
            'sku'            => 'PRD-AKS-002',
            'name'           => 'Keyboard Mechanical RGB',
            'purchase_price' => 350000,
            'selling_price'  => 500000,
            'stock'          => 15,
            'minimum_stock'  => 5,
        ]);

        // 5. Histori Stok (Stock Movements)
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $admin->id,
            'type'       => 'in',
            'quantity'   => 15,
            'reference'  => 'IN-2026-001',
            'notes'      => 'Pembelian stok awal dari PT Jaya Tech',
        ]);

        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $staff->id,
            'type'       => 'out',
            'quantity'   => 3,
            'reference'  => 'OUT-2026-001',
            'notes'      => 'Penjualan ke pelanggan',
        ]);

        StockMovement::create([
            'product_id' => $p2->id,
            'user_id'    => $staff->id,
            'type'       => 'in',
            'quantity'   => 10,
            'reference'  => 'IN-2026-002',
            'notes'      => 'Restok dari PT Global Distribusi',
        ]);

        StockMovement::create([
            'product_id' => $p2->id,
            'user_id'    => $staff->id,
            'type'       => 'out',
            'quantity'   => 7,
            'reference'  => 'OUT-2026-002',
            'notes'      => 'Pengeluaran barang untuk unit kantor',
        ]);

        StockMovement::create([
            'product_id' => $p4->id,
            'user_id'    => $admin->id,
            'type'       => 'in',
            'quantity'   => 5,
            'reference'  => 'IN-2026-003',
            'notes'      => 'Penerimaan sampel produk baru',
        ]);
    }
}