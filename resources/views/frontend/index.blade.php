<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Meta title -->
    <title>Home</title>
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav_icon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/index.css')}}">
</head>

<body>
     <!--page header block start -->
     @include('frontend.layouts.header')
     <!-- page header end -->
     <!-- page navbar block start-->
     @include('frontend.layouts.navbar')
     <!-- page navbar block end -->
     <!--page banner start-->
    <section class="slider-section" id="slider-section">
          <div class="slider-content">
              <ul class="slider">
                <li class="slide1">
                    <div class="slider-title-wrapper">
                        <h3 class="slider-title"><span class="slider-title-h3">Slide 1</span>
                <span class="slider-subtitle">This is the first slide</span></h3>
                    </div>
                    <img src="{{ asset('assets/frontend/images/banner1.jpg') }}">
                </li>
                <li class="slide2">
                    <div class="slider-title-wrapper">
                        <h3 class="slider-title"><span class="slider-title-h3">Slide 2</span>
                <span class="slider-subtitle">This is the second slide</span></h3>
                    </div>
                    <img src="{{ asset('assets/frontend/images/banner2.webp') }}">
                </li>
                <li class="slide2">
                    <div class="slider-title-wrapper">
                        <h3 class="slider-title"><span class="slider-title-h3">Slide 3</span>
                <span class="slider-subtitle">This is the third slide</span></h3>
                    </div>
                    <img src="{{ asset('assets/frontend/images/banner3.webp') }}">
                </li>
              </ul>
          </div>
    </section>
     <!--page banner end-->
     <!-- category block -->
     <section class="category-section end">
        <div class="container">
            <div class="row d-flex py-3 px-4" id="category-row">
                <div class="category-list-block d-flex justify-content-around align-items-center">
                    @foreach ($categories as $cat )
                        <a href="#" class="category-list text-center" style="width: 15.25%;">
                            <div class="cat-con">
                                <div class="cat-img"><img src="{{ asset('assets/images/'.$cat->image.'') }}"></div>
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
     <section class="product-section">
        <div class="container">
            <div class="section-title">
                <h4 class="h4">Most Recent<small style="font-size: 16px"> Products</small></h4>
            </div>
            <div class="row pt-3">
                @foreach ($products as $product )
                    <div class="col-3 p-card">
                        <div class="pc-con">
                            <div class="pc-img">
                                <img src="{{ asset('assets/images/products/'.$product->id.'/'.$product->cover_image.'') }}">
                                <span><a href="#"><i class="far fa-heart"></i></a></span>
                            </div>
                            <div class="pc-text py-3">
                                <h5 class="pc-title">{{$product->name}}</h5>
                                <div class="price py-1" style="font-size: 16px">$ {{$product->selling_price}}</div>
                                <span class="d-status text-danger">Only pickup available</span>
                                <div class="pc-view pt-2">
                                    <a href="#" class="pc-btn">View</a>
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
                                    <input type="email" name="email" id="newCusMail" placeholder="Enter your email address..." class=" form-control">
                                </div>
                                <div class="col-4 p-0">
                                    <button type="submit" id="subscribe" class="form-control">Submit</button>
                                </div>
                            </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
     </section>
     <!-- get order block end-->
     <!--page footer Start-->
      @include('frontend.layouts.footer')
     <!--page footer end-->
    <!--jquery plugin-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!--bootstrap js plugin-->
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/toggle.js') }}"></script>
    <!-- jquery validation plugin-->
    <script src="{{ asset('assets/plugins/jqueryvalidation.js') }}"></script>
    <!-- jquery steps plugin-->
    <script src="{{ asset('assets/plugins/jquery/steps.min.js') }}"></script>
    <!-- Custom js for the page-->
    <script src="{{ asset('assets/css/frontend/index.js') }}"></script>
</body>

</html>
