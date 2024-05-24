<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <!-- Meta Title -->
    <title>Medicine Plus | @yield('meta-title', 'Dashboard')</title>
</head>

<body>
    <section class="invoice" style="margin: 25px 0px;">
        <div class="container" style="width:100%; align-items:center">
            @foreach ($data['orderDetails'] as $orderDetail)
                @php
                    $adminAddress = $data['addresses']->where('customer_id', 1);
                    $customerAddress = $data['addresses']->where('customer_id', $orderDetail->customer_id);
                    $orderStatus = $data['orderStatus']->where('id', $orderDetail->order_status);
                    $zoneGroupId = $data['deliveryZone']->where('postal_code', $customerAddress->value('postal_code'));
                    $deliveryFee = $data['deliveryFee']->where('zone_group_id', $zoneGroupId->value('id'));
                @endphp
                <table class="header" style="border-bottom: 2px solid #000;width: 100%">
                        <tr>
                            <td class="image-section">
                                <img src="{{  public_path('assets/images/logo.png')}}" style="width:100px">
                                <p style="padding-top: 10px;margin-bottom:0px">Thank You!</p>
                                <p><small>for shopping at</small></p>
                            </td>
                            <td class="header-content"  style="width:100px">
                                <p><strong>Tax Invoice</strong></p>
                            </td>
                        </tr>
                </table>
                <table class="barcode-section" style="border-bottom: 2px solid #000;width:100%;padding:10px 0px;">
                    <tr>
                        <td class="company-address-section">
                            <address>
                                <p style="margin: 10px 0px">{{ $adminAddress->value('address') }}</p>
                                <p style="margin: 8px 0px">Postal Code : {{ $adminAddress->value('postal_code') }}</p>
                                <p style="margin: 7px 0px">Phone : {{ $adminAddress->value('contact_number') }}</p>
                            </address>
                        </td>
                        <td class="barcode-content">
                        </td>
                    </tr>
                </table>
                <table class="order-details-section" style="border-bottom: 2px solid #000;width:100%;padding:10px 0px">
                    <tr>
                        <td class="detail-content">
                            <p style="margin: 5px 0px"><strong>Order Id :</strong> {{ $orderDetail->order_number }}</p>
                            <p style="margin: 7px 0px"><strong>Order Date :</strong> {{ date('d M, Y h:m A',strtotime($orderDetail->created_at)) }}</p>
                            <p style="margin: 8px 0px"><strong>Invoice No :</strong> </p>
                            <p style="margin: 5px 0px"><strong>Invoice Date :</strong> </p>
                        </td>
                        <td class="ship-to">
                            <address>
                                <p style="margin: 5px 0px"><strong>Ship To</strong></p>
                                <p style="margin: 8px 0px"><strong>Postal Code :</strong> {{ $customerAddress->value('postal_code') }}</p>
                                <p style="margin: 5px 0px"><strong>Mobile :</strong> {{ $customerAddress->value('contact_number') }}</p>
                            </address>
                        </td>
                    </tr>
                </table>
                <div class="product-row" style="border-bottom: 2px solid #000; padding:10px 0px">
                    <div style="padding: 0px;">
                        <table style="width:100%;">
                            <thead>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @php
                                    $orderItems = $data['orderItems']->where('order_id', $orderDetail->id);
                                @endphp
                                 <tbody>
                                @foreach ($orderItems as $orderItem)
                                    <tr>
                                        <td style="width:400px">
                                            <p style="margin-bottom: 0px">{{ $orderItem->product_name }} ( <small
                                                    style="color: #343333">SKU : {{ $orderItem->product_sku }}</small>)
                                            </p>
                                            <small
                                                style="color: #343333">{{ $orderItem->product_variant_name }}</small>
                                        </td>
                                        <td><small style="text-decoration:line-through;color:#969696;">
                                                 <span style="font-family: DejaVu Sans; sans-serif;">₹</span>{{ number_format($orderItem->retail_price , 2)}}</small>
                                            <p style="margin-top:5px">  <span style="font-family: DejaVu Sans; sans-serif;">₹</span>{{ number_format($orderItem->selling_price , 2) }}</p>
                                        </td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td><small style="text-decoration:line-through;color:#969696">
                                                 <span style="font-family: DejaVu Sans; sans-serif;">₹</span>{{ number_format($orderItem->quantity * $orderItem->retail_price , 2) }}</small>
                                            <p style="margin-top:5px">  <span style="font-family: DejaVu Sans; sans-serif;">₹</span>{{ number_format($orderItem->total_amount , 2)}}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                    <table  style="width: 100%; margin-top:5px"><tr><td><strong>Delivery Fee</strong></td><td style="width:100px"> +  <span style="font-family: DejaVu Sans; sans-serif;">₹</span>
                        {{ number_format($deliveryFee->value('delivery_fee') , 2) }}</td></tr></table>
                </div>
                <table class="total-section" style="border-bottom: 2px solid #000;width:100%;">
                    <tr><td style="padding: 7px 0px"><strong>Total</strong></td> <td  style="width:100px"><span>  <span style="font-family: DejaVu Sans; sans-serif;">₹</span>
                        {{ number_format($orderDetail->final_payable_amount + $deliveryFee->value('delivery_fee') , 2) }} </span></td></tr>
                </table>
                <div class="description-block">

                </div>
            @endforeach
        </div>
    </section>
</body>

</html>
