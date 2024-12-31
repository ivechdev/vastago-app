<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'product_id',
        'quantity',
        'minimum_stock',
        'unit',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function updateStockStatus()
    {
        if ($this->quantity <= 0) {
            $this->status = 'Sin stock';
        } elseif ($this->quantity > 20 && $this->quantity < 80) {
            $this->status = 'Pocas unidades';
        } else {
            $this->status = 'Disponible';
        }
        $this->save();
    }
}
