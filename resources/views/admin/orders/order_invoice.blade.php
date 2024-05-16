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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav_icon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Layout Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    <!-- Data Table css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatable/datatable.css') }}">
    <!-- Quil editor-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/quill/katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
    <!-- Date Range picker css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Custom Style & Inbuilt Styles -->
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
                        {{-- <img src="{{ asset('assets/images/logo.png') }}" style="width:100px"> --}}
                        <p class="pt-2">Medicine Plus</p>
                    </div>
                    <div class="header-content col-3 text-end">
                        <p>Tax Invoice</p>
                    </div>
                </div>
                <div class="barcode-section row justify-content-between" style="border-bottom: 1px solid #000">
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
                <div class="order-details-section row justify-content-between" style="border-bottom: 2px solid #000">
                    <div class="detail-content col-6">

                    </div>
                    <div class="ship-to">

                    </div>
                </div>
                <div class="product-row row pb-4" style="border-bottom: 2px solid #000">
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
                                        {{-- <td><img src="{{ asset('assets/images/products/' . $orderItem->product_id . '/' . $orderItem->product_image . '') }}"
                                                style="width: 50px"></td> --}}
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
                        <p class="mb-1 d-flex justify-content-between mb-2 me-3"><strong>Delivery Fee</strong><span> + ₹
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
    <!--jquery plugin-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!--bootstrap js plugin-->
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!--layout script file -->
    <script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>
    <!--bootstrap toggle switches plugin-->
    <script src="{{ asset('assets/plugins/bootstrap/toggle.js') }}"></script>
    <!-- jquery validation plugin-->
    <script src="{{ asset('assets/plugins/jqueryvalidation.js') }}"></script>
    <!-- jquery steps plugin-->
    <script src="{{ asset('assets/plugins/jquery/steps.min.js') }}"></script>
    <!--datatable-->
    <script src="{{ asset('assets/plugins/datatable/datatable.js') }}"></script>
    <!-- quill editor -->
    <script src="{{ asset('assets/plugins/quill/katex.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/quill/quill.min.js') }}"></script>
    <!-- date range picker and moment plugin-->
    <script type="text/javascript" src="{{ asset('assets/plugins/moments/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!--sweet alert-->
    <script src="{{ asset('assets/plugins/sweetalter/sweetalter.js') }}"></script>
</body>

</html>
