<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'order_id', 'product_id', 'quantity', 'total'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

}
