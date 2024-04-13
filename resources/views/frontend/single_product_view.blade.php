@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/single_product.css') }}">
    @endPushOnce
    <div class="product-view-main-block">
        <!-- page breadcrumb -->
        <div class="breadcrumb">
            <div aria-label="breadcrumb" class="container">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class=" text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class=" text-decoration-none">Category Name</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ProductName</li>
                </ol>
            </div>
        </div>
        <!-- single product view block-->
        <section class="product-view-section">
            <div class="container py-5">
                @foreach ($products as $product)
                    <div class="row">
                        <div class="col-md-6" id="images-div">
                            <!-- Primary cover image -->
                            <div class="showImage" href="1.jpg">
                                <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}"
                                    id="show-img">
                            </div>
                            <!-- product thumbnail images -->
                            <div class="small-img">
                                <img src="{{ asset('assets/frontend/images/next-icon.png') }}" class="icon-left"
                                    alt="" id="prev-img">
                                <div class="small-container">
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
                        </div>
                        <div class="col-md-6" id="detail-div">
                            <div class="product-detail">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-price-discount"><span id="sellingPrice"> ₹{{ $product->selling_price }}</span><span
                                            class="line-through"> ₹{{ $product->retail_price }}</span></div>
                                    <div class="product-variant">
                                        @if ($product->variation_name)
                                            @php
                                                $variantNames = json_decode($product->variation_name) ?? [];
                                            @endphp
                                            @foreach ($variantNames as $variantName)
                                                {{ $variantName }}
                                            @endforeach
                                        @endif
                                    </div>
                                     <div class="product-variant-options row">
                                        @foreach ( $variantOptions as $option)
                                         <span class="p-3 p-1 mt-2">{{$option->variant_option_values}}</span>
                                         @endforeach
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-description row pt-5">
                          <div class="container">
                            <h3 id="desHead">Description</h3>
                                  <div class="desContent py-4">
                                    {!! $product->description !!}
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
