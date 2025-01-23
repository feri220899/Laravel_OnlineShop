<?php

namespace App\Http\Livewire;

use App\Models\Orders;
use Livewire\Component;
use App\Models\Payments;

class CsLayer2 extends Component
{
    public $get_list_order;
    public $search;

    public function mount()
    {
        $this->search = '';
        $this->getListorder();
    }

    function updatedSearch()
    {
        $this->getListorder();
    }
    public function render()
    {
        return view('livewire.cs-layer2');
    }

    public function getListorder()
    {
        $this->get_list_order =  Orders::with('order_detail.product')->with('payment')->with('user')
            ->whereIn('status', ['payment_success', 'verified', 'order_completed'])
            ->where(function ($query) {
                $query->whereHas('order_detail.product', function ($query) {
                    $query->whereRaw('LOWER(product_name) like ?', ['%' . strtolower($this->search) . '%']);
                })
                ->orWhereRaw('LOWER(status) like ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereRaw('LOWER(destination_address) like ?', ['%' . strtolower($this->search) . '%'])
                ->orWhereRaw('CAST(user_id AS CHAR) like ?', ['%' . strtolower($this->search) . '%']);
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    public function activiedPayment($order_id) {
        Orders::where('id', $order_id)->update([
            'status' => 'verified',
        ]);
        $this->getListorder();
    }
}
