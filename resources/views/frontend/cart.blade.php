@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/cart.css') }}">
    @endPushOnce
    <section class="main-cart-section">
        <div class="container">
            <h4 class="page-heading pt-5">MY CART</h4>
            <div class="row pt-5">
                <div class="col-8 product-details-section">
                    <div class="cart-items">
                        <h3>item added</h3>
                        {{-- @foreach ($cartItems as $detail) --}}
                            @foreach ($productDetails as $productDetail)
                            <div class="row justify-content-between align-items-center py-2">
                                <div class="col-2 product-image">
                                    <img src="{{ asset('assets/images/products/' . $productDetail->id . '/' . $productDetail->cover_image . '') }}" class="w-100">
                                </div>
                                @php
                                    $productQuantity = $cartItems->where('product_id',$productDetail->id);
                                @endphp
                                <div class="col-6 product-content">
                                    <div class="product-name">{{ $productDetail->name }}</div>
                                    <div class="quantity-div pt-2">
                                        @foreach ($productQuantity as $quantity)
                                        <div class="input-group">
                                            <button type="button" value="-" class="p-1 px-2 border"
                                                id="minus">-</button>
                                            <input type="text" name="quantity" id="quantity" class="p-1 text-center"
                                                maxlength="5" value="{{ $quantity->quantity }}">
                                            <button type="button" value="+" class="p-1 px-2 border"
                                                id="plus">+</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-2 product-price">
                                        <div class=""><i class="fa fa-close cancel-btn"></i></div>
                                        <div class="price">MRP ₹<span>{{ $productDetail->selling_price}}</span></div>
                                    @if (!empty($variant_details))
                                    @foreach ($variant_details as $variantDetail)
                                        <div class=""><i class="fa fa-close cancel-btn"></i></div>
                                        <div class="price">MRP ₹<span>{{ $variantDetail->selling_price}}</span></div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        {{-- @endforeach --}}
                    </div>
                </div>
                <div class="col-4 billing-details-section">
                    <div class="bill-summary row">
                        <h3>Bill summary</h3>
                        <div class="row mrp-price justify-content-between"><span class="col-6">Item total(MRP)</span><span
                                class="col-2">₹</span></div>
                        <div class="row discount justify-content-between"><span class="col-6">Total discount</span><span
                                class="col-2">-₹</span></div>
                        <div class="row shipping-fee justify-content-between"><span class="col-6">Shipping fee</span><span
                                class="col-6">As per delivery address</span></div>
                        <div class="row total-pay justify-content-between"><span class="col-6">To be paid</span><span
                                class="col-2">₹</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @pushOnce('frontend-scripts')
        <script>
            var DeliveryCode = "{{ route('postalCheck') }}";
        </script>
        <script src="{{ asset('assets/js/frontend/cart.js') }}"></script>
    @endPushOnce
@endsection
