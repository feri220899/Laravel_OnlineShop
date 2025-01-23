<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'order_id', 'payment_proof', 'status', 'verified_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'verified_by');
    }
    // status = pending | activated
}
