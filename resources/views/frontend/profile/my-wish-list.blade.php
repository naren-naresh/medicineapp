@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/wishlist.css') }}">
    @endPushOnce
    <section class="wishlist-section py-5">
        <div class="container">
            <div class="row  wishlist-content">
                <div class="col-3 pe-5">
                    <div class="row mb-4 user-name-block align-items-center">
                        <div class="col-3 user-icon"><img
                                src="{{ asset('assets/images/user/' . auth()->id() . '/' . Auth::user()->image . '') }}"
                                class="w-100"></div>
                        <div class="col ps-4">
                            <div class="row">
                                <span>Hello</span>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row menu-options">
                        <a href="{{ route('useProfile.index') }}">
                            <div class="option"><i class="fa fa-user"></i>&nbsp; Personal Information</div>
                        </a>
                        <a href="{{ route('address.index') }}">
                            <div class="option"><i class="fa fa-map-location"></i>&nbsp; Manage Addresses</div>
                        </a>
                        <a href="{{ route('wishlist.index') }}">
                            <div class="option active"><i class="fa fa-heart"></i> &nbsp;My Wishlist</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-cart-shopping"></i> &nbsp;My Orders</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-keyboard"></i> &nbsp;Change Password</div>
                        </a>
                        <a href="{{ route('logout') }}">
                            <div class="option"><i class="fa fa-sign-out"></i> &nbsp;Logout</div>
                        </a>
                    </div>
                </div>
                <div class="col-9 wishlist-products">
                    <h4 class="pb-2">My Wishlist ({{ count($favProducts) }})</h4>
                    <div class="existing-wishlist">
                        @foreach ($favProducts as $favProduct)
                            @php
                                $wishlists = $products->where('id', $favProduct->product_id);
                            @endphp
                            @foreach ($wishlists as $wishlist)
                                <div class="row add-row mx-0 mt-3">
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-2">
                                                <a href="{{ route('single.product.view', $wishlist->id) }}"><img
                                                        src="{{ asset('assets/images/products/' . $wishlist->id . '/' . $wishlist->cover_image . '') }}"
                                                        class="w-100"></a>
                                            </div>
                                            <div class="col-10">
                                                <p class="w-100 product-name">
                                                    <a href="{{ route('single.product.view', $wishlist->id) }}">{{ $wishlist->name }}</a>
                                                </p>
                                                <p class="product-price">₹{{ $wishlist->selling_price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <div class="action-row">
                                            <a href="{{ route('wishlist.destroy', $wishlist->id) }}"><i
                                                    class="fa fa-trash"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @pushOnce('frontend-scripts')
        <script></script>
    @endPushOnce
@endsection
