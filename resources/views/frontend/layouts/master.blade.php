<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medicine Plus</title>
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav_icon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/index.css') }}">
    <!-- Custom Style & Inbuilt Styles -->
    @stack('frontend-styles')
</head>

<body>
    <div class="page-header">
        <!-- header start -->
        @include('frontend.layouts.header')
        <!-- header end -->
        <!-- navbar start -->
        @include('frontend.layouts.navbar')
        <!-- navbar end -->
    </div>
    <div class="main-block">
        @yield('frontend-content')
    </div>
    <div class="page-footer">
        <!--footer start-->
        @include('frontend.layouts.footer')
        <!--footer end-->
    </div>
    <!-- modal for sign in -->
    <div class="modal" tabindex="-1" id="signModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" aria-label="Close" style="position: absolute; top: 10px; right: 10px; z-index: 999;" data-bs-dismiss="modal"></button>
                <div class="modal-body p-5 text-center">
                      <div class="modal-heading">
                        <h5 class="modal-title" id="modelHeading">Sign In</h5>
                        <p>If you have an account with us, Please Sign In.</p>
                      </div>
                    <form action="" id="signInForm" name="signInForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group position-relative">
                            <input type="email" class="form-control mt-2 py-3" name="email" id="email" placeholder="Email">
                            <i class="fas fa-envelope position-absolute top-50 end-0 translate-middle-y pe-2"></i>
                        </div>
                        <div class="form-group position-relative">
                            <input type="password"  class="form-control mt-2 py-3" name="password" id="password" placeholder="Password">
                            <i class="fas fa-lock position-absolute top-50 end-0 translate-middle-y pe-2"></i>
                        </div>
                        <div class="buttons my-2">
                            <button type="submit" name="save" id="save" class="form-control btn border py-2 my-1">LOGIN</button>
                             <div class="forget-password text-end">
                                <a href="#">Forget Password</a>
                             </div>
                        </div>
                        <div class="form-group text-start">
                            <div class="create-account"><span>Not a member yet? </span>&nbsp;<a href="#" style="color:#385399">Create an account</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal for sign up -->
    <div class="modal" tabindex="-1" id="signUpModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" aria-label="Close" style="position: absolute; top: 10px; right: 10px; z-index: 999;" data-bs-dismiss="modal"></button>
                <div class="modal-body p-5 text-center">
                      <div class="modal-heading">
                        <h5 class="modal-title" id="modelHeading">Sign Up</h5>
                        <p>New Login</p>
                      </div>
                    <form action="" id="signUpForm" name="signUpForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row mt-2">
                              <div class="col pe-0"><input type="text" class="form-control py-3" name="firstName" id="firstName" placeholder="First Name*"></div>
                              <div class="col"><input type="text" class="form-control  py-3" name="lastName" id="lastName" placeholder="last Name*"></div>
                        </div>
                        <div class="form-group position-relative">
                            <input type="email" class="form-control mt-2 py-3" name="email" id="email" placeholder="Email">
                            <i class="fas fa-envelope position-absolute top-50 end-0 translate-middle-y pe-2"></i>
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" name="contact" class="form-control py-3" id="contact" placeholder="Contact Number">
                        </div>
                        <div class="row">
                            <div class="col pe-0 form-group position-relative">
                                <input type="password"  class="form-control mt-2 py-3" name="password" id="password" placeholder="Password*">
                                <i class="fas fa-lock position-absolute top-50 end-0 translate-middle-y pe-2"></i>
                            </div>
                            <div class="col form-group position-relative">
                                <input type="password"  class="form-control mt-2 py-3" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password *">
                            <i class="fas fa-lock position-absolute top-50 end-0 translate-middle-y pe-4"></i>
                            </div>
                        </div>
                        <div class="buttons my-2">
                            <button type="submit" name="save" id="save" class="form-control btn border py-2 my-1">SignUp</button>
                        </div>
                        <div class="form-group text-start ms-1">
                            <div class="create-account"><span>Already have an account? </span>&nbsp;<a href="#" style="color:#385399">Sign in</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('assets/js/frontend/index.js') }}"></script>
    <!-- sweet alert -->
    <script src="{{ asset('assets/plugins/sweetalter/sweetalter.js') }}"></script>
    @stack('frontend-scripts')
</body>

</html>
