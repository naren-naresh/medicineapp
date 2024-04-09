<div class="header-section">
    <div class="container py-3">
        <div class="row">
            <div class="col d-flex align-items-center">
                <a class="brand-logo d-flex align-items-center" href="{{ route('home')}}"><img class="logo" src="{{asset('assets/images/logo.png')}}" style="width: 200px"></a>
            </div>
            <div class="col d-flex flex-row justify-content-center align-items-center">
                <div class="location-icon pe-2"><i class="fas fa-map-marker-alt" style="color: #385399; font-size:2rem;"></i></div>
                <div class="text-content">
                    <p class="line1 m-0">Delivery Location</p>
                    <span>
                        <p class="line2">PostCode &nbsp;<a href="#" style="color: #385399">Change</a> </p>
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
                   <div class="sign">
                        <a href="#">Sign In</a>
                        <span>|</span>
                        <a href="#">Sign Up</a>
                   </div>
                   <div class="cart">
                      <a href="#" class="d-flex align-items-center"><i class="fa fa-shopping-cart" style="color:#385399; font-size:2rem"></i><span></span> &nbsp;Cart</a>
                   </div>
            </div>
        </div>
    </div>
</div>
