<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'barcode',
        'name',
        'slug',
        'description',
        'category_id',
        'brand_id',
        'purchase_price',
        'sale_price',
        'stock',
        'minimum_stock',
        'active',
    ];

    public function inventoryMovements(): HasMany
{
    return $this->hasMany(InventoryMovement::class);
}
public function purchaseItems(): HasMany
{
    return $this->hasMany(PurchaseItem::class);
}

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock' => 'decimal:2',
            'minimum_stock' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}