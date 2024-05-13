<div class="header-section">
    <div class="container py-3">
        <div class="row">
            <div class="col d-flex align-items-center">
                <a class="brand-logo d-flex align-items-center" href="{{ route('home')}}"><img class="logo" src="{{asset('assets/images/logo.png')}}" style="width: 200px"></a>
            </div>
            <div class="col d-flex flex-row justify-content-center align-items-center">
                <div class="location-icon pe-2"><i class="fas fa-map-marker-alt" style="color: #385399; font-size:1.7rem;"></i></div>
                <div class="text-content">
                    <p class="line1 m-0">Delivery Location</p>
                    <span>
                        <p class="line2">PostCode &nbsp;<span id="postal_code">{{session()->get('postal_code');}}</span> &nbsp;<a href="#" style="color: #385399" id="postalChange">Change</a> </p>
                    </span>
                </div>
            </div>
            <div class="col d-flex align-items-center">
                <div class="d-flex justify-content-between align-items-center border py-1" style="width: 450px">
                    <div class="search-field col-11"><input type="text" placeholder="Search Products" class="border-0 form-control" id="search-input"></div>
                    <div class="search-icon col-1"><a href="#"><i class='fa fa-search' style="color: #385399; font-size:1.5rem;"></i></a></div>
                </div>
                <ul class="search-result"></ul>
            </div>
            <div class="col d-flex align-items-center justify-content-around">
                @if ( auth()->id() )
                    <div class="nav-elements" id="navbarNav">
                        <ul class="dropdown p-0 m-0" style="font-size: 15px">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="navbarDropdown">Welcome |
                            {{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" >
                                <li><a class="dropdown-item" href="{{ route('useProfile.index') }}"><i class="fa fa-user"></i> &nbsp;Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('address.index') }}"><i class="fa fa-map-location"></i> &nbsp;My Addresses</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist.index') }}"><i class="fa fa-heart"></i> &nbsp;My Wishlist</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fa fa-cart-shopping"></i> &nbsp;My Orders</a></li>
                                @if (Auth::user()->role_id == 1)
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> &nbsp;Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="" id="btn" data-bs-toggle="modal"
                                        data-bs-target="#"><i class="fa fa-keyboard"></i> &nbsp;Change Password</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> &nbsp;Logout</a></li>
                            </ul>
                        </ul>
                    </div>
                @else
                    <div class="sign">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#signModal"'>Sign In</a>
                        <span>|</span>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal"'>Sign Up</a>
                    </div>
                @endif
                   <div class="cart">
                    @php
                        $rowCount = \App\Models\Cart::where('customer_id', auth()->id() ?? request()->session()->get('guest-id'))->count();
                    @endphp
                      <a href="{{ route('cart.index') }}" class="d-flex align-items-center cart"><i class="fa fa-shopping-cart" style="color:#385399; font-size:1.7rem"></i><span>{{ $rowCount }}</span> &nbsp;Cart</a>
                   </div>
            </div>
        </div>
    </div>
</div>
