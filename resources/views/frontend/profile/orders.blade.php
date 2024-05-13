@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/orders.css') }}">
    @endPushOnce
    <section class="order-main-section py-5">
        <div class="container">
            <div class="row order-content">
                <div class="col-3 pe-5">
                    <div class="row mb-4 user-name-block align-items-center">
                        <div class="col-3 user-icon"><img
                                src="{{ asset('assets/images/user/' . auth()->id() . '/' . Auth::user()->image . '') }}"
                                class="w-100"></div>
                        <div class="col ps-4">
                            <div class="row">
                                <span>Hello</span>
                                <span class="username">{{ Auth::user()->name }}</span>
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
                            <div class="option"><i class="fa fa-heart"></i> &nbsp;My Wishlist</div>
                        </a>
                        <a href="{{ route('orders.index') }}">
                            <div class="option active"><i class="fa fa-cart-shopping"></i> &nbsp;My Orders</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-keyboard"></i> &nbsp;Change Password</div>
                        </a>
                        <a href="{{ route('logout') }}">
                            <div class="option"><i class="fa fa-sign-out"></i> &nbsp;Logout</div>
                        </a>
                    </div>
                </div>
                <div class="col-9 order-list">
                    <h4 class="pb-2">My Orders ({{ count($orderDetails)}}) </h4>
                    <div class="existing-orderList">
                        @foreach ($orderDetails as $orderDetail)
                                <div class="row list-row mx-0 mt-3 p-0 border">
                                     <p class="order-id py-2">Order Id : #{{ $orderDetail->id }}</p>
                                     <div class="row order-detail">
                                        <div class="col-6">
                                            <p>Placed On : {{ date('d-m-Y',strtotime($orderDetail->order_created_date_time)) }}</p>
                                            <p>Delivery Date : {{ date('d-m-Y',strtotime($orderDetail->created_at->addDays(2))) }}</p>
                                        </div>
                                        <div class="col-6">
                                            @php
                                                $orderStatusValue = $orderStatus->where('id',$orderDetail->order_status)->value('status');
                                            @endphp
                                            <p>Your Order is {{ $orderStatusValue }} !</p>
                                        </div>
                                     </div>
                                     <div class="action text-center py-2">
                                          <a href="{{ route('orders.orderDetails') }}">View Details</a> |
                                          <a href="#">Cancel Order</a>
                                     </div>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
