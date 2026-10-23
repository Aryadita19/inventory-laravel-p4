<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function create(string $type)
    {
        return view('stock.form', [
            'type' => $type,
            'label' => $type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, string $type, StockService $stock): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        // Jika stok tidak cukup, StockService melempar ValidationException (otomatis kembali ke form + pesan error)
        $stock->move(
            (int) $data['product_id'],
            strtoupper($type),
            (int) $data['quantity'],
            $request->user()->id,
            $data['note'] ?? null,
        );

        return redirect()->route('stock.create', $type)
            ->with('success', $type === 'in' ? 'Barang masuk berhasil dicatat.' : 'Barang keluar berhasil dicatat.');
    }

    public function history(Request $request)
    {
        $type = strtoupper((string) $request->query('type', ''));
        $type = in_array($type, ['IN', 'OUT'], true) ? $type : '';

        $movements = StockMovement::with(['product', 'user'])
            ->when($type !== '', fn ($q) => $q->where('type', $type))
            ->latest()
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('stock.history', compact('movements', 'type'));
    }
}
