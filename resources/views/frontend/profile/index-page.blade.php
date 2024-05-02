@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/add_address.css') }}">
    @endPushOnce
    <section class="address-list-section py-5">
        <div class="container">
            <div class="row  address-content">
                <div class="col-3 pe-5">
                    <div class="row mb-4 user-name-block align-items-center">
                        <div class="col-1 user-icon"> <i class="fa fa-user-circle"></i></div>
                        <div class="col ps-4">
                            <div class="row">
                                <span>Hello</span>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row menu-options">
                        <a href="#">
                            <div class="option"><i class="fa fa-user"></i>&nbsp; Personal Information</div>
                        </a>
                        <a href="{{ route('address.index') }}">
                            <div class="option active"><i class="fa fa-map-location"></i>&nbsp; Manage Addresses</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-heart"></i> &nbsp;My Wishlist</div>
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
                <div class="col-9 address-form">
                    <h4 class="pb-2">Manage Addresses</h4>
                    <div class="add-address-btn"><a href="{{ route('add.address') }}"
                            class="d-flex align-items-center"><span class="ps-3">+</span>&nbsp; Add a New Address</a>
                    </div>
                    <div class="existing-addresses">
                        @foreach ($addresses as $address)
                            <div class="row add-row mx-0 mt-3">
                                <div class="col-6">
                                    <p>Name : {{ $address->name }}</p>
                                    <p>Address : {{ $address->address }}</p>
                                    <p>PostalCode : {{ $address->postal_code }}</p>
                                    <p>Number : {{ $address->contact_number }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="action-row">
                                        <a href="{{ route('address.default', $address->id) }}" class="default-check"
                                            default="{{ $address->set_default }}"><i class="fa fa-check"
                                                id="check-icon"></i>&nbsp;<span class="text">Set Default</span></a> &nbsp; | &nbsp;
                                        <a href="{{ route('address.edit', $address->id) }}"><i
                                                class="fa fa-edit"></i>&nbsp;Edit </a> &nbsp; | &nbsp;
                                        <a href="{{ route('address.delete', $address->id) }}"><i
                                                class="fa fa-trash"></i>&nbsp;Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @pushOnce('frontend-scripts')
        <script>
            $(document).ready(function() {
                if ($('.action-row').children('.default-check').attr('default') == 1) {
                    $(this).find('#check-icon').removeClass('fa-check');
                    $(this).find('#check-icon').addClass('fa-check-circle');
                    $(this).find('#check-icon').siblings().text('Selected');

                }
            });
            $('.action-row').children('.default-check').click(function(e) {
                if (!confirm("Are you sure you want to change the current address?")) {
                  e.preventDefault();
                  location.reload();
                }else{
                    submit();
                }
                $(this).find('#check-icon').toggleClass('fa-check fa-check-circle');
            })
        </script>
    @endPushOnce
@endsection
