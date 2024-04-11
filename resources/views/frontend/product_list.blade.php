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
                                @foreach ($categories as $category)
                                    @if ($category->parent_category_id == null)
                                        <li class=" border-bottom"><a href="#">{{ $category->name }}<span
                                                    class="dropdown-arrow">&#9660;</span></a>
                                            <ul class="child-cat-list">
                                                @php
                                                    $childList = $childCategories->where(
                                                        'parent_category_id',
                                                        $category->id,
                                                    );
                                                @endphp
                                                @foreach ($childList as $childCat)
                                                    <li><a href="#">{{ $childCat->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-9 product-card">
                        <div class="row">
                            <div class="row view-sort-option">
                                <div class="view-option col-10">
                                    <div class="view-style">
                                        <span class="gird">
                                            <i class="fa fa-border-all"></i>
                                        </span>
                                        <span class="list">
                                            <i class="fa fa-list"></i>
                                        </span>
                                    </div>
                                    <span class="records-tracker"></span>
                                </div>
                                <div class="sort-option col-2">
                                    <select name="inputs-sort" id="inputs-sort">
                                        <option value="0" class="selected">Default Sorting</option>
                                        <option value="1">Low to High</option>
                                        <option value="2">High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
