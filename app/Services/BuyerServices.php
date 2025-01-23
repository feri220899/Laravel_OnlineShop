<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Products;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;

class BuyerServices
{
    public static function singleCheckOut($quantity_count, $product_id)
    {
        $product = Products::find($product_id);
        $order = Orders::create([
            'user_id' => Auth::user()->id,
            'status' => 'waiting_payment', // waiting_payment | failed | confirmed | delivery | finished
            'destination_address' => Auth::user()->address,
            'grand_total' => $quantity_count * $product->price // grand_total
        ]);
        OrderDetails::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity_count,
            'total' => $quantity_count * $product->price, // total
        ]);
        Products::find($product->id)
            ->decrement('stock', $quantity_count);
        return;
    }

    public static function orderExpired()
    {
        $orders = Orders::with('order_detail.product')->with('payment')
            ->where('status', 'waiting_payment')
            ->where('created_at', '<', Carbon::now()->subHours(24)) // Filters orders older than 24 hours
            ->get();
        foreach ($orders as $item) {
            foreach ($item->order_detail as $detail) {
                Products::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }
            Orders::where('id', $item->id)->update([
                'status' => 'cancelled',
            ]);
        }
    }
}
