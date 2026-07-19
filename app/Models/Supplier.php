<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_name',
        'tax_id',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'notes',
        'active',
    ];
public function purchases(): HasMany
{
    return $this->hasMany(Purchase::class);
}
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}