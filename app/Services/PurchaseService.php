<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PurchaseService
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {
    }

    public function create(array $data, User $user): Purchase
    {
        return DB::transaction(function () use ($data, $user) {
            $items = $data['items'];
            $tax = (float) ($data['tax'] ?? 0);

            $subtotal = 0;

            foreach ($items as $item) {
                $subtotal +=
                    (float) $item['quantity']
                    * (float) $item['unit_cost'];
            }

            $total = $subtotal + $tax;

            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'user_id' => $user->id,
                'folio' => $this->generateFolio(),
                'purchase_date' => $data['purchase_date'],
                'invoice_number' => $data['invoice_number'] ?? null,
                'status' => 'completed',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $product = Product::query()
                    ->lockForUpdate()
                    ->findOrFail($item['product_id']);

                $quantity = (float) $item['quantity'];
                $unitCost = (float) $item['unit_cost'];
                $lineSubtotal = $quantity * $unitCost;

                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'subtotal' => $lineSubtotal,
                ]);

                $this->inventoryService->entry(
                    product: $product,
                    quantity: $quantity,
                    unitCost: $unitCost,
                    reference: $purchase->folio,
                    reason: 'Compra a proveedor'
                );

                $product->update([
                    'purchase_price' => $unitCost,
                ]);
            }

            return $purchase->load([
                'supplier',
                'user',
                'items.product',
            ]);
        });
    }

    private function generateFolio(): string
    {
        $lastId = Purchase::query()
            ->lockForUpdate()
            ->max('id');

        $nextNumber = ((int) $lastId) + 1;

        return 'COMP-' . str_pad(
            (string) $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}