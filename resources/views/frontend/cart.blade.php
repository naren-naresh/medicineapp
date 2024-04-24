@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/cart.css') }}">
    @endPushOnce
    <section class="main-cart-section mb-5">
        <div class="container">
            @if ($productDetails)
                <div class="row pt-5">
                    <div class="col-8 product-details-section">
                        <h4 class="page-heading pt-2">MY CART</h4>
                        <div class="address pt-3 px-3">
                            <div class="row justify-content-between py-3 px-2">
                                <div class="col-8"><i class="fa fa-paper-plane pe-3"></i>Add address to unlock extra discounts and best offers.</div>
                                <div class="col-4 text-end">ADD ADDRESS</div>
                            </div>
                        </div>
                        <h4 class="pt-5 pb-3 cart-heading">ITEMS IN YOUR CART({{ count($cartItems) }})</h4>
                        <div class="cart-items px-3">
                            @foreach ($cartItems as $cartDetail)
                                <div class="row mainRow align-items-center py-3">
                                    <div class="col-2 product-image">
                                        @php
                                            $productInfo = $productDetails->where('id',$cartDetail->product_id);
                                        @endphp
                                        @foreach ($productInfo as $productImage)
                                         <a href="{{ route('single.product.view',$cartDetail->product_id) }}"> <img src="{{ asset('assets/images/products/' . $productImage->id . '/' . $productImage->cover_image . '') }}"
                                            class="w-100"></a>
                                        @endforeach
                                    </div>
                                    @php
                                        $productQuantity = $cartItems->where('product_id', $cartDetail->product_id)->where('id',$cartDetail->id);
                                    @endphp
                                    <div class="col-10 product-content">
                                        <div class="row justify-content-between">
                                            <div class="col-8">
                                                @foreach ($productInfo as $productName)
                                                 <div class="product-name"><a href="{{ route('single.product.view',$cartDetail->product_id) }}">{{ $productName->name }}</a></div>
                                                @endforeach
                                                <div class="quantity-div pt-4">
                                                    @foreach ($productQuantity as $quantity)
                                                        <div class="input-group">
                                                            <button type="button" value="-"
                                                                class="p-1 px-2 border minus" id="minus">-</button>
                                                            <input type="text" name="quantity" id="quantity"
                                                                class="p-1 text-center quantity" maxlength="5"
                                                                value="{{ $quantity->quantity }}"
                                                                cartId = '{{ $quantity->id }}'>
                                                            <button type="button" value="+"
                                                                class="p-1 px-2 border plus" id="plus">+</button>
                                                        </div>
                                                        @php
                                                            $productQuantity = $quantity->quantity;
                                                            if (empty($productRetailSum) && empty($productSellingSum) && empty($variantRetailSum) && empty($variantSellingSum)) {
                                                                $productRetailSum = [];
                                                                $productSellingSum = [];
                                                                $variantRetailSum = [];
                                                                $variantSellingSum = [];
                                                            }
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-4 product-price text-end">
                                                @php
                                                    $productPrices = $productDetails->where('id', $cartDetail->product_id);
                                                @endphp
                                                @foreach ($productPrices as $productPrice)
                                                    @if ($quantity->variant_id == null)
                                                        <div class="" cartId = '{{ $cartDetail->id }}'><i
                                                                class="fa fa-close cancel-btn"></i></div>
                                                        <div class="price pt-4">
                                                            <span class="retailPrice px-1">₹{{ $productQuantity * $productPrice->retail_price }}</span>
                                                            <span class="qt-price">₹{{ $productQuantity * $productPrice->selling_price }}</span>
                                                        </div>
                                                        @php
                                                            $productRetailSum[] = $productQuantity * $productPrice->retail_price;
                                                            $productSellingSum[] = $productQuantity * $productPrice->selling_price;
                                                        @endphp
                                                    @endif
                                                    @if ($quantity->variant_id)
                                                        @php
                                                            $variantPrices = $variant_details->where('product_id', $cartDetail->product_id)->where('id',$cartDetail->variant_id);
                                                        @endphp
                                                        @foreach ($variantPrices as $variantPrice)
                                                            <div class="" cartId = '{{ $cartDetail->id }}'><i
                                                                    class="fa fa-close cancel-btn"></i></div>
                                                            <div class="price pt-4">
                                                                <span class="retailPrice px-1">₹{{ $productQuantity * $variantPrice->retail_price }}</span>
                                                                <span class="qt-price">₹{{ $productQuantity * $variantPrice->selling_price }}</span>
                                                                @php
                                                                    $variantRetailSum[] = $productQuantity * $variantPrice->retail_price;
                                                                    $variantSellingSum[] = $productQuantity * $variantPrice->selling_price;
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
                            <div class="related-products py-4">
                                <div class="row">
                                    <h4>Related Products</h4>
                                    @foreach ($relatedProducts as $relatedProduct)
                                        <div class="p-card pt-3 col-2">
                                            <div class="pc-con">
                                                <div class="pc-img">
                                                    <a href="{{ route('single.product.view', $relatedProduct->id) }}"><img
                                                            src="{{ asset('assets/images/products/' . $relatedProduct->id . '/' . $relatedProduct->cover_image . '') }}"></a>
                                                    <span class="heartSpan"><a href="#"><i
                                                                class="far fa-heart"></i></a></span>
                                                </div>
                                                <div class="pc-text pt-2">
                                                    <p class="pc-title"><a
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
                                $retailPrice1 = array_sum($variantRetailSum);
                                $retailPrice2 = array_sum($productRetailSum);
                                $totalMRP = $retailPrice1 + $retailPrice2;
                                $sellingPrice1 = array_sum($variantSellingSum);
                                $sellingPrice2 = array_sum($productSellingSum);
                                $totalSellingPrice = $sellingPrice1 + $sellingPrice2;
                                $totalDiscount = $totalMRP - $totalSellingPrice;
                                $totalPaid = $totalMRP - $totalDiscount;
                            @endphp
                            <div class="row mrp-price justify-content-between py-1"><span class="col-6">Cart
                                    Total(MRP)</span><span class="col-2">₹{{ $totalMRP }}</span></div>
                            <div class="row discount justify-content-between py-1"><span class="col-6">Discount
                                   on MRP</span><span class="col-3 text-end">-₹{{ $totalDiscount }}</span></div>
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
                                    <button type="button" class="paymentBtn btn">PROCEED</button>
                                </div>
                            </div>
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
            var updateRoute = "{{ route('cart.update') }}";
        </script>
        <script src="{{ asset('assets/js/frontend/cart.js') }}"></script>
    @endPushOnce
@endsection
