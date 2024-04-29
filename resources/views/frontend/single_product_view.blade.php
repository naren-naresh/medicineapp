@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/single_product.css') }}">
    @endPushOnce
    <div class="product-view-main-block">
        <!-- page breadcrumb -->
        <div class="breadcrumb py-2">
            <div aria-label="breadcrumb" class="container">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class=" text-decoration-none">Home</a></li>
                    @foreach ($products as $pName)
                        @php
                            $categoryName = $childCategories->where('id', $pName->category_id);
                        @endphp
                        @foreach ($categoryName as $cName)
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('product_list', $pName->category_id) }}">{{ $cName->name }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page" id="breadcrumb-product-name">
                            {{ $pName->name }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
        <!-- single product view block-->
        <section class="product-view-section">
            <div class="container pt-1 pb-5">
                @foreach ($products as $product)
                    <div class="row">
                        <div class="col-md-4" id="images-div">
                            <div class="row">
                               @php
                                    $getThumbImgCount = count($thumbnailImages);
                               @endphp
                                <!-- product thumbnail images -->
                                @if (count($thumbnailImages) > 0)
                                    <div class="small-img col-auto p-0">
                                        @if($getThumbImgCount > 3)
                                            <img src="{{ asset('assets/frontend/images/next-icon.png') }}" class="icon-left" alt="" id="prev-img">
                                        @endif
                                        <div class="small-container py-1">
                                            <div id="small-img-roll">
                                                <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}"
                                                    class="show-small-img">
                                                @foreach ($thumbnailImages as $thumbImage)
                                                    <img src="{{ asset('assets/images/products/' . $product->id . '/' . $thumbImage->image . '') }}"
                                                        class="show-small-img">
                                                @endforeach
                                            </div>
                                        </div>

                                        @if($getThumbImgCount > 3)
                                            <img src="{{ asset('assets/frontend/images/next-icon.png') }}" class="icon-right" alt="" id="next-img">
                                        @endif
                                    </div>
                                @endif
                                <!-- Primary cover image -->
                                <div class="showImage col" href="1.jpg">
                                    <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}"
                                        id="show-img">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" id="detail-div">
                            <div class="product-detail">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col product-info ps-4">
                                        <div class="sku pt-2">#{{ $product->sku }}</div>
                                        @if ($product->variation_name)
                                            @foreach ($variantNames as $variantName)
                                                <div class="product-variant pt-3" variantId ="{{ $variantName->id }}">
                                                    <h6> {{ $variantName->variant }}({{ count($variantOptions->where('variant_option_id', $variantName->id)) }})</h6>
                                                </div>
                                                @php
                                                    $optionValues =
                                                        $variantOptions->where('variant_option_id', $variantName->id) ??
                                                        [];
                                                @endphp
                                                <div class="product-variant-options pb-2 row"
                                                    variantId="{{ $variantName->id }}">
                                                    @foreach ($optionValues as $option)
                                                        <span
                                                            class="p-1 mt-2 d-flex align-items-center justify-content-center"
                                                            optionId="{{ $option->id }}">{{ $option->variant_option_values }}</span>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="manufacturer pt-3 pb-2">
                                            <h6 class="mb-1">Manufacturer/Marketer</h6>
                                            @foreach ($manufacturers as $manufacturer)
                                                <div>{{ $manufacturer->company_name }}</div>
                                            @endforeach
                                        </div>
                                        <div class="return-policy  py-2">
                                            <h6 class="mb-1">Return Policy</h6>
                                            @if ($product->return_policy_applicable == 1)
                                                @foreach ($returnPolicies as $returnType)
                                                    <div>{{ $returnType->policy_name }}</div>
                                                @endforeach
                                            @endif
                                            @if ($product->return_policy_applicable == 0)
                                                <div>Not Returnable</div>
                                            @endif
                                        </div>
                                        <div class="expiry-date py-2">
                                            <div>
                                                <h6 class="mb-1"> Expires on or after</h6>
                                                <div>{{ Carbon\Carbon::parse($product->expiry_date)->format('F j') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="product-price-addCart-block m-2">
                                            <div class="product-price-discount pb-3">
                                                <span id="price">
                                                    <span id="sellingPrice">
                                                        ₹{{ $product->selling_price }}</span>
                                                </span>&nbsp;<span class="line-through">
                                                    ₹{{ $product->retail_price }}</span>
                                                    @php
                                                        $difference = $product->retail_price - $product->selling_price;
                                                        $discount = round($difference / $product->retail_price * 100);
                                                    @endphp
                                                    <span class="discount"> {{$discount}} % off</span>
                                            </div>

                                            <div class="row quantity-deliveryAvailability py-2 align-items-center">
                                                <div class="col-7 quantity-option">
                                                    <div class="input-group">
                                                        <button type="button" value="-" class="p-1 px-2 border"
                                                            id="minus">-</button>
                                                        <input type="text" name="quantity" id="quantity"
                                                            class="p-1 text-center" maxlength="5">
                                                        <button type="button" value="+" class="p-1 px-2 border"
                                                            id="plus">+</button>
                                                    </div>
                                                </div>
                                                <span class="col-3 ps-0 quant-text">Product Quantity</span>
                                            </div>

                                            <div class="options-buy row justify-content-center pt-4">
                                                <div class="buy-now col-12">
                                                    <button type="button" class="buy-btn form-control"
                                                        productId ="{{ $product->id }}">Buy Now</button>
                                                </div>
                                                <div class="add-cart col-12 mt-3">
                                                    <button type="button" class="buy-btn btn form-control" id="addToCart"
                                                        productId ="{{ $product->id }}">Add to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="delivery-availability pt-3">
                                            <h6 class="mb-2">Delivery Address</h6>
                                            <div class="input-group postalContent w-100">
                                                <input type="text" name="postalCode" id="postalCode"
                                                    class="form-control w-50" placeholder="Postal Code"
                                                    onkeyup="process(this)" minlength="6" maxlength="6"
                                                    value="{{ session()->get('postal_code') }}">
                                                <button type="button" class="" id="postalCodeCheck"
                                                    style="width: 70px">Check</button>
                                                <span id="checkDisplay"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-description row pt-5">
                        <div class="container">
                            <h3 id="desHead"><span>Description</span></h3>
                            <div class="desContent py-4">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                    @if (count($relatedProducts) > 1)
                        <div class="related-products row pt-5">
                            <div class="container">
                                <h3 id="rpHead"><span>Related Products</span></h3>
                                <div class="rpContent row justify-content-center py-4">
                                    @foreach ($relatedProducts as $relatedProduct)
                                        <div class="p-card pt-5 col-3">
                                            <div class="pc-con">
                                                <div class="pc-img">
                                                    <a href="{{ route('single.product.view', $relatedProduct->id) }}"><img
                                                            src="{{ asset('assets/images/products/' . $relatedProduct->id . '/' . $relatedProduct->cover_image . '') }}"></a>
                                                    <span class="heartSpan"><a href="#"><i
                                                                class="far fa-heart"></i></a></span>
                                                </div>
                                                <div class="pc-text py-3">
                                                    <p class="pc-title"><a
                                                            href="{{ route('single.product.view', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                                    </p>
                                                    <div class="price py-1">$ {{ $relatedProduct->selling_price }}</div>
                                                    <span class="d-status text-success">Delivery available</span>
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
                    @endif
            </div>
            @endforeach
        </section>
    </div>
    @pushOnce('frontend-scripts')
        <script>
            var DeliveryCode = "{{ route('postalCheck') }}";
            var Cart = "{{ route('cart.details') }}";
        </script>
        <script src="{{ asset('assets/js/frontend/zoom-in_image.js') }}"></script>
        <script src="{{ asset('assets/js/frontend/single_product_view.js') }}"></script>
    @endPushOnce
@endsection
