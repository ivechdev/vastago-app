<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'available',
    ];

    protected $casts = [
        'available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function inventory(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class, 'product_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
