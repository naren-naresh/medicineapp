<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <!-- Meta Title -->
    <title>Medicine Plus | @yield('meta-title', 'Dashboard')</title>
    <!-- csrf token -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Layout Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
</head>

<body>
    <section class="invoice my-5">
        <div class="container">
            @foreach ($data['orderDetails'] as $orderDetail)
                @php
                    $adminAddress = $data['addresses']->where('customer_id', 1);
                    $customerAddress = $data['addresses']->where('customer_id', $orderDetail->customer_id);
                    $orderStatus = $data['orderStatus']->where('id', $orderDetail->order_status);
                    $zoneGroupId = $data['deliveryZone']->where('postal_code', $customerAddress->value('postal_code'));
                    $deliveryFee = $data['deliveryFee']->where('zone_group_id', $zoneGroupId->value('id'));
                @endphp
                <div class="header row justify-content-between" style="border-bottom: 2px solid #000">
                    <div class="image-section col-3">
                        <img src="{{  public_path('assets/images/logo.png')}}" style="width:100px">
                        <p class="pt-2 mb-0">Thank You!</p>
                        <p><small>for shopping at</small></p>
                    </div>
                    <div class="header-content col-3 text-end">
                        <p><strong>Tax Invoice</strong></p>
                    </div>
                </div>
                <div class="barcode-section row justify-content-between py-2" style="border-bottom: 2px solid #000">
                    <div class="company-address-section col-6">
                        <address>
                            <p class="my-1">{{ $adminAddress->value('address') }}</p>
                            <p class="mb-1">Postal Code : {{ $adminAddress->value('postal_code') }}</p>
                            <p class="mb-1">Phone : {{ $adminAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                    <div class="barcode-content col-6">
                    </div>
                </div>
                <div class="order-details-section row justify-content-between py-2" style="border-bottom: 2px solid #000">
                    <div class="detail-content col-6">
                        <p class="mb-1"><strong>Order Id :</strong> {{ $orderDetail->order_number }}</p>
                        <p class="mb-1"><strong>Order Date :</strong> {{ date('d M, Y h:m A',strtotime($orderDetail->created_at)) }}</p>
                        <p class="mb-1"><strong>Invoice No :</strong> </p>
                        <p class="mb-1"><strong>Invoice Date :</strong> </p>
                    </div>
                    <div class="ship-to col-6">
                        <address>
                            <p class="mb-1"><strong>Ship To</strong></p>
                            <p class="mb-1"><strong>Postal Code :</strong> {{ $customerAddress->value('postal_code') }}</p>
                            <p class="mb-1"><strong>Mobile :</strong> {{ $customerAddress->value('contact_number') }}</p>
                        </address>
                    </div>
                </div>
                <div class="product-row row py-2" style="border-bottom: 2px solid #000">
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
                                    $orderItems = $data['orderItems']->where('order_id', $orderDetail->id);
                                @endphp
                                @foreach ($orderItems as $orderItem)
                                    <tr class="table-light border-bottom border-top">
                                        <td style="width: 400px">
                                            <p class="mb-0">{{ $orderItem->product_name }} ( <small
                                                    style="color: #343333">SKU : {{ $orderItem->product_sku }}</small>)
                                            </p>
                                            <small
                                                style="color: #343333">{{ $orderItem->product_variant_name }}</small>
                                        </td>
                                        <td><img src="{{ public_path('/assets/images/products/'.$orderItem->product_id.'/'.$orderItem->product_image.'')}}"
                                                style="width: 50px"></td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                ₹{{ $orderItem->retail_price }}</small>
                                            <p> ₹{{ $orderItem->selling_price }}</p>
                                        </td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                ₹{{ $orderItem->quantity * $orderItem->retail_price }}</small>
                                            <p>₹{{ $orderItem->total_amount }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="d-flex justify-content-between me-3 mb-1 "><strong>Delivery Fee</strong><span> + ₹
                            {{ $deliveryFee->value('delivery_fee') }}</span></p>
                    </div>
                </div>
                <div class="total-section row justify-content-between mt-2" style="border-bottom: 2px solid #000">
                    <p class="d-flex justify-content-between py-2"><strong>Total</strong> <span> ₹
                        {{ $orderDetail->final_payable_amount + $deliveryFee->value('delivery_fee') }} </span>
                </div>
                <div class="description-block">

                </div>
            @endforeach
        </div>
    </section>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
</body>

</html>
