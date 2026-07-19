<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
    private readonly ProductService $productService
) {
}
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $category = $request->integer('category');
        $brand = $request->integer('brand');
        $status = $request->string('status')->toString();
        $stockStatus = $request->string('stock_status')->toString();

        $products = Product::query()
            ->with(['category', 'brand'])

            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%");
                });
            })

            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })

            ->when($brand, function ($query) use ($brand) {
                $query->where('brand_id', $brand);
            })

            ->when($status === 'active', function ($query) {
                $query->where('active', true);
            })

            ->when($status === 'inactive', function ($query) {
                $query->where('active', false);
            })

            ->when($stockStatus === 'low', function ($query) {
                $query
                    ->where('stock', '>', 0)
                    ->whereColumn('stock', '<=', 'minimum_stock');
            })

            ->when($stockStatus === 'available', function ($query) {
                $query->whereColumn('stock', '>', 'minimum_stock');
            })

            ->when($stockStatus === 'out', function ($query) {
                $query->where('stock', '<=', 0);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();
$stats = [

    'total' => Product::count(),

    'active' => Product::where('active', true)->count(),

    'low_stock' => Product::whereColumn('stock', '<=', 'minimum_stock')
        ->where('stock', '>', 0)
        ->count(),

    'out_stock' => Product::where('stock', '<=', 0)
        ->count(),

];

        return view('admin.products.index', compact(
            'products',
            'categories',
            'brands',
            'search',
            'category',
            'brand',
            'status',
            'stockStatus',
            'stats'
        ));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'brands'
        ));
    }

    public function store(
        StoreProductRequest $request
    ): RedirectResponse {
        $data = $request->validated();

       $this->productService->create(
    data: $data,
    active: $request->boolean('active')
);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function quickStore(
    StoreProductRequest $request
): JsonResponse {
    $product = $this->productService->create(
        data: $request->validated(),
        active: $request->boolean('active')
    );

    return response()->json([
        'message' => 'Producto creado correctamente.',
        'product' => [
            'id' => $product->id,
            'code' => $product->code,
            'barcode' => $product->barcode,
            'name' => $product->name,
            'purchase_price' => $product->purchase_price,
            'stock' => $product->stock,
        ],
    ], 201);
}

    public function show(
        Product $product
    ): RedirectResponse {
        return redirect()
            ->route('admin.products.edit', $product);
    }

    public function edit(
        Product $product
    ): View {
        $categories = Category::query()
            ->where(function ($query) use ($product) {
                $query
                    ->where('active', true)
                    ->orWhere('id', $product->category_id);
            })
            ->orderBy('name')
            ->get();

        $brands = Brand::query()
            ->where(function ($query) use ($product) {
                $query->where('active', true);

                if ($product->brand_id) {
                    $query->orWhere('id', $product->brand_id);
                }
            })
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'brands'
        ));
    }

    public function update(
        UpdateProductRequest $request,
        Product $product
    ): RedirectResponse {
        $data = $request->validated();

        $product->update([
            'code' => $data['code'],
            'barcode' => $data['barcode'] ?? null,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'] ?? null,
            'purchase_price' => $data['purchase_price'],
            'sale_price' => $data['sale_price'],
            'minimum_stock' => $data['minimum_stock'],
            'active' => $request->boolean('active'),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(
        Product $product
    ): RedirectResponse {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}