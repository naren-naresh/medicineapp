@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/cart.css') }}">
    @endPushOnce
    @if ($cartDataItems)
        <section class="main-cart-section mb-5">
            <div class="container">
                <div class="row pt-5">
                    <div class="col-8 product-details-section">
                        <h4 class="page-heading pt-2">MY CART</h4>
                        <div class="address pt-3 px-3">
                            <div class="row justify-content-between py-3 px-2">
                                <div class="col-8"><i class="fa fa-paper-plane pe-3"></i>Add address to unlock extra
                                    discounts
                                    and best offers.</div>
                                <div class="col-4 text-end"><a href="{{ route('address.index') }}">ADD ADDRESS</a></div>
                            </div>
                        </div>
                        <div class="row pt-5 pb-3 align-items-center">
                            <div class="col-8">
                                <h4 class="cart-heading">ITEMS IN YOUR CART({{ count($cartItems) }})</h4>
                            </div>
                            <div class="col-4 text-end addItems"><a href="{{ route('home') }}">
                                    <h6>ADD ITEMS</h6>
                                </a></div>
                        </div>
                        <div class="cart-items px-3">
                            @foreach ($cartDataItems as $cartDetail)
                                <div class="row mainRow align-items-center py-3">
                                    <div class="col-2 product-image">
                                        <a href="{{ route('single.product.view', $cartDetail['product_id']) }}"> <img
                                                src="{{ asset('assets/images/products/' . $cartDetail['product_id'] . '/' . $cartDetail['product_image'] . '') }}"
                                                class="w-100"></a>
                                    </div>
                                    <div class="col-10 product-content">
                                        <div class="product-name"><a
                                            href="{{ route('single.product.view', $cartDetail['product_id']) }}">{{ $cartDetail['product_name'] }}</a>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-9">
                                                <div class="selectedVariant">
                                                    @foreach ($cartDetail['variant_data'] as $variants)
                                                        <div class="pt-1"><span>{{ $variants->variantName }}</span> :
                                                            <span>{{ $variants->variantData }}</span><br></div>
                                                    @endforeach
                                                </div>
                                                <div class="quantity-div pt-4">
                                                    <div class="input-group">
                                                        <button type="button" value="-" class="p-1 px-2 border minus"
                                                            id="minus">-</button>
                                                        <input type="text" name="quantity" id="quantity"
                                                            class="p-1 text-center quantity" maxlength="5"
                                                            value="{{ $cartDetail['product_quantity'] }}"
                                                            cartId = '{{ $cartDetail['cart_id'] }}'>
                                                        <button type="button" value="+" class="p-1 px-2 border plus"
                                                            id="plus">+</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3 product-price text-end">
                                                <div class="pt-2" cartId = '{{ $cartDetail['cart_id'] }}'><i
                                                        class="fa fa-close cancel-btn"></i></div>
                                                <div class="price pt-4">
                                                    <span
                                                        class="retailPrice px-1">₹{{ $cartDetail['product_quantity'] * $cartDetail['product_retail_Price'] }}</span>
                                                    <span
                                                        class="qt-price">₹{{ $cartDetail['product_quantity'] * $cartDetail['product_selling_price'] }}</span>
                                                </div>
                                                @php
                                                    $productRetailSum[] =
                                                        $cartDetail['product_quantity'] *
                                                            $cartDetail['product_retail_Price'] ??
                                                        [];
                                                    $productSellingSum[] =
                                                        $cartDetail['product_quantity'] *
                                                            $cartDetail['product_selling_price'] ??
                                                        [];
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4 billing-details-section pt-2">
                        <div class="offers  my-5 ps-3">
                            <div class="offerContent row justify-content-between align-items-center px-1 py-2">
                                <div class="col-2 ps-4"><i class="fa fa-percentage pt-2"></i></div>
                                <div class="col-7">
                                    <div class="con1">Apply Coupon</div>
                                    <div class="con2 pt-1 text-danger">Login to apply coupons</div>
                                </div>
                                <div class="col-1 text-end"><i class="fa fa-angle-right"></i></div>
                            </div>
                        </div>
                        <div class="bill-summary row pt-5 ps-3">
                            <h3>Bill Summary</h3>
                            @php
                                $totalMRP = array_sum($productRetailSum);
                                $totalSellingPrice = array_sum($productSellingSum);
                                $totalDiscount = $totalMRP - $totalSellingPrice;
                                $totalPaid = $totalMRP - $totalDiscount;
                            @endphp
                            <div class="row mrp-price justify-content-between py-1"><span class="col-6">Cart
                                    Total(MRP)</span><span class="col-2 pe-0">₹{{ $totalMRP }}</span></div>
                            <div class="row discount justify-content-between py-1"><span class="col-6">Discount
                                    on MRP</span><span class="col-3 text-end pe-1">-₹{{ $totalDiscount }}</span></div>
                            <div class="row shipping-fee justify-content-between pt-1 pb-3"><span class="col-5">Delivery
                                    Charges</span><span class="col-7 text-end">As per delivery address</span></div>
                            <div class="row total-pay justify-content-between py-2"><span class="col-6">TO PAY</span><span
                                    class="col-2">₹{{ $totalPaid }}</span></div>
                        </div>
                        <div class="payment px-4 py-2">
                            <div class="row align-items-center">
                                <div class="col">
                                    <span>Amount to Pay</span>
                                    <div class="totalPayment">₹{{ $totalPaid }}</div>
                                </div>
                                <div class="col text-end">
                                    <a href="{{ route('summaryPage.index') }}" class="paymentBtn btn" authId = {{auth()->id()}}>PROCEED</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="related-products py-4 container">
                <div class="row">
                    <h4 class="pb-3">Related Products</h4>
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="p-card pt-3 col">
                            <div class="pc-con">
                                <div class="pc-img">
                                    <a href="{{ route('single.product.view', $relatedProduct->id) }}"><img
                                            src="{{ asset('assets/images/products/' . $relatedProduct->id . '/' . $relatedProduct->cover_image . '') }}"></a>
                                            <span><a><i class="far fa-heart" productId = {{$relatedProduct->id}} customerID = {{ auth()->id()}} wish="{{$relatedProduct->checkFavorite()}}"></i></a></span>
                                </div>
                                <div class="pc-text pt-4">
                                    <p class="pc-title mb-2"><a
                                            href="{{ route('single.product.view', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                    </p>
                                    <div class="price">₹{{ $relatedProduct->selling_price }}</div>
                                    <div class="pc-view pt-2">
                                        <a href="{{ route('single.product.view', $relatedProduct->id) }}"
                                            class="pc-btn">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class="container py-5">
            <div class="row justify-content-center">
                <img src="{{ asset('assets/frontend/images/empty-cart.svg') }}" class="w-25">
                <div class="empty-cart-con text-center">
                    <p class="mb-2">Your cart is empty</p>
                    <span>We have all the medicines and healthcare products that you need.</span>
                </div>
                <div class="findMed col-2 mt-4 text-center"><a href="{{ route('home') }}">Find Medicines</a></div>
            </div>
        </div>
    @endif
    @pushOnce('frontend-scripts')
        <script>
            var destroy = "{{ route('cart.destroy') }}";
            var updateRoute = "{{ route('cart.update') }}";
        </script>
        <script src="{{ asset('assets/js/frontend/cart.js') }}"></script>
    @endPushOnce
@endsection
