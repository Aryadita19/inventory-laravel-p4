<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /** Search + filter + sorting + pagination (query string dipertahankan). */
    public function index(Request $request)
    {
        // Allowlist kolom sorting: nama kolom tidak boleh berasal langsung dari input user
        $sortable = ['name', 'sku', 'selling_price', 'stock'];
        $sort = in_array($request->query('sort'), $sortable, true) ? $request->query('sort') : 'name';
        $dir = $request->query('dir') === 'desc' ? 'desc' : 'asc';

        $search = $request->string('search')->trim()->toString();

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'search', 'sort', 'dir'));
    }

    public function create()
    {
        return view('products.create', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create($validated);
            $product->suppliers()->sync($this->supplierPivot($request));
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    public function show(Product $product)
    {
        $product->load(['category']);
        $movements = $product->stockMovements()->with('user')->latest()->limit(5)->get();

        return view('products.show', compact('product', 'movements'));
    }

    public function edit(Product $product)
    {
        $product->load('suppliers');

        return view('products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validated($request, $product);

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update($validated);
            $product->suppliers()->sync($this->supplierPivot($request));
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Business rule P4: produk yang memiliki histori tidak boleh dihapus
        if ($product->stockMovements()->exists()) {
            return back()->with('error', 'Produk tidak bisa dihapus karena sudah memiliki histori barang masuk/keluar.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product)],
            'name' => ['required', 'string', 'max:150'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers' => ['nullable', 'array'],
            'suppliers.*' => ['integer', 'exists:suppliers,id'],
            'supplier_price' => ['nullable', 'array'],
            'supplier_price.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Hanya kolom milik products yang dikirim ke Product::create/update
        return collect($data)->only(['category_id', 'sku', 'name', 'purchase_price', 'selling_price', 'stock', 'minimum_stock'])->all();
    }

    /** Susun data pivot [supplier_id => ['supplier_price' => ...]] untuk sync(). */
    private function supplierPivot(Request $request): array
    {
        $pivot = [];
        foreach ((array) $request->input('suppliers', []) as $supplierId) {
            $price = $request->input("supplier_price.{$supplierId}");
            $pivot[(int) $supplierId] = ['supplier_price' => ($price === null || $price === '') ? null : $price];
        }

        return $pivot;
    }
}