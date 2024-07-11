@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/summary-page.css') }}">
    @endPushOnce
    <section class="checkout-summary-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-7 products-block">
                    <div class="cart-items px-3">
                        <input type="hidden" name="cartData" id="cartData" value="{{ json_encode($cartDataItems) }}">
                        @php
                            if (request()->has('id')) {
                                $id = request()->route('id');
                                $dataList = $cartDataItems
                            } else {

                            }
                            dd($id);
                        @endphp
                        @foreach ($cartDataItems as $cartDetail)
                            <div class="row mainRow align-items-center py-3">
                                <div class="col-2 product-image">
                                   <img src="{{ asset('assets/images/products/' . $cartDetail['product_id'] . '/' . $cartDetail['product_image'] . '') }}" class="w-75">
                                </div>
                                <div class="col-10 product-content">
                                    <div class="product-name">{{ $cartDetail['product_name'] }}</div>
                                    <div class="row justify-content-between">
                                        <div class="col-9">
                                            <div class="selectedVariant">
                                                @foreach ($cartDetail['variant_data'] as $variants)
                                                    <div class="pt-1"><span>{{ $variants->variantName }}</span> :
                                                        <span>{{ $variants->variantData }}</span><br>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @php
                                            $productRetailSum[] =
                                                $cartDetail['product_quantity'] * $cartDetail['product_retail_Price'] ??
                                                [];
                                            $productSellingSum[] =
                                                $cartDetail['product_quantity'] *
                                                    $cartDetail['product_selling_price'] ??
                                                [];
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-5 bill-summary-deliveryTo-block">
                    <div class="container">
                        <div class="offers  my-5 ps-3">
                            <div class="offerContent row  align-items-center p-3">
                                <label for="coupon-input" class="pb-2">Apply coupon code</label>
                                <div class="col-10 pe-0">
                                    <input type="text" placeholder="Enter coupon code" class="form-control coupon-input">
                                </div>
                                <div class="col-2 ps-0 apply text-center"><a href="#">Apply</a></div>
                            </div>
                        </div>
                        <div class="bill-summary row py-3 ps-3">
                            <h4>Bill Summary</h4>
                            @php
                                $totalMRP = array_sum($productRetailSum);
                                $totalSellingPrice = array_sum($productSellingSum);
                                $totalDiscount = $totalMRP - $totalSellingPrice;
                                $totalPaid = $totalMRP - $totalDiscount;
                            @endphp
                            <input type="hidden" name="total-mrp" id="total-mrp" value="{{ $totalMRP }}">
                            <input type="hidden" name="total-discount" id="total-discount" value="{{ $totalDiscount }}">
                            <input type="hidden" name="total-paid" id="total-paid" value="{{ $totalPaid }}">
                            <div class="row mrp-price justify-content-between py-1"><span class="col-6">Cart
                                    Total(MRP)</span><span class="col-2 text-end pe-1">₹{{ $totalMRP }}</span></div>
                            <div class="row discount justify-content-between py-1"><span class="col-6">Discount
                                    on Total</span><span class="col-3 text-end pe-1">-₹{{ $totalDiscount }}</span></div>
                            <div class="row shipping-fee justify-content-between pt-1 pb-3"><span class="col-5">Delivery
                                    Charges</span><span class="col-7 text-end pe-1">As per delivery address</span></div>
                            <div class="row total-pay justify-content-between py-2"><span class="col-6">TO PAY</span><span
                                    class="col-2 text-end pe-1">₹{{ $totalPaid }}</span></div>
                        </div>
                        <div class="delivery-address py-3">
                            <div class="address-change row justify-content-between align-items-center pb-3 px-3 ">
                                <div class="col-5">Delivering to</div>
                                <div class="col-2 change-btn">Change</div>
                            </div>
                            @php
                                $defaultAddress = $addresses->where('set_default', 1);
                            @endphp
                            <ul class="address-content list-unstyled pt-3">
                                @foreach ($defaultAddress as $address)
                                    <li class="border p-3 my-2 address" addressId={{ $address->id }}>
                                        <p><i class="fa fa-house-chimney"></i>&nbsp;Home</p>
                                        <p>
                                            <span><i class="fa fa-user"></i>&nbsp; {{ $address->name }}</span>
                                            <span class="ps-5"><i
                                                    class="fa fa-phone"></i>&nbsp;{{ $address->contact_number }}</span>
                                        </p>
                                        <p><i class="fa fa-map-location"></i>
                                            &nbsp;{{ $address->address }}({{ $address->postal_code }})</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row justify-content-between px-3 btn-block">
                            <a href="{{ route('cart.index') }}" class="edit-btn text-center col-4 py-1">Edit Cart</a>
                            <button type="button" class="continue-btn text-center col-4 py-1">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.modals.address_modal')
        @include('frontend.modals.payment_modal')
    </section>
    @pushOnce('frontend-scripts')
        <script src="{{ asset('assets/js/frontend/summary-page.js') }}"></script>
        <script>
            var orderStore = "{{ route('orders.store') }}";
        </script>
    @endPushOnce
@endsection
