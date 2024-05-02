@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/user_profile.css') }}">
    @endPushOnce
    <section class="user-profile-section  py-5">
        <div class="container">
            <div class="row profile-content">
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
                        <a href="{{ route('useProfile.index') }}">
                            <div class="option active"><i class="fa fa-user"></i>&nbsp; Personal Information</div>
                        </a>
                        <a href="{{ route('address.index') }}">
                            <div class="option"><i class="fa fa-map-location"></i>&nbsp; Manage Addresses</div>
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
                <div class="col-9 user-profile-information">
                    <h4 class="pb-2">Profile</h4>
                    @foreach ($userInformation as $info)
                        <form action="{{ route('address.store') }}" method="post" name="userForm" id="userForm">
                            @csrf
                            <div class="row py-3">
                                <div class="col-6 form-group">
                                    <label for="name" class="pb-2 required">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $info->name }}">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="email" class="required pb-2">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $info->email }}">
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-6 form-group">
                                    <label for="contact" class="required pb-2">Contact</label>
                                    <input type="text" name="contact" id="contact" class="form-control" maxlength="6"
                                        onkeyup="process(this)" value="{{ $info->contact }}">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="gender" class="required pb-2">Gender</label>
                                    <input type="text" name="gender" id="gender" class="form-control" value="{{ $info->gender }}">
                                </div>
                            </div>
                            <div class="form-group pt-3">
                                <label for="image" class="required pb-2">Image</label>
                                <img src="" name='image' id="image">
                            </div>
                            <div class="form-group pt-3">
                                <button type="submit" class="px-2 py-1" id="save-btn">Edit</button>
                                <button type="button" class="px-2 py-1 ms-2" id="cancel-btn">Cancel</button>
                            </div>
                        </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection
