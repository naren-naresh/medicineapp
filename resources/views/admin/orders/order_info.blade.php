@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Orders Details</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders Details</li>
            </ol>
        </div>
    </div>
    <div class="row order-list mt-3 mb-5 w-100 bg-white p-3">
        <div class="order-details px-4 py-2">
            <div class="row justify-content-around align-items-center order-detail-header py-3 border-bottom">
                <h4 class="col-6 ps-4 mb-0">Order Details</h4>
                <a href="{{ route('orders.adminIndex') }}" class="col-6 text-end pe-4 text-decoration-none" style="font-size:16px; color:#385399"><i
                        class="fa fa-arrow-alt-circle-left"style="font-size:16px"></i> Back</a>
            </div>
            @foreach ($orderDetails as $orderDetail)
                <div class="row order-address-block py-4 border-bottom">
                    @php
                        $adminAddress = $addresses->where('customer_id', 1);
                        $customerAddress = $addresses->where('customer_id', $orderDetail->customer_id);
                        $orderStatus = $orderStatus->where('id', $orderDetail->order_status);
                        $zoneGroupId = $deliveryZone->where('postal_code', $customerAddress->value('postal_code'));
                        $deliveryFee = $deliveryFee->where('zone_group_id', $zoneGroupId->value('id'));
                    @endphp
                    <div class="col">
                        <h5>From</h5>
                        <address>
                            <strong>MEDICINE PLUS</strong>
                            <p class="my-1">{{ $adminAddress->value('address') }}</p>
                            <p class="mb-1">Postal Code : {{ $adminAddress->value('postal_code') }}</p>
                            <p class="mb-1">Phone : {{ $adminAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                    <div class="col">
                        <h5>Shipped To</h5>
                        <address>
                            <strong>{{ $customerAddress->value('name') }}</strong>
                            <p class="my-1">{{ $customerAddress->value('address') }}</p>
                            <p class="mb-1">Postal Code : {{ $customerAddress->value('postal_code') }}</p>
                            <p class="mb-1">Phone : {{ $customerAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                    <div class="col order-details-block">
                        <p class="mb-1"><span>Order ID :</span> {{ $orderDetail->id }}</p>
                        <p class="mb-1"><span>Order Date :</span>
                            {{ date('d-m-Y', strtotime($orderDetail->created_at)) }}</p>
                        <p class="mb-1"><span>Delivery Date :
                            </span>{{ date('d-m-Y', strtotime($orderDetail->created_at->addDays(2))) }} </p>
                        <p class="mb-1"><span>Order Status : </span> <span class="py-1 px-2"
                                style="background-color:{{ $orderStatus->value('bg_color_code') }};color:{{ $orderStatus->value('color_code') }};font-size:11px;border-radius:4px">Order
                                {{ $orderStatus->value('status') }}</span></p>
                    </div>
                </div>
                <div class="product-row row py-4">
                    <div class="table-responsive">
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
                                            <p class="mb-0">{{ $orderItem->product_name }}</p>
                                            <small style="color: #343333">#{{ $orderItem->product_sku }}</small>
                                            <br><small
                                                style="color: #343333">{{ $orderItem->product_variant_name }}</small>
                                        </td>
                                        <td><img src="{{ asset('assets/images/products/' . $orderItem->product_id . '/' . $orderItem->product_image . '') }}"
                                                style="width: 50px"></td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                ₹{{ $orderItem->retail_price }}</small>
                                            <p> ₹{{ $orderItem->selling_price }}</p>
                                        </td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td> ₹{{ $orderItem->total_amount }}</td>
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
                                {{ $orderDetail->total_amount }}</span></p>
                        <p class="mb-1 d-flex justify-content-between mb-2"><strong>Delivery Fee</strong><span> + ₹
                                {{ $deliveryFee->value('delivery_fee') }}</span></p>
                        <p class="mb-1 d-flex justify-content-between mb-3"><strong>Discount Amount</strong> <span
                                style="color: #385399">-₹ {{ $orderDetail->discount_amount }}</span></p>
                        <p class="d-flex justify-content-between border-top py-2"><strong>Total</strong> <span> ₹
                                {{ $orderDetail->final_payable_amount + $deliveryFee->value('delivery_fee') }} </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
