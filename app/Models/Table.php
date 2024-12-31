<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Table extends Model
{
    protected $fillable = ['number', 'status', 'capacity'];

    protected $casts = [
        'capacity' => 'integer',
        'number' => 'text',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function current_order(): HasOne
    {
        return $this->hasOne(Order::class)
            ->where('status', 'pending')
            ->latest();
    }
}
