<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Carts;
use App\Models\Orders;
use Livewire\Component;
use App\Models\Products;
use App\Models\OrderDetails;
use App\Services\BuyerServices;
use Illuminate\Support\Facades\Auth;

class CartDetail extends Component
{
    public $get_carts;
    public $quantity_count = [];
    public $price_qount = [];
    public $total_price;

    protected $listeners = ['updateData' => 'mount'];

    public function mount()
    {
        $this->getCart();
        foreach ($this->get_carts as $key => $cart) {
            $this->quantity_count[$key] = $cart->quantity;
            $this->price_qount[$key] = $cart->product->price * $this->quantity_count[$key];
        }
        $this->total_price = array_sum($this->price_qount);
    }

    public function render()
    {
        return view('livewire.cart-detail');
    }

    public function getCart()
    {
        $this->get_carts = Carts::with('product')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function cartCounter($key, $value)
    {
        $this->quantity_count[$key] = max(0, $this->quantity_count[$key] + $value);
        if ($this->quantity_count[$key] === 0) {
            $this->cartDelete($this->get_carts[$key]->id);
            return;
        }
        if ($this->quantity_count[$key] <= $this->get_carts[$key]->product->stock) {
            $cart = Carts::firstOrNew([
                'user_id' => Auth::user()->id,
                'id' => $this->get_carts[$key]->id,
            ]);
            $cart->quantity = $this->quantity_count[$key];
            $cart->save();
            $this->price_qount[$key] = $this->get_carts[$key]->product->price * $this->quantity_count[$key];
            $this->total_price = array_sum($this->price_qount);
        }
    }

    public function cartDelete($cart_id)
    {
        try {
            Carts::where([
                'user_id' => Auth::user()->id,
                'id' => $cart_id,
            ])->delete();
            $this->quantity_count = [];
            $this->price_qount = [];
            $this->mount();
            $this->total_price = array_sum($this->price_qount);
        } catch (\Throwable $th) {
        }
    }

    public function singleCheckOut($key, $cart_id)
    {
        try {
            BuyerServices::singleCheckOut($this->quantity_count[$key], $this->get_carts[$key]->product->id);
            $this->cartDelete($cart_id);
            $this->flashMessage('Order placed successfully!', 'success');
            return redirect()->route('order');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function checkOutAll()
    {
        try {
            $order = Orders::create([
                'user_id' => Auth::user()->id,
                'status' => 'waiting_payment', // waiting_payment | failed | confirmed | delivery | finished
                'destination_address' => Auth::user()->address,
                'grand_total' => $this->total_price // grand_total
            ]);
            foreach ($this->get_carts as $value) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $value->product->id,
                    'quantity' => $value->quantity,
                    'total' => $value->product->price * $value->quantity,
                ]);
                Carts::where([
                    'user_id' => Auth::user()->id,
                    'id' =>  $value->id,
                ])->delete();
                Products::find($value->product->id)
                    ->decrement('stock', $value->quantity);
            }
            $this->flashMessage('Order placed successfully!', 'success');
            return redirect()->route('order');
        } catch (\Throwable $th) {
        }
    }

    public function flashMessage($message, $message_type)
    {
        session()->flash('message', $message);
        session()->flash('message_type', $message_type);
    }
}
