@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <a href="{{ route('orders.adminIndex') }}" class="col-6 text-end text-decoration-none"
                style="font-size:16px; color:#385399"><i class="fa fa-arrow-alt-circle-left"style="font-size:16px"></i>
                Back</a>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders Details</li>
            </ol>
        </div>
    </div>
    @foreach ($orderDetails as $orderDetail)
        <div class="row order-list mt-3 mb-5 w-100 bg-white px-4 pb-3 ">
            <div class="order-details py-2">
                <div class="row justify-content-around align-items-center order-detail-header py-3 border-bottom">
                    <div class="heading col-6 d-flex">
                        <h4 class="mb-0">Order Details</h4>
                    </div>
                    <div class="action_block col-6 text-end">
                        <button type="button" class="btn d-none" id="process_btn">Make Process</button>
                        <a href="{{ route('order.invoice', $orderDetail->customer_id) }}"
                                class=" text-decoration-none btn ms-1"><i class="fa fa-print"></i> Print Invoice</a>&nbsp;
                            <snap class="cancel"><i class="fa fa-cancel"></i> Cancel</snap>
                    </div>
                </div>
                <div class="row order-address-block py-4 border-bottom">
                    @php
                        $adminAddress = $addresses->where('customer_id', 1);
                        $customerAddress = $addresses->where('customer_id', $orderDetail->customer_id);
                        $orderStatus = $orderStatus->where('id', $orderDetail->order_status);
                        $zoneGroupId = $deliveryZone->where('postal_code', $customerAddress->value('postal_code'));
                        $deliveryFee = $deliveryFee->where('zone_group_id', $zoneGroupId->value('id'));
                    @endphp
                    <div class="col">
                        <h5>MEDICINE PLUS</h5>
                        <address>
                            <p class="my-1">{{ $adminAddress->value('address') }}</p>
                            <p class="mb-1">Postal Code : {{ $adminAddress->value('postal_code') }}</p>
                            <p class="mb-1">Phone : {{ $adminAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                    <div class="col">
                        <h5>Delivered To</h5>
                        <address>
                            <strong>{{ $customerAddress->value('name') }}</strong>
                            <p class="my-1">{{ $customerAddress->value('address') }}</p>
                            <p class="mb-1">Postal Code : {{ $customerAddress->value('postal_code') }}</p>
                            <p class="mb-1">Phone : {{ $customerAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                    <div class="col order-details-block">
                        <p class="mb-1"><span>Order ID :</span> {{ $orderDetail->order_number }}</p>
                        <p class="mb-1"><span>Order Date :</span>
                            {{ date('d-m-Y', strtotime($orderDetail->created_at)) }}</p>
                        <p class="mb-1"><span>Delivery Date :
                            </span>{{ date('d-m-Y', strtotime($orderDetail->created_at->addDays(2))) }} </p>
                        <p class="mb-1"><span>Order Status : </span> <span class="py-1 px-2" id="order_status"
                                style="background-color:{{ $orderStatus->value('bg_color_code') }};color:{{ $orderStatus->value('color_code') }};font-size:11px;border-radius:4px">
                                {{ $orderStatus->value('status') }}</span></p>
                    </div>
                </div>
                {{-- <div class="invoice-block row justify-content-between mt-5">
                    <div class="seller-detail col-3 ps-2">
                        <p><strong>Seller Name :</strong> MEDICINE PLUS.</p>
                    </div>
                </div> --}}
                <div class="product-row row py-4 ">
                    <div class="table-responsive p-0">
                        <table class="table table-borderless">
                            <thead>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @php
                                    $orderItems = $orderItems->where('order_id', $orderDetail->id);
                                @endphp
                                @foreach ($orderItems as $orderItem)
                                    <tr class="table-light border-bottom border-top">
                                        <td style="width: 400px">
                                            <div class="name-block d-flex">
                                                <p class="mb-0" style="width:250px" id ="product_name"><span
                                                        title="{{ $orderItem->product_name }}">{{ $orderItem->product_name }}
                                                    </span></p><small style="color: #343333">( SKU :
                                                    {{ $orderItem->product_sku }} )</small>
                                            </div>
                                            <small style="color: #343333">{{ $orderItem->product_variant_name }}</small>
                                        </td>
                                        <td><img src="{{ asset('assets/images/products/' . $orderItem->product_id . '/' . $orderItem->product_image . '') }}"
                                                style="width: 50px"></td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                ₹{{ number_format($orderItem->retail_price, 2) }}</small>
                                            <p> ₹{{ number_format($orderItem->selling_price, 2) }}</p>
                                        </td>
                                        <td>
                                            <p></p>
                                            <p class="pt-2">{{ $orderItem->quantity }}</p>
                                        </td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                ₹{{ number_format($orderItem->quantity * $orderItem->retail_price, 2) }}</small>
                                            <p>₹{{ number_format($orderItem->total_amount, 2) }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="payment-details-row row">
                    <div class="col">
                        <p class="mb-2"><strong>PayMent Status :
                            </strong><span>{{ $payments->where('order_id', $orderDetail->id)->value('payment_status') }}</span>
                        </p>
                        <p class="mb-2"><strong>Payment Method : </strong><span style="color: #343333">
                                @if ($payments->where('order_id', $orderDetail->id)->value('payment_method') == 1)
                                    Pay On Delivery
                                @elseif($payments->where('order_id', $orderDetail->id)->value('payment_method') == 0)
                                    Card
                                @endif
                            </span></p>
                        <p><strong>Paid Date :
                            </strong><span>{{ date('d-M-Y h:i A', strtotime($payments->where('order_id', $orderDetail->id)->value('date_time'))) }}</span>
                        </p>

                    </div>
                    <div class="col">
                        <p class="mb-1 d-flex justify-content-between mb-2"><strong>Sub Total</strong><span> ₹
                                {{ number_format($orderDetail->total_amount, 2) }}</span></p>
                        <p class="mb-1 d-flex justify-content-between mb-2"><strong>Delivery Fee</strong><span>+ ₹
                                {{ number_format($deliveryFee->value('delivery_fee') ?? 0, 2) }}</span></p>
                        <p class="mb-1 d-flex justify-content-between mb-3"><strong>Discount Amount</strong> <span
                                style="color: #385399">-₹ {{ number_format($orderDetail->discount_amount, 2) }}</span></p>
                        <p class="d-flex justify-content-between border-top py-2"><strong>Total</strong> <span> ₹
                                {{ number_format($orderDetail->final_payable_amount + $deliveryFee->value('delivery_fee'), 2) }}
                            </span>
                        </p>
                    </div>
                </div>
                <input type="hidden" name="status-change" id="status-change" value = "{{ $orderDetail->status_change }}"
                    orderId={{ $orderDetail->id }}>
    @endforeach
    </div>
    </div>
    <style>
        #product_name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        #product_name:hover {
            cursor: pointer;
        }
        .cancel{
            background-color: red;
            color: #fff;
            padding: 7px 10px 9px 10px ;
            border: 1px solid red;
            border-radius: 3px !important;
        }
        .cancel:hover{
            background-color: #fff;
            color: red;

        }
    </style>
@endsection
@pushOnce('scripts')
    <script>
        $(document).ready(function() {
            /* csrf token*/
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

            var change = $('#status-change').val();
            var orderId = $('#status-change').attr('orderId');
            if (change == 0) {
                setTimeout(function() {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Process this order.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#385399",
                        cancelButtonColor: "#202020",
                        confirmButtonText: "Yes, process it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            processAjax(change, orderId);
                            Swal.fire({
                                title: "Processing!",
                                text: "Order in process.",
                                icon: "success",
                                confirmButtonColor: "#385399",
                            });
                        } else {
                            $('#process_btn').removeClass('d-none');
                        }
                    });
                }, 5000);
            }
            // process btn functionality
            $('#process_btn').click(function() {
                var change = $('#status-change').val();
                var orderId = $('#status-change').attr('orderId');
                if (change == 0) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Process this order.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#385399",
                        cancelButtonColor: "#202020",
                        confirmButtonText: "Yes, process it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            processAjax(change, orderId);
                            Swal.fire({
                                title: "Processing!",
                                text: "Order in process.",
                                icon: "success",
                                confirmButtonColor: "#385399",
                            });
                            $('#process_btn').addClass('d-none');
                        }
                    });
                }
            });

            function processAjax(change, orderId) {
                $.ajax({
                    type: "post",
                    url: "{{ route('orders.changeStatus') }}",
                    data: {
                        status_change: change,
                        order_id: orderId,
                    },
                    success: function(response) {
                        if (response.data == true) {
                            $("#order_status").html('Processing');
                            $("#order_status").css('color', '#fff');
                            $("#order_status").css('background-color', '#2DCCFF');
                        }
                    }
                });
            }
        });
    </script>
@endPushOnce
