<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carts extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'product_id', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
