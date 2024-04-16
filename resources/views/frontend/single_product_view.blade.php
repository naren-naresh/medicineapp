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
            <div class="container py-5">
                @foreach ($products as $product)
                    <div class="row">
                        <div class="col-md-6" id="images-div">
                            <div class="row">
                                <!-- product thumbnail images -->
                                @if (count($thumbnailImages) > 0)
                                    <div class="small-img col-2">
                                        <img src="{{ asset('assets/frontend/images/next-icon.png') }}" class="icon-left"
                                            alt="" id="prev-img">
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
                                        <img src="{{ asset('assets/frontend/images/next-icon.png') }}" class="icon-right"
                                            alt="" id="next-img">
                                    </div>
                                @endif
                                <!-- Primary cover image -->
                                <div class="showImage col-10" href="1.jpg">
                                    <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}"
                                        id="show-img">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="detail-div">
                            <div class="product-detail">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="manufacturer pt-3">
                                        <h6 class="mb-1">Manufacturer/Marketer</h6>
                                        @foreach ($manufacturers as $manufacturer)
                                            <div>{{ $manufacturer->company_name }}</div>
                                        @endforeach
                                    </div>
                                    <div class="return-policy  pt-3">
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
                                    <div class="expiry-date pt-3">
                                        <div>
                                            <h6 class="mb-1"> Expires on or after</h6>
                                            <div>{{ Carbon\Carbon::parse($product->expiry_date)->format('F j') }}</div>
                                        </div>
                                    </div>
                                    <div class="product-price-discount"><span id="price">Price :</span>&nbsp;<span
                                            class="line-through">
                                            ₹{{ $product->retail_price }}</span><span id="sellingPrice">
                                            ₹{{ $product->selling_price }}</span></div>
                                    @if ($product->variation_name)
                                        <div class="product-variant">
                                            @php
                                                $variantNames = json_decode($product->variation_name) ?? [];
                                            @endphp
                                            @foreach ($variantNames as $variantName)
                                                {{ $variantName }}
                                        </div>
                                        <div class="product-variant-options row">
                                            @foreach ($variantOptions as $option)
                                                <span class="p-3 p-1 mt-2">{{ $option->variant_option_values }}</span>
                                            @endforeach
                                        </div>
                                    @endforeach
                @endif
                <div class="options-buy row justify-content-center pt-5">
                    <div class="buy-now col-6">
                        <form action="" method="post">
                            <input type="hidden" name="Product_id">
                            <button type="submit" class="buy-btn form-control">Buy Now</button>
                        </form>
                    </div>
                    <div class="add-cart col-6">
                        <form action="" method="post">
                            <input type="hidden" name="Product_id">
                            <button type="submit" class="buy-btn form-control">Add to Cart</button>
                        </form>
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
    <div class="related-products row pt-5">
        <div class="container">
            <h3 id="rpHead"><span>Related Products</span></h3>
            <div class="rpContent row justify-content-center py-4">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="p-card pt-5 col-3">
                        <div class="pc-con">
                            <div class="pc-img">
                                <img
                                    src="{{ asset('assets/images/products/' . $relatedProduct->id . '/' . $relatedProduct->cover_image . '') }}">
                                <span class="heartSpan"><a href="#"><i class="far fa-heart"></i></a></span>
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
    </div>
    @endforeach
    </section>
    </div>
    @pushOnce('frontend-scripts')
        <script src="{{ asset('assets/js/frontend/zoom-in_image.js') }}"></script>
        <script src="{{ asset('assets/js/frontend/single_product_view.js') }}"></script>
    @endPushOnce
@endsection
