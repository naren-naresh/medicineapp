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
                <div class="row">
                    <div class="col-md-6" id="images-div">
                        <!-- Primary cover image -->
                        @foreach ($products as $product)
                        <div class="show" href="1.jpg">
                            <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}" id="show-img">
                        </div>
                        <!-- product thumbnail images -->
                        <div class="small-img">
                            <img src="{{ asset('assets/frontend/images/next-icon.png')}}" class="icon-left" alt="" id="prev-img">
                            <div class="small-container">
                                <div id="small-img-roll">
                                    <img src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}" class="show-small-img">
                                    @foreach ($thumbnailImages as $thumbImage)
                                         <img src="{{ asset('assets/images/products/' . $product->id . '/' . $thumbImage->image . '') }}" class="show-small-img">
                                    @endforeach
                                </div>
                            </div>
                            <img src="{{ asset('assets/frontend/images/next-icon.png')}}" class="icon-right" alt="" id="next-img">
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-6" id="detail-div"></div>
                </div>
            </div>
        </section>
    </div>
    @pushOnce('frontend-scripts')
    <script src="{{ asset('assets/js/frontend/zoom-in_image.js')}}"></script>
    <script src="{{ asset('assets/js/frontend/single_product_view.js')}}"></script>
    @endPushOnce
@endsection
