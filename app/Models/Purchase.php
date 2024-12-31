<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = [
        'supplier',
        'invoice_number',
        'date',
        'total',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'total' => 'decimal:2'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
