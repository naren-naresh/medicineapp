    @extends('frontend.layouts.master')
    @section('frontend-content')
        <section class="slider-section" id="slider-section">
            <div class="slider-content">
                <ul class="slider">
                    @foreach ($sliders as $slide)
                        <li class="slide1">
                            <div class="slider-title-wrapper">
                                <h3 class="slider-title"><span class="slider-title-h3">{{ $slide->heading }}</span>
                                    <span class="slider-subtitle">{{ $slide->content }}</span>
                                </h3>
                                <p class="slider-link"><a href="#" class="display-6 text-white">{{ $slide->link }}</a>
                                </p>
                            </div>
                            <img src="{{ asset('assets/images/sliderimages/' . $slide->image . '') }}">
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        <!--page banner end-->
        <!-- category block -->
        <section class="category-section end">
            <div class="container">
                <div class="row d-flex py-3 px-4" id="category-row">
                    <div class="category-list-block d-flex justify-content-around align-items-center">
                        @foreach ($categories as $cat)
                            <a href="{{ route('product_list',$cat->id) }}" class="category-list text-center" style="width: 15.25%;">
                                <div class="cat-con">
                                    <div class="cat-img"><img src="{{ asset('assets/images/' . $cat->image . '') }}"></div>
                                    <div class="cat-text">{{ $cat->name }}</div>
                                </div>
                            </a>
                        @endforeach
                        <a href="#" class="category-list">
                            <div class="cat-more">
                                <span>More <small> >> </small></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- category block end -->
        <!-- product block -->
        <section class="product-section pb-5">
            <div class="container">
                <div class="section-title">
                    <h4 class="h4">Most Recent<small style="font-size: 16px"> Products</small></h4>
                </div>
                <div class="row pt-3">
                    @foreach ($products as $product)
                        <div class="col-3 p-card">
                            <div class="pc-con">
                                <div class="pc-img">
                                    <img
                                        src="{{ asset('assets/images/products/' . $product->id . '/' . $product->cover_image . '') }}">
                                    <span><a href="#"><i class="far fa-heart"></i></a></span>
                                </div>
                                <div class="pc-text py-3">
                                    <p class="pc-title"><a
                                            href="{{ route('single.product.view',$product->id) }}">{{ $product->name }}</a></p>
                                    <div class="price py-1">$ {{ $product->selling_price }}</div>
                                    <span class="d-status text-success">Delivery available</span>
                                    <div class="pc-view pt-2">
                                        <a href="{{ route('single.product.view',$product->id)}}" class="pc-btn">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- product block end-->
        <!-- get order block-->
        <section class="order-section py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <h2><i class="far fa-paper-plane display-6"></i> &nbsp;New Customer?</h2>
                    </div>
                    <div class="col">
                        <form action="#" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 p-0">
                                        <input type="email" name="email" id="newCusMail"
                                            placeholder="Enter your email address..." class=" form-control"
                                            autocomplete="off">
                                    </div>
                                    <div class="col-4 p-0">
                                        <button type="button" id="subscribe" class="form-control">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- get order block end-->
        @push('frontend-scripts')
            <!-- routes url -->
            <script>
                var search = "{{ route('search') }}";
                var home = "{{ route('home') }}";
                var brandLogo = "{{ asset('assets/images/logo.png') }}"
                var success = "{{ asset('assets/frontend/images/successfully.png') }}"
                var error = "{{ asset('assets/frontend/images/error.png') }}"
                var postalCheck = "{{ route('postal') }}"
            </script>
        @endpush
    @endsection
