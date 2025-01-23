<?php

namespace App\Http\Livewire;

use App\Models\Carts;
use Livewire\Component;
use App\Models\Products;
use App\Services\BuyerServices;
use Illuminate\Support\Facades\Auth;

class BuyerPage extends Component
{
    public $list_products;
    public $get_carts;
    public $search;
    public $header;
    public $set_key;
    public $type_modal;
    public $quantity_count;
    public $total_price;

    function mount()
    {
        if (Auth::check() && Auth::user()->role == 'buyer') {
            $this->getCart();
        }
        $this->listProducts();
        $this->header = true;
        $this->quantity_count = '1';
    }

    public function updatedSearch()
    {
        $this->listProducts();
        $this->header = false;
    }

    public function setKey($key, $type)
    {
        $this->set_key = $key;
        $this->type_modal = $type;
        $this->quantity_count = '1';
    }

    public function eventModal()
    {
        $this->emitTo('cart-detail', 'updateData');
    }

    public function render()
    {
        return view('livewire.buyer-page');
    }

    public function listProducts()
    {
        $products = Products::where(function ($query) {
            $query->orWhereRaw('LOWER(product_name) like ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereRaw('LOWER(category) like ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereRaw('LOWER(description) like ?', ['%' . strtolower($this->search) . '%']);
        })->orderBy('id', 'asc')
            ->get();
        $this->list_products = $products;
    }

    public function getCart()
    {
        $this->get_carts = Carts::where('user_id', Auth::user()->id)->get();
    }

    public function quantityCounter($condition)
    {
        $this->quantity_count = max(1, $this->quantity_count + $condition);
    }

    public function singleAddCart($key)
    {
        try {
            $cart = Carts::where([
                'user_id' => Auth::user()->id,
                'product_id' => $this->list_products[$key]->id,
            ])->first();
            if ($cart) {
                session()->flash('error' . $key, 'The product is already in carts!');
            } else {
                Carts::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $this->list_products[$key]->id,
                    'quantity' =>  $this->quantity_count,
                ]);
                $this->getCart();
                $this->quantity_count = '1';
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function singleCheckOut($key)
    {
        try {
            BuyerServices::singleCheckOut($this->quantity_count, $this->list_products[$key]->id);
            $this->flashMessage('Order placed successfully!', 'success');
            return redirect()->route('order');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function flashMessage($message, $message_type)
    {
        session()->flash('message', $message);
        session()->flash('message_type', $message_type);
    }
}
