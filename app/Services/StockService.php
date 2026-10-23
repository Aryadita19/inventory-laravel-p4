<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Business logic barang masuk/keluar (dipindahkan dari helpers/stock.php di P4).
 * Satu transaction: update stok + catat histori + simpan user pelaku.
 */
class StockService
{
    public function move(int $productId, string $type, int $quantity, int $userId, ?string $note = null): StockMovement
    {
        return DB::transaction(function () use ($productId, $type, $quantity, $userId, $note) {
            // Kunci baris produk (SELECT ... FOR UPDATE) agar tidak ada transaksi lain yang mengubah stok bersamaan
            $product = Product::query()->lockForUpdate()->findOrFail($productId);

            if ($type === 'OUT' && $quantity > $product->stock) {
                // ValidationException -> Laravel otomatis rollback transaction dan redirect back dengan pesan error
                throw ValidationException::withMessages([
                    'quantity' => "Stok tidak mencukupi. Stok tersedia: {$product->stock}, diminta: {$quantity}.",
                ]);
            }

            $type === 'IN'
                ? $product->increment('stock', $quantity)
                : $product->decrement('stock', $quantity);

            return StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'type' => $type,
                'quantity' => $quantity,
                'note' => $note,
            ]);
        });
    }
}
