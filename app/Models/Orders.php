<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payments;
use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'status', 'grand_total', 'destination_address', 'created_at',
    ];

    // status = waiting_payment | payment_success | verified | order_completed | cancelled
    // waiting_payment, menunggu pembayaran buyer
    // payment_success, user selesai membayar dan cek pembayaran oleh admin laye 1
    // verified, di verivikasi oleh admin layer 2 dan masuk ke pengiriman
    // order_completed, barang di terima oleh pembeli

    public function payment()
    {
        return $this->hasOne(Payments::class, 'order_id', 'id');
    }
    public function order_detail()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
