<?php

namespace App\Http\Livewire;

use livewire;
use Carbon\Carbon;
use App\Models\Orders;
use Livewire\Component;
use App\Models\Payments;
use App\Models\Products;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderDetail extends Component
{
    use WithFileUploads;

    public $status;
    public $get_list_order;
    public $order_id;
    public $proof_image;

    protected $rules = [];

    public function rules()
    {
        return [
            'proof_image.' . $this->order_id => 'required|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->status = 'waiting_payment';
        $this->getListorder();
        $this->orderExpired();
    }

    public function tabOrder($type)
    {
        $this->status = $type;
        $this->getListorder();
    }

    public function setKey($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        return view('livewire.order-detail');
    }

    public function getListorder()
    {
        $this->get_list_order =  Orders::with('order_detail.product')->with('payment.user')
            ->where('status', $this->status)
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrder($order_id)
    {
        return Orders::where([
            'id' => $order_id,
            'user_id' => Auth::user()->id
        ]);
    }

    public function deleteItemOrder($order_id)
    {
        $order = $this->getOrder($order_id);
        foreach ($order->first()->order_detail as $order_detail) {
            Products::where('id', $order_detail->product_id)->increment('stock', $order_detail->quantity);
        }
        $order->update([
            'status' => 'cancelled',
        ]);
        $this->status = 'cancelled';
        $this->getListorder();
    }

    public function checkOutAll($order_id)
    {
        try {
            $this->validate();
            $proof_image_path = null;
            if (isset($this->proof_image[$order_id])) {
                $proof_image_path = $this->proof_image[$order_id]->storeAs('payments', $this->proof_image[$order_id]->getClientOriginalName(), 'public');
                $livewire_tmp_file = 'livewire-tmp/' . $this->proof_image[$order_id]->getFileName();
                Storage::delete($livewire_tmp_file);
            }
            Payments::create([
                'order_id' => $order_id,
                'payment_proof' =>  $proof_image_path,
                'status' =>  'pending',
                'verified_by' =>  null,
            ]);
            Orders::where('id', $order_id)->update([
                'status' => 'payment_success',
            ]);
            $this->status = 'payment_success';
            $this->getListorder();
        } catch (\Throwable $th) {
        }
    }

    public function receiveOrder($order_id) {
        Orders::where('id', $order_id)
        ->where( 'user_id', Auth::user()->id)
        ->update([
            'status' => 'order_completed',
        ]);
        $this->status = 'order_completed';
        $this->getListorder();
    }

    public function orderExpired()
    {
        $orders = Orders::with('order_detail.product')->with('payment')
            ->where([
                'user_id' => Auth::user()->id,
                'status' => 'waiting_payment',
            ])
            ->where('created_at', '<', Carbon::now()->subHours(24)) // Filters orders older than 24 hours
            ->get();
        foreach ($orders as $item) {
            foreach ($item->order_detail as $detail) {
                Products::where('id', $detail->product_id)->increment('stock', $detail->quantity);
            }
            $this->getOrder($item->id)->update([
                'status' => 'cancelled',
            ]);
        }
    }
}
