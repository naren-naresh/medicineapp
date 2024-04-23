@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/cart.css') }}">
    @endPushOnce
    <section class="main-cart-section mb-5">
        <div class="container">
            <h4 class="page-heading pt-5">MY CART</h4>
            @if ($productDetails)
                <div class="row pt-5">
                    <div class="col-8 product-details-section">
                        <div class="cart-items">
                            <h4 class="pb-5">ITEMS IN YOUR CART({{ count($cartItems) }})</h4>
                            @foreach ($productDetails as $productDetail)
                                <div class="row mainRow align-items-center py-2">
                                    <div class="col-2 product-image">
                                        <img src="{{ asset('assets/images/products/' . $productDetail->id . '/' . $productDetail->cover_image . '') }}"
                                            class="w-100">
                                    </div>
                                    @php
                                        $productQuantity = $cartItems->where('product_id', $productDetail->id);
                                    @endphp
                                    <div class="col-10 product-content">
                                        <div class="row justify-content-between px-2">
                                            <div class="col-8">
                                                <div class="product-name">{{ $productDetail->name }}</div>
                                                <div class="quantity-div pt-4">
                                                    @foreach ($productQuantity as $quantity)
                                                        <div class="input-group">
                                                            <button type="button" value="-" class="p-1 px-2 border"
                                                                id="minus">-</button>
                                                            <input type="text" name="quantity" id="quantity"
                                                                class="p-1 text-center" maxlength="5"
                                                                value="{{ $quantity->quantity }}">
                                                            <button type="button" value="+" class="p-1 px-2 border"
                                                                id="plus">+</button>
                                                        </div>
                                                        @php
                                                            $productQuantity = $quantity->quantity;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-2 product-price text-end">
                                                @php
                                                    $productPrices = $productDetails->where('id', $productDetail->id);
                                                    $productRetailSum = [];
                                                    $productSellingSum = [];
                                                    $variantRetailSum = [];
                                                    $variantSellingSum = [];
                                                @endphp
                                                @foreach ($productPrices as $productPrice)
                                                    @if ($quantity->variant_id == null)
                                                        <div class="" productId = '{{ $productPrice->id }}'><i
                                                                class="fa fa-close cancel-btn"></i></div>
                                                        <div class="price pt-4">MRP
                                                            <span>₹{{ $productPrice->retail_price }}</span>
                                                        </div>
                                                        @php
                                                            $productRetailSum[] = $productPrice->retail_price;
                                                            $productSellingSum[] = $productPrice->selling_price;
                                                        @endphp
                                                    @endif
                                                    @if ($quantity->variant_id)
                                                        @php
                                                            $variantPrices = $variant_details->where(
                                                                'product_id',
                                                                $productDetail->id,
                                                            );
                                                        @endphp
                                                        @foreach ($variantPrices as $variantPrice)
                                                            <div class="" productId = '{{ $productPrice->id }}'><i
                                                                    class="fa fa-close cancel-btn"></i></div>
                                                            <div class="price pt-4">MRP
                                                                <span>₹{{ $variantPrice->retail_price }}</span>
                                                                @php
                                                                    $variantRetailSum[] = $variantPrice->retail_price;
                                                                    $variantSellingSum[] = $variantPrice->selling_price;
                                                                @endphp
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4 billing-details-section">
                        <div class="bill-summary row">
                            <h3>Bill summary</h3>
                            @php
                                $retailPrice1 = array_sum($variantRetailSum);
                                $retailPrice2 = array_sum($productRetailSum);
                                $totalMRP = $retailPrice1 + $retailPrice2;
                                $sellingPrice1 = array_sum($variantSellingSum);
                                $sellingPrice2 = array_sum($productSellingSum);
                                $totalSellingPrice = $sellingPrice1 + $sellingPrice2;
                                $totalDiscount = $totalMRP - $totalSellingPrice;
                                $totalPaid = $totalMRP - $totalDiscount;
                            @endphp
                            <div class="row mrp-price justify-content-between py-1"><span class="col-6">Item
                                    total(MRP)</span><span class="col-2">₹{{ $totalMRP }}</span></div>
                            <div class="row discount justify-content-between py-1"><span class="col-6">Total
                                    discount</span><span class="col-2">-₹{{ $totalDiscount }}</span></div>
                            <div class="row shipping-fee justify-content-between pt-1 pb-3"><span class="col-6">Shipping
                                    fee</span><span class="col-6 text-end">As per delivery address</span></div>
                            <div class="row total-pay justify-content-between py-2"><span class="col-6">TO PAY</span><span
                                    class="col-2">₹{{ $totalPaid }}</span></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @pushOnce('frontend-scripts')
        <script>
            var DeliveryCode = "{{ route('postalCheck') }}";
            var destroy = "{{ route('cart.destroy') }}";
        </script>
        <script src="{{ asset('assets/js/frontend/cart.js') }}"></script>
    @endPushOnce
@endsection
