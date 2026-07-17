<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryMovementRequest;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryMovementController extends Controller
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {
    }

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $type = $request->string('type')->toString();
        $productId = $request->integer('product');

        $movements = InventoryMovement::query()
            ->with([
                'product',
                'user',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('reference', 'like', "%{$search}%")
                        ->orWhere('reason', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($productQuery) use ($search) {
                            $productQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        });
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($productId, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $products = Product::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

$stats = [
    'total' => InventoryMovement::count(),

    'entries' => InventoryMovement::where('type', 'entry')->count(),

    'exits' => InventoryMovement::where('type', 'exit')->count(),

    'adjustments' => InventoryMovement::where('type', 'adjustment')->count(),
];

return view('admin.inventory.index', compact(
    'movements',
    'products',
    'search',
    'type',
    'productId',
    'stats'
));
    }

    public function create(): View
    {
        $products = Product::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory.create', compact('products'));
    }

    public function store(
        StoreInventoryMovementRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $product = Product::findOrFail($data['product_id']);

        match ($data['type']) {
            'entry' => $this->inventoryService->entry(
                product: $product,
                quantity: (float) $data['quantity'],
                unitCost: isset($data['unit_cost'])
                    ? (float) $data['unit_cost']
                    : null,
                reference: $data['reference'] ?? null,
                reason: $data['reason'],
            ),

            'exit' => $this->inventoryService->exit(
                product: $product,
                quantity: (float) $data['quantity'],
                reference: $data['reference'] ?? null,
                reason: $data['reason'],
            ),

            'adjustment' => $this->inventoryService->adjustment(
                product: $product,
                newStock: (float) $data['new_stock'],
                reference: $data['reference'] ?? null,
                reason: $data['reason'],
            ),
        };

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', 'Movimiento de inventario registrado correctamente.');
    }
}