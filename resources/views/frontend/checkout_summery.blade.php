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
                        @foreach ($cartDataItems as $cartDetail)
                            <div class="row mainRow align-items-center py-3">
                                <div class="col-2 product-image">
                                    <a href="{{ route('single.product.view', $cartDetail['product_id']) }}"> <img
                                            src="{{ asset('assets/images/products/' . $cartDetail['product_id'] . '/' . $cartDetail['product_image'] . '') }}"
                                            class="w-75"></a>
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
                                {{-- <div class="col-2 ps-4"><i class="fa fa-percentage pt-2"></i></div> --}}
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
                            <div class="row mrp-price justify-content-between py-1"><span class="col-6">Cart
                                    Total(MRP)</span><span class="col-2 text-end pe-1">₹{{ $totalMRP }}</span></div>
                            <div class="row discount justify-content-between py-1"><span class="col-6">Discount
                                    on MRP</span><span class="col-3 text-end pe-1">-₹{{ $totalDiscount }}</span></div>
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
                            <ul class="address-content list-unstyled">
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
                        <div class="continue text-center"><a href="#" class="continue-btn">Continue</a></div>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.modals.address_modal')
        @include('frontend.modals.payment_modal')
    </section>
    @pushOnce('frontend-scripts')
        <script>
            $('.change-btn').click(function() {
                $('#addressModal').modal('show');
            });
            $('.address-item').click(function() {
                $id = $(this).attr('addressId');
                $html = $(this).parent().html();
                $('.address-content').html($html);
                $('#addressModal').modal('hide');
            });
            $('.address-item').each(function(index, element) {
                if ($(this).attr('addressId') == $('.address-content').children('li').attr('addressId')) {
                    $(this).addClass('address-active');
                    $(this).find('i').addClass('address-active');
                }
            });
            $('.continue').click(function() {
                $('#paymentModal').modal('show');
            });
            /* payment modal functionality */
            $('#card').click(function() {
                if ($(this).is(':checked')) {
                    $(this).siblings('label').addClass('paymentActive');
                    $('#pay-on-delivery').siblings('label').removeClass('paymentActive');
                    $('.card-form').removeClass('d-none');
                    $('.pay-btn-block').removeClass('d-none');
                    $('.pay-on-content').addClass('d-none');
                }
            });
            $('#pay-on-delivery').click(function() {
                if ($(this).is(':checked')) {
                    $(this).siblings('label').addClass('paymentActive');
                    $('#card').siblings('label').removeClass('paymentActive');
                    $('.card-form').addClass('d-none');
                    $('.pay-btn-block').removeClass('d-none');
                    $('.pay-on-content').removeClass('d-none');
                }
            });
        </script>
    @endPushOnce
@endsection
