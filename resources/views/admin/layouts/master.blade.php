<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Meta Title -->
    <title>Medicine Plus | @yield('meta-title', 'Dashboard')</title>
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav_icon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Layout Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
</head>

<body>
    @include('admin.layouts.header')
    <div class="main">
        <!-- /#sidebar-wrapper -->
        @include('admin.layouts.sidebar')
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid d-flex justify-content-center align-items-center flex-column">
                @yield('content')
            </div>
             <!--Footer-->
             <footer class="d-flex justify-content-center align-items-end mt-auto">
                @include('admin.layouts.footer')
             </footer>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    <!--jquery plugin-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!--bootstrap js plugin-->
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <!--layout script file -->
    <script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>
    <!--bootstrap toggle switches plugin-->
    <script src="{{ asset('assets/plugins/bootstrap/toggle.js') }}"></script>
    <!-- jquery validation plugin-->
    <script src="{{ asset('assets/plugins/jqueryvalidation.js')}}"></script>
    @stack('scripts')
</body>

</html>
