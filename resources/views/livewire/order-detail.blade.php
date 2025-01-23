<div>
    @if (session()->has('message'))
        <div class="alert alert-{{ session('message_type') }}">
            {{ session('message') }}
        </div>
    @endif
    <section class="content">
        <div class="card my-2">
            <div class="card-body">
                <h4 class="text-center">Orders</h4>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    @php
                        $waiting_payment = $status == 'waiting_payment' ? 'show active' : '';
                        $payment_success = $status == 'payment_success' ? 'show active' : '';
                        $verified = $status == 'verified' ? 'show active' : '';
                        $order_completed = $status == 'order_completed' ? 'show active' : '';
                        $cancelled = $status == 'cancelled' ? 'show active' : '';
                    @endphp
                    <li class="nav-item text-center" style="width: 20%">
                        <a wire:click='tabOrder("waiting_payment")' style="color: black; font-weight: bold;"
                            class="nav-link {{ $waiting_payment }}" id="waiting-payment-tab" data-toggle="pill"
                            href="#waiting-payment" role="tab" aria-controls="waiting-payment"
                            aria-selected="true">Payment</a>
                    </li>
                    <li class="nav-item text-center" style="width: 20%">
                        <a wire:click='tabOrder("payment_success")' style="color: black; font-weight: bold;"
                            class="nav-link {{ $payment_success }}" id="being-packaged-tab" data-toggle="pill"
                            href="#being-packaged" role="tab" aria-controls="being-packaged"
                            aria-selected="false">Being-packaged</a>
                    </li>
                    <li class="nav-item text-center" style="width: 20%">
                        <a wire:click='tabOrder("verified")' style="color: black; font-weight: bold;"
                            class="nav-link {{ $verified }}" id="order-sent-tab" data-toggle="pill"
                            href="#order-sent" role="tab" aria-controls="order-sent"
                            aria-selected="false">Order-Sent</a>
                    </li>
                    <li class="nav-item text-center" style="width: 20%">
                        <a wire:click='tabOrder("order_completed")' style="color: black; font-weight: bold;"
                            class="nav-link {{ $order_completed }}" id="order-completed-tab" data-toggle="pill"
                            href="#order-completed" role="tab" aria-controls="order-completed"
                            aria-selected="false">Finised</a>
                    </li>
                    <li class="nav-item text-center" style="width: 20%">
                        <a wire:click='tabOrder("cancelled")' style="color: black; font-weight: bold;"
                            class="nav-link {{ $cancelled }}" id="cancelled-tab" data-toggle="pill" href="#cancelled"
                            role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                    </li>
                </ul>
                <div class="tab-content overflow-auto" id="custom-content-below-tabContent"
                    style="height: 80vh; max-height: 80vh; scrollbar-width: none;">
                    <div class="tab-pane fade {{ $waiting_payment }}" id="waiting-payment" role="tabpanel"
                        aria-labelledby="waiting-payment-tab" style="width: 55vw;">
                        @if ($get_list_order->isEmpty())
                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <div class="card-body text-center">
                                        <h2><i class="text-muted fas fa-clipboard-list"></i></h2>
                                        <p class="card-text text-muted mb-3">At this time you do not have an order</p>
                                        <a href="{{ route('buyer') }}" class="btn btn-outline-dark btn-sm">Back</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($get_list_order as $order)
                                <div>
                                    <div class="card d-flex flex-fill shadow-md mx-5 my-3">
                                        <div class="d-flex justify-content-between mx-2 my-1">
                                            <span class="align-self-center text-muted">
                                                Order Number : {{ $order->id }}
                                                <i class="fas fa-clock ml-4"></i> {{ $order->created_at }}
                                            </span>
                                            @if ($order->payment)
                                                <i class="float-right text-lg fas fa-check"></i>
                                                </button>
                                            @else
                                                <button class="btn float-right btn-sm btn-outline-dark"
                                                    wire:click='deleteItemOrder("{{ $order->id }}")'>
                                                    <div class="fas fa-trash"></div>
                                                </button>
                                            @endif
                                        </div>
                                        @foreach ($order->order_detail as $order_detail)
                                            <div class="card-body bg-light m-2 p-2">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <img src="{{ asset('storage/' . $order_detail->product->image) }}"
                                                            alt="user-avatar" class="img-fluid"
                                                            style="object-fit: cover; width: 100%; height: 150px;">
                                                    </div>
                                                    <div class="col-6 align-self-center">
                                                        <h2 class="lead">
                                                            <b>{{ $order_detail->product->product_name }}</b>
                                                        </h2>
                                                        <span class="text-muted text-sm"><b>Price : Rp. </b>
                                                            {{ number_format($order_detail->product->price, 0, ',', '.') }}
                                                            X
                                                            {{ $order_detail->quantity }}</span><br />
                                                        <span class="text-muted"><b>Total Price : Rp.
                                                                {{ number_format($order_detail->total, 0, ',', '.') }}</b></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted float-left text-lg"><b>Total payment :
                                                    </b></span>
                                                <span class="text-muted"><b>Rp.
                                                        {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </b></span>
                                            </div>
                                            @if ($order->payment)
                                                <span class=" text-muted my-2 text-lg">Payment Successful</span>
                                            @else
                                                <button wire:click='setKey({{ $order->id }})' type="button"
                                                    data-toggle="modal" data-target="#OrderModal"
                                                    class="btn btn-block btn-outline-dark my-2 text-lg">Pay Now
                                                </button>
                                            @endif
                                            @error('proof_image.' . $order->id)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="tab-pane fade {{ $payment_success }}" id="being-packaged" role="tabpanel"
                        aria-labelledby="being-packaged-tab" style="width: 55vw;">
                        @if ($get_list_order->isEmpty())
                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <div class="card-body text-center">
                                        <h2><i class="text-muted fas fa-box"></i></h2>
                                        <p class="card-text text-muted mb-3">You currently do not have any paid orders
                                        </p>
                                        <a href="{{ route('buyer') }}" class="btn btn-outline-dark btn-sm">Back</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($get_list_order as $order)
                                <div>
                                    <div class="card d-flex flex-fill shadow-md mx-5 my-3">
                                        <div class="d-flex justify-content-between mx-2 my-1">
                                            <span class="align-self-center">Order Number : {{ $order->id }} </span>
                                            <i class="float-right text-lg fas fa-box"></i>
                                        </div>
                                        @foreach ($order->order_detail as $order_detail)
                                            <div class="card-body bg-light m-2 p-2">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <img src="{{ asset('storage/' . $order_detail->product->image) }}"
                                                            alt="user-avatar" class="img-fluid"
                                                            style="object-fit: cover; width: 100%; height: 150px;">
                                                    </div>
                                                    <div class="col-6 align-self-center">
                                                        <h2 class="lead">
                                                            <b>{{ $order_detail->product->product_name }}</b>
                                                        </h2>
                                                        <span class="text-muted text-sm"><b>Price : Rp. </b>
                                                            {{ number_format($order_detail->product->price, 0, ',', '.') }}
                                                            X
                                                            {{ $order_detail->quantity }}</span><br />
                                                        <span class="text-muted"><b>Total Price : Rp.
                                                                {{ number_format($order_detail->total, 0, ',', '.') }}</b></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="card-footer">
                                            @if ($order->payment)
                                                @if ($order->payment->status == 'pending')
                                                    <span class=" text-danger my-2 text-lg"><b>Payment is complete,
                                                            waiting for admin to confirm payment</b></span>
                                                @else
                                                    <span class=" text-success my-2 text-lg"><b>Order Activated By :
                                                            {{ $order->payment->user->email }}</b></span>
                                                @endif
                                            @endif
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted float-left"><b>Total payment :
                                                    </b></span>
                                                <span class="text-muted"><b>Rp.
                                                        {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </b></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="tab-pane fade {{ $verified }}" id="order-sent" role="tabpanel"
                        aria-labelledby="order-sent-tab" style="width: 55vw;">
                        @if ($get_list_order->isEmpty())
                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <div class="card-body text-center">
                                        <h2><i class="text-muted fas fa-shipping-fast"></i></h2>
                                        <p class="card-text text-muted mb-3">You currently do not have any orders being
                                            shipped</p>
                                        <a href="{{ route('buyer') }}" class="btn btn-outline-dark btn-sm">Back</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                @foreach ($get_list_order as $order)
                                    <div class="card d-flex flex-fill shadow-md mx-5 my-3">
                                        <div class="d-flex justify-content-between mx-2 my-1">
                                            <span class="align-self-center">Order Number : {{ $order->id }} </span>
                                            <i class="float-right text-lg fas fa-shipping-fast"></i>
                                        </div>
                                        @foreach ($order->order_detail as $order_detail)
                                            <div class="card-body bg-light m-2 p-2">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <img src="{{ asset('storage/' . $order_detail->product->image) }}"
                                                            alt="user-avatar" class="img-fluid"
                                                            style="object-fit: cover; width: 100%; height: 150px;">
                                                    </div>
                                                    <div class="col-6 align-self-center">
                                                        <h2 class="lead">
                                                            <b>{{ $order_detail->product->product_name }}</b>
                                                        </h2>
                                                        <span class="text-muted text-sm"><b>Price : Rp. </b>
                                                            {{ number_format($order_detail->product->price, 0, ',', '.') }}
                                                            X
                                                            {{ $order_detail->quantity }}</span><br />
                                                        <span class="text-muted"><b>Total Price : Rp.
                                                                {{ number_format($order_detail->total, 0, ',', '.') }}</b></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="card-footer">
                                            @if ($order->payment)
                                                <span class=" text-success my-2 text-lg">
                                                    <b>
                                                        <i class="text-lg fas fa-shipping-fast"></i> Order is being
                                                        shipped
                                                    </b>
                                                </span>
                                            @endif
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted float-left">
                                                    <b>
                                                        Total payment :
                                                    </b>
                                                </span>
                                                <span class="text-muted">
                                                    <b>Rp. {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </b>
                                                </span>
                                            </div>
                                            <button wire:click='receiveOrder({{ $order->id }})' type="button"
                                                class="btn btn-block btn-outline-dark my-2 text-lg">Receive Order
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade {{ $order_completed }}" id="order-completed" role="tabpanel"
                        aria-labelledby="order-completed-tab" style="width: 55vw;">
                        @if ($get_list_order->isEmpty())
                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <div class="card-body text-center">
                                        <h2><i class="text-muted fas fa-clipboard-check"></i></h2>
                                        <p class="card-text text-muted mb-3">You currently do not have any completed
                                            orders</p>
                                        <a href="{{ route('buyer') }}" class="btn btn-outline-dark btn-sm">Back</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                @foreach ($get_list_order as $order)
                                    <div class="card d-flex flex-fill shadow-md mx-5 my-3">
                                        <div class="d-flex justify-content-between mx-2 my-1">
                                            <span class="align-self-center">Order Number : {{ $order->id }} </span>
                                            <i class="float-right text-lg fas fa-check"></i>
                                        </div>
                                        @foreach ($order->order_detail as $order_detail)
                                            <div class="card-body bg-light m-2 p-2">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <img src="{{ asset('storage/' . $order_detail->product->image) }}"
                                                            alt="user-avatar" class="img-fluid"
                                                            style="object-fit: cover; width: 100%; height: 150px;">
                                                    </div>
                                                    <div class="col-6 align-self-center">
                                                        <h2 class="lead">
                                                            <b>{{ $order_detail->product->product_name }}</b>
                                                        </h2>
                                                        <span class="text-muted text-sm"><b>Price : Rp. </b>
                                                            {{ number_format($order_detail->product->price, 0, ',', '.') }}
                                                            X
                                                            {{ $order_detail->quantity }}</span><br />
                                                        <span class="text-muted"><b>Total Price : Rp.
                                                                {{ number_format($order_detail->total, 0, ',', '.') }}</b></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted float-left">
                                                    <b>
                                                        Total payment :
                                                    </b>
                                                </span>
                                                <span class="text-muted">
                                                    <b>Rp. {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </b>
                                                </span>
                                            </div>
                                            @if ($order->payment)
                                                <span class=" text-success my-2 text-lg">
                                                    <b>
                                                        <i class="text-lg fas fa-check"></i> Order completed
                                                    </b>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade {{ $cancelled }}" id="cancelled" role="tabpanel"
                        aria-labelledby="cancelled-tab" style="width: 55vw;">
                        @if ($get_list_order->isEmpty())
                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <div class="card-body text-center">
                                        <h2><i class="text-muted fas fa-ban"></i></h2>
                                        <p class="card-text text-muted mb-3">You currently do not have any completed
                                            orders</p>
                                        <a href="{{ route('buyer') }}" class="btn btn-outline-dark btn-sm">Back</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                @foreach ($get_list_order as $order)
                                    <div class="card d-flex flex-fill shadow-md mx-5 my-3">
                                        <div class="d-flex justify-content-between mx-2 my-1">
                                            <span class="align-self-center">Order Number : {{ $order->id }} </span>
                                            <i class="float-right text-lg fas fa-ban"></i>
                                        </div>
                                        @foreach ($order->order_detail as $order_detail)
                                            <div class="card-body bg-light m-2 p-2">
                                                <div class="row">
                                                    <div class="col-5 text-center">
                                                        <img src="{{ asset('storage/' . $order_detail->product->image) }}"
                                                            alt="user-avatar" class="img-fluid"
                                                            style="object-fit: cover; width: 100%; height: 150px;">
                                                    </div>
                                                    <div class="col-6 align-self-center">
                                                        <h2 class="lead">
                                                            <b>{{ $order_detail->product->product_name }}</b>
                                                        </h2>
                                                        <span class="text-muted text-sm"><b>Price : Rp. </b>
                                                            {{ number_format($order_detail->product->price, 0, ',', '.') }}
                                                            X
                                                            {{ $order_detail->quantity }}</span><br />
                                                        <span class="text-muted"><b>Total Price : Rp.
                                                                {{ number_format($order_detail->total, 0, ',', '.') }}</b></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted float-left">
                                                    <b>
                                                        Total payment :
                                                    </b>
                                                </span>
                                                <span class="text-muted">
                                                    <b>Rp. {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </b>
                                                </span>
                                            </div>
                                            <span class=" text-danger my-2 text-lg">
                                                <b>
                                                    <i class="text-lg fas fa-ban"></i> Order cancelled
                                                </b>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal Payment --}}
    <div class="modal fade" id="OrderModal" tabindex="-10" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <div class="row">
                                <div class="col-12">
                                    <p class="lead">Payment Methods:</p>
                                    <img class="img" style="max-height: 90px; max-width: 120px"
                                        src="{{ asset('img/bri.png') }}" alt="Visa">
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        2312445566323223 <i style="cursor: pointer;" class="mx- 2 fas fa-copy"
                                            onclick="copyToClipboard('2312445566323223')"></i>
                                    </p>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="file" wire:model="proof_image.{{ $order_id }}"
                                                style="border: 1px solid #545554; border-radius: 5px; padding: 8px;
                                                   font-size: 14px; color: #333; background-color: #f9f9f9;
                                                   cursor: pointer; width: 100%; box-sizing: border-box;" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button wire:click='checkOutAll({{ $order_id }})' type="button"
                                            class="btn btn-primary" data-dismiss="modal">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert("Number copied successfully: " + text);
                }).catch(() => {
                    alert("Error.");
                });
            }
        </script>
    @endpush
</div>
