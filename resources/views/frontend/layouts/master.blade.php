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
    <!-- header start -->
    @include('frontend.layouts.header')
    <!-- header end -->
    <!-- navbar start -->
    @include('frontend.layouts.navbar')
    <!-- navbar end -->
    <div class="main-block">
        @yield('frontend-content')
    </div>
    <!--footer start-->
    @include('frontend.layouts.footer')
    <!--footer end-->
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
