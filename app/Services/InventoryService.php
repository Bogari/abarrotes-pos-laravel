<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function entry(
        Product $product,
        float $quantity,
        ?float $unitCost = null,
        ?string $reference = null,
        ?string $reason = null
    ): InventoryMovement {
        return $this->registerMovement(
            product: $product,
            type: 'entry',
            quantity: $quantity,
            unitCost: $unitCost,
            reference: $reference,
            reason: $reason,
        );
    }

    public function exit(
        Product $product,
        float $quantity,
        ?string $reference = null,
        ?string $reason = null
    ): InventoryMovement {
        return $this->registerMovement(
            product: $product,
            type: 'exit',
            quantity: $quantity,
            reference: $reference,
            reason: $reason,
        );
    }

    public function adjustment(
        Product $product,
        float $newStock,
        ?string $reference = null,
        ?string $reason = null
    ): InventoryMovement {
        return DB::transaction(function () use (
            $product,
            $newStock,
            $reference,
            $reason
        ) {
            $lockedProduct = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);

            $stockBefore = (float) $lockedProduct->stock;

            if ($newStock < 0) {
                throw ValidationException::withMessages([
                    'new_stock' => 'La nueva existencia no puede ser negativa.',
                ]);
            }

            $difference = abs($newStock - $stockBefore);

            $lockedProduct->update([
                'stock' => $newStock,
            ]);

            return InventoryMovement::create([
                'product_id' => $lockedProduct->id,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => $difference,
                'stock_before' => $stockBefore,
                'stock_after' => $newStock,
                'unit_cost' => null,
                'reference' => $reference,
                'reason' => $reason,
            ]);
        });
    }

    private function registerMovement(
        Product $product,
        string $type,
        float $quantity,
        ?float $unitCost = null,
        ?string $reference = null,
        ?string $reason = null
    ): InventoryMovement {
        return DB::transaction(function () use (
            $product,
            $type,
            $quantity,
            $unitCost,
            $reference,
            $reason
        ) {
            if ($quantity <= 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'La cantidad debe ser mayor que cero.',
                ]);
            }

            $lockedProduct = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);

            $stockBefore = (float) $lockedProduct->stock;

            $stockAfter = match ($type) {
                'entry' => $stockBefore + $quantity,
                'exit' => $stockBefore - $quantity,
                default => throw ValidationException::withMessages([
                    'type' => 'El tipo de movimiento no es válido.',
                ]),
            };

            if ($stockAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'No hay suficiente existencia para realizar la salida.',
                ]);
            }

            $lockedProduct->update([
                'stock' => $stockAfter,
            ]);

            return InventoryMovement::create([
                'product_id' => $lockedProduct->id,
                'user_id' => auth()->id(),
                'type' => $type,
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'unit_cost' => $unitCost,
                'reference' => $reference,
                'reason' => $reason,
            ]);
        });
    }
}