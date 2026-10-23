<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        
        // Menggunakan purchase_price untuk menghitung total nilai persediaan barang
        $totalInventoryValue = Product::selectRaw('SUM(stock * purchase_price) as total')->value('total') ?? 0;

        $recentSales = Sale::with('saleItems.product')->latest()->take(5)->get();
        $recentPurchases = Purchase::with('purchaseItems.product', 'supplier')->latest()->take(5)->get();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalInventoryValue',
            'recentSales',
            'recentPurchases',
            'lowStockProducts'
        ));
    }
}