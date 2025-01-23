<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model='search' type="text" name="table_search" class="form-control float-right"
                                placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive px-2 py-0" style="height: 600px;">
                    <table class="table table-sm table-bordered table-hover table-head-fixed p-3 text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order Id</th>
                                <th>Items</th>
                                <th>User Id</th>
                                <th>Buyer</th>
                                <th>Status</th>
                                <th class="text-center">Payment</th>
                                <th>Grand total</th>
                                <th class="text-center">Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_list_order as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->order_detail as $order_detail)
                                                <li>{{ $order_detail->product->product_name }} </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @php
                                            $statusIcons = [
                                                'waiting_payment' => [
                                                    'icon' => 'fa-hourglass-start',
                                                    'color' => 'text-warning',
                                                    'title' => 'Waiting Payment',
                                                ],
                                                'payment_success' => [
                                                    'icon' => 'fa-check-circle',
                                                    'color' => 'text-success',
                                                    'title' => 'Payment Success',
                                                ],
                                                'verified' => [
                                                    'icon' => 'fa-shield-alt',
                                                    'color' => 'text-primary',
                                                    'title' => 'Verified',
                                                ],
                                                'order_completed' => [
                                                    'icon' => 'fa-box',
                                                    'color' => 'text-info',
                                                    'title' => 'Order Completed',
                                                ],
                                                'cancelled' => [
                                                    'icon' => 'fa-times-circle',
                                                    'color' => 'text-danger',
                                                    'title' => 'Cancelled',
                                                ],
                                            ];
                                            $status = $statusIcons[$item->status] ?? [
                                                'icon' => 'fa-question-circle',
                                                'color' => 'text-muted',
                                                'title' => 'Unknown Status',
                                            ];
                                        @endphp
                                        <i class="fas {{ $status['icon'] }} {{ $status['color'] }}" title=""></i>
                                        <span class="{{ $status['color'] }}">{{ $status['title'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->payment)
                                            <div class="dropdown">
                                                <i class="text-success text-lg far fa-eye" data-toggle="dropdown"
                                                    style="cursor: pointer;"></i>
                                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <div class="media">
                                                        <img src="{{ Storage::url($item->payment->payment_proof) }}"
                                                            alt="Payment Proof"
                                                            style="max-width: 200px; max-height: 150px;" />
                                                    </div><br>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>Rp. {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($item->payment)
                                            @if ($item->payment->status == 'activated')
                                                <i class="fas fa-check text-success mx-2"></i> Activated
                                            @else
                                                @if ($item->status == 'payment_success')
                                                    <button wire:click='activiedPayment({{ $item->id }})'
                                                        class="btn btn-xs btn-outline-dark mx-2">Activate</button>
                                                @endif
                                            @endif
                                        @else
                                            @if ($item->payment)
                                                @if ($item->payment->status == 'activated')
                                                    @if ($item->status == 'waiting_payment')
                                                        <button wire:click='activiedPayment({{ $item->id }})'
                                                            class="btn btn-xs btn-outline-dark mx-2">Activate</button>
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($item->status != 'cancelled')
                                                <button wire:click='cencelOrder({{ $item->id }})'
                                                    class="btn btn-xs btn-outline-dark mx-2">Cancel</button>
                                            @endif
                                            @if ($item->status == 'cancelled')
                                                <i class="fas fa-ban text-danger mx-2"></i>Cancelled
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
