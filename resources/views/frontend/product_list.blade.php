@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/product_list.css') }}">
    @endPushOnce
    <!--category-listing-block-->
    <div class="category-block">
        <div class="category-banner-block">
            <div class="category-banner">
                <img src="{{ asset('assets/frontend/images/high-angle-pill-foils-plastic-containers_23-2148533456.avif') }}">
                <h3>Product Category</h3>
            </div>
        </div>
        <!-- page breadcrumb -->
        <div class="breadcrumb my-1">
            <div aria-label="breadcrumb" class="container">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class=" text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Manufacturer</li>
                </ol>
            </div>
        </div>
        <!--category-listing-block-->
        <section class="category-listing py-5">
            <div class="container">
                <div class="row">
                      <div class="col-3 product-list">
                        <h4>Shop by Category</h4>
                        <div class="category-list-section">
                            <ul class="category-menu ps-0">
                                @foreach ($categories as $category )
                                      <li class=" border-bottom"><a href="#">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                      </div>
                      <div class="col-9 product-card"></div>
                </div>
            </div>
        </section>
    </div>
    <!--category-listing-block-end-->
    @pushOnce('frontend-scripts')
        <script>
            var search = "{{ route('search') }}";
        </script>
    @endPushOnce
@endsection
