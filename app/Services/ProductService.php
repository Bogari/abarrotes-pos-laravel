<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{
    public function create(array $data, bool $active = true): Product
    {
        return Product::create([
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
            'active' => $active,
        ]);
    }
}