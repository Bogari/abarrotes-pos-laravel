<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Brand;
use App\Models\Category;

class PurchaseController extends Controller
{
    public function __construct(
        private readonly PurchaseService $purchaseService
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $purchases = Purchase::query()
            ->with(['supplier', 'user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery
                        ->where('folio', 'like', "%{$search}%")
                        ->orWhere('invoice_number', 'like', "%{$search}%")
                        ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                            $supplierQuery->where(
                                'business_name',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('purchase_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.purchases.index', compact('purchases'));
    }

    public function create(): View
    {
        $suppliers = Supplier::query()
            ->where('active', true)
            ->orderBy('business_name')
            ->get();

        $products = Product::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

            $categories = Category::query()
    ->where('active', true)
    ->orderBy('name')
    ->get();

$brands = Brand::query()
    ->where('active', true)
    ->orderBy('name')
    ->get();

        return view('admin.purchases.create', compact(
            'suppliers',
            'products',
            'categories',
           'brands'
        ));
    }

    public function store(
        StorePurchaseRequest $request
    ): RedirectResponse {
        $purchase = $this->purchaseService->create(
            data: $request->validated(),
            user: $request->user()
        );

        return redirect()
            ->route('admin.purchases.show', $purchase)
            ->with('success', 'Compra registrada correctamente.');
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load([
            'supplier',
            'user',
            'items.product',
        ]);

        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase): View
    {
        abort_if(
            $purchase->status !== 'draft',
            403,
            'Solo se pueden editar compras en borrador.'
        );

        $suppliers = Supplier::query()
            ->where('active', true)
            ->orderBy('business_name')
            ->get();

        $products = Product::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $purchase->load('items');

        return view('admin.purchases.edit', compact(
            'purchase',
            'suppliers',
            'products'
        ));
    }

    public function update(
        StorePurchaseRequest $request,
        Purchase $purchase
    ): RedirectResponse {
        abort_if(
            $purchase->status !== 'draft',
            403,
            'Solo se pueden editar compras en borrador.'
        );

        return redirect()
            ->route('admin.purchases.show', $purchase)
            ->with(
                'success',
                'La edición de borradores se implementará posteriormente.'
            );
    }

    public function destroy(
        Purchase $purchase
    ): RedirectResponse {
        abort_if(
            $purchase->status === 'completed',
            403,
            'Una compra completada no puede eliminarse.'
        );

        $purchase->delete();

        return redirect()
            ->route('admin.purchases.index')
            ->with('success', 'Compra eliminada correctamente.');
    }
}