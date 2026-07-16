<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statistics = [
            'categories' => Category::count(),
            'active_categories' => Category::where('active', true)->count(),
            'brands' => Brand::count(),
            'products' => Product::count(),
            'low_stock_products' => Product::whereColumn(
                'stock',
                '<=',
                'minimum_stock'
            )->count(),
        ];

        return view('dashboard', compact('statistics'));
    }
}