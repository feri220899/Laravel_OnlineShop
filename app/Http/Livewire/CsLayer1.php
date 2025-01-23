<?php

namespace App\Http\Livewire;

use App\Models\Orders;
use Livewire\Component;
use App\Models\Payments;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class CsLayer1 extends Component
{
    public $get_list_order;
    public $search;

    public function mount()
    {
        $this->search = '';
        $this->getListorder();
    }

    function updatedSearch() {
        $this->getListorder();
    }

    public function render()
    {
        $this->getListorder();
        return view('livewire.cs-layer1');
    }

    public function getListorder()
    {
        $this->get_list_order =  Orders::with('order_detail.product')->with('payment')->with('user')
            ->whereHas('order_detail.product', function ($query) {
                $query->whereRaw('LOWER(product_name) like ?', ['%' . strtolower($this->search) . '%']);
            })
            ->orWhereRaw('LOWER(status) like ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('LOWER(destination_address) like ?', ['%' . strtolower($this->search) . '%'])
            ->orWhereRaw('CAST(user_id AS CHAR) like ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'asc')
            ->get();
    }

    public function activiedPayment($order_id) {
        Payments::where('order_id', $order_id)->update([
            'status' => 'activated',
            'verified_by' => Auth::user()->id,
        ]);
        $this->getListorder();
    }

    public function cencelOrder($order_id)
    {
        $orders = Orders::with('order_detail.product')->with('payment')
            ->where('id', $order_id)
            ->get();
        foreach ($orders as $item) {
            foreach ($item->order_detail as $detail) {
                Products::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }
            Orders::where('id', $item->id)->update([
                'status' => 'cancelled',
            ]);
        }
        $this->getListorder();
    }
}
