<div class="header-section">
    <div class="container py-3">
        <div class="row">
            <div class="col d-flex align-items-center">
                <a class="brand-logo d-flex align-items-center" href="{{ route('home')}}"><img class="logo" src="{{asset('assets/images/logo.png')}}" style="width: 200px"></a>
            </div>
            <div class="col d-flex flex-row justify-content-center align-items-center">
                <div class="location-icon pe-2"><img class="icon" src="{{ asset('assets/frontend/images/location.png')}}" style="width: 27px"></div>
                <div class="text-content">
                    <p class="line1 m-0">Delivery Location</p>
                    <span>
                        <p class="line2">PostCode &nbsp;<a href="#">Change</a> </p>
                    </span>
                </div>
            </div>
            <div class="col d-flex align-items-center">
                <div class="d-flex">
                    <div class="search-field"><input type="text" placeholder="Search Products" class=" border-0 border-bottom" id="search-input"></div>
                    <div class="search-icon"><a href=""><img class="search-img" src="{{asset('assets/frontend/images/search1.png')}}" style="width: 30px"></a></div>
                </div>
                <ul class="search-result"></ul>
            </div>
            <div class="col d-flex align-items-center justify-content-around">
                   <div class="sign">
                        <a href="#">Sign In</a>
                        <span>|</span>
                        <a href="#">Sign Up</a>
                   </div>
                   <div class="cart">
                      <a href="#"><img class="cart-img" src="{{ asset('assets/frontend/images/cart.png') }}" style="width: 40px"><span></span> &nbsp;Cart</a>
                   </div>
            </div>
        </div>
    </div>
</div>
