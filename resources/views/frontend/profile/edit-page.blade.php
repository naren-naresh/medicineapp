@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/add_address.css') }}">
    @endPushOnce
    <section class="add-address-section py-5">
        <div class="container">
            <div class="row  address-content">
                <div class="col-3 pe-5">
                    <div class="row mb-4 user-name-block align-items-center">
                        <div class="col-3 user-icon">
                            <img src="{{ asset('assets/images/user/' . auth()->id() . '/' . Auth::user()->image . '') }}"
                            class="w-100">
                        </div>
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
                            <div class="option active"><i class="fa fa-map-location"></i>&nbsp; Manage Addresses</div>
                        </a>
                        <a href="{{ route('wishlist.index') }}">
                            <div class="option"><i class="fa fa-heart"></i> &nbsp;My Wishlist</div>
                        </a>
                        <a href="{{ route('orders.index') }}">
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
                    @foreach ($addresses as $address)
                    <form action="{{ route('address.update',$address->id) }}" method="post" name="addressForm" id="addressForm">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{auth()->id()}}">
                        <div class="row py-3">
                            <div class="col-4 form-group">
                                <label for="name" class="pb-2 required">Name</label>
                                <input type="text" name="name" id="name" class="form-control"  value="{{ $address->name }}">
                            </div>
                            <div class="col-4 form-group">
                                <label for="number" class="required pb-2">Number</label>
                                <input type="text" name="number" id="number" class="form-control" maxlength="10" onkeyup="process(this)"  value="{{ $address->contact_number }}">
                            </div>
                            <div class="col-4 form-group">
                                <label for="postal_code" class="required pb-2">Post Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control"
                                    maxlength="6" onkeyup="process(this)"  value="{{ $address->postal_code }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="required pb-2">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ $address->address }}">
                        </div>
                        <div class="form-group pt-2">
                            <label for="notes" class="pb-2">Notes</label>
                            <textarea name="notes" id="notes" cols="10" rows="5" class="form-control">{{ $address->notes }}</textarea>
                        </div>
                        <div class="form-group pt-3">
                            <button type="submit" class="px-2 py-1" id="save-btn">Save</button>
                            <button type="button" class="px-2 py-1 ms-2" id="cancel-btn">Cancel</button>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @pushOnce('frontend-scripts')
        <script>
            /** address form validation */
            $("#addressForm").validate({
                rules: {
                    name:'required',
                    address: "required",
                    number: "required",
                    postal_code: "required",
                },
                messages: {
                    name: 'Name is required.',
                    address: 'Address is required.',
                    number: 'Number is required.',
                    postal_code: 'Postal code is required.'
                }
            });
            function process(input) {
                let value = input.value;
                // Remove all non-numeric characters except the decimal point
                let validNumber = value.replace(/[^\d.]/g, "");
                // Ensure only one decimal point is present
                let cleanedValue = validNumber.replace(/(\..*)\./g, "$1");
                input.value = cleanedValue; // Update the input value
            }
        </script>
    @endPushOnce
@endsection
