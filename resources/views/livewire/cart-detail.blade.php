<div>
    <div class="modal-body overflow-auto" style="max-height: 75vh; scrollbar-width: none;">
        <div class="row">
            <div class="col-12 d-flex align-items-stretch flex-column">
                @foreach ($get_carts as $key => $cart)
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-body p-2 shadow">
                            <div class="row">
                                <div class="col-5 text-center">
                                    <img src="{{ asset('storage/' . $cart->product->image) }}" alt="user-avatar"
                                        class="img-fluid" style="object-fit: cover; width: 100%; height: 150px;">
                                </div>
                                <div class="col-7">
                                    <h2 class="lead"><b>{{ $cart->product->product_name }}</b></h2>
                                    <span class="text-muted text-sm"><b>Price : Rp. </b>
                                        {{ number_format($cart->product->price, 0, ',', '.') }}</span><br />
                                    <span class="text-muted text-sm"><b>Stock : </b>
                                        {{ $cart->product->stock }}</span><br />
                                    <span class="text-muted text-sm"><b>Total Price : </b>Rp.
                                        {{ number_format($price_qount[$key], 0, ',', '.') }}</span><br />
                                    <div class="py-1">
                                        <button class="btn btn-outline-dark btn-sm py-0"
                                            wire:click='cartCounter("{{ $key }}", -1)'>
                                            <span class="font-weight-bold mx-2">-</span>
                                        </button>
                                        <span class="mx-2">{{ $quantity_count[$key] }}</span>
                                        @php
                                            $disable = $quantity_count[$key] >= $cart->product->stock ? 'disabled' : '';
                                        @endphp
                                        <button {{ $disable }} class="btn btn-outline-dark btn-sm py-0"
                                            wire:click='cartCounter("{{ $key }}",1)'>
                                            <span class="font-weight-bold mx-2">+</span>
                                        </button>
                                    </div>
                                    <div class="mt-2 d-flex">
                                        @if ($quantity_count[$key] > $cart->product->stock)
                                            <button disabled class="btn btn-sm btn-block btn-outline-dark mr-2">
                                                <span class="font-weight-bold px-2">Checkout</span>
                                            </button>
                                        @else
                                            <button
                                                wire:click='singleCheckOut("{{ $key }}", "{{ $cart->id }}")'
                                                class="btn btn-sm btn-block btn-outline-dark mr-2">
                                                <span class="font-weight-bold px-2">Checkout</span>
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-dark"
                                            wire:click='cartDelete("{{ $cart->id }}")'>
                                            <div class="fas fa-trash"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted float-left text-lg"><b>Total payment : </b></span>
            <span class="text-muted"><b>Rp. {{ number_format($total_price, 0, ',', '.') }}</b></span>
        </div>
        @if (!empty($get_carts) && count($get_carts) > 0)
            <button wire:click='checkOutAll' type="button" class="btn btn-block btn-outline-dark my-2 text-lg">Checkout
                All</button>
        @endif
    </div>
</div>
