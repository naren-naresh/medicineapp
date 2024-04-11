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
        <div class="breadcrumb">
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
                                        <li class=" border-bottom parentCat"><a href="#"
                                                class="parentCatLink">{{ $category->name }}</a>
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
                        <div class="row view-sort-option justify-content-center">
                            <div class="view-option col-10">
                                <div class="view-style">
                                    <span class="gird">
                                        <i class="fa fa-border-all" id="grid-view" style="cursor: pointer;"></i>
                                    </span>
                                    <span class="list">
                                        <i class="fa fa-list" id='list-view' style="cursor: pointer;"></i>
                                        <span class="records-tracker"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="sort-option col-2">
                                <select name="inputs-sort" id="inputs-sort">
                                    <option value="0" class="selected">Default Sorting</option>
                                    <option value="1">Low to High</option>
                                    <option value="2">High to Low</option>
                                </select>
                            </div>
                            @foreach ($products as $product)
                                <div class="col-3 p-card pt-5">
                                    <div class="pc-con">
                                        <div class="pc-img">
                                            <img
                                                src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}">
                                            <span class="heartSpan"><a href="#"><i
                                                        class="far fa-heart"></i></a></span>
                                        </div>
                                        <div class="pc-text py-3">
                                            <p class="pc-title"><a
                                                    href="#">{{ Illuminate\Support\Str::limit($product->name, 40) }}</a>
                                            </p>
                                            <div class="price py-1">$ {{ $product->selling_price }}</div>
                                            <span class="d-status text-success">Delivery available</span>
                                            <div class="pc-view pt-2">
                                                <a href="#" class="pc-btn">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pagination d-flex justify-content-center">
                                {{ $products->links() }}
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
            /* csrf token*/
            $(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
            });
            var search = "{{ route('search') }}";
            $('#list-view').click(function() {
                $('.p-card').removeClass('col-3');
                $('.p-card').addClass('listView2');
                $('.pc-con').addClass('listView');
                $('.heartSpan').addClass('spanView');
            });
            $('#grid-view').click(function() {
                $('.p-card').addClass('col-3');
                $('.pc-con').removeClass('listView');
            });
            var productCount = {{ count($products) }};

            // Display the product count
            $('.records-tracker').text("Number of Products: " + productCount);
            // sorting records using select menu
            $('#inputs-sort').change(function(e) {
                var sortType = $(this).val();
                $.ajax({
                    type: "GET",
                    url: " {{ route('product_list') }}",
                    data: {
                        sortType: sortType,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        </script>
    @endPushOnce
@endsection
