<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Meta Title -->
    <title>Medicine Plus | @yield('meta-title', 'Dashboard')</title>
    <!-- csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/fav_icon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/toggle.css') }}">
    <!-- Font Awesome Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Layout Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    <!-- Data Table css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatable/datatable.css')}}">
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
            <footer class="d-flex justify-content-center align-items-end mt-auto d-none">
                @include('admin.layouts.footer')
            </footer>
        </div>
    </div>
    {{-- model for change password --}}
    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title">Password Updation</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('passwordupdate') }}" class=" d-flex justify-content-center" id="pform"
                        name="pform" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row w-75">
                            <div class="row">
                                <label for="oldpassword" class="p-0 mb-1">Current Password</label>
                                <div class="input-group p-0">
                                    <input type="password" name="oldpassword" id="oldpassword"
                                        placeholder="Enter your current password" class=" form-control oldpassword">
                                    <span class="input-group-text bg-white"><i class="fa fa-eye cicon"></i></span>
                                </div>
                                <label for="oldpassword" class="error" id="oldpassword-error"></label>
                                <label for="oldpassword" class="Error text-danger" id="oldpassword-error"></label>
                                @if (Session::has('error'))
                                    <span class="text-danger" role="alert">
                                        {{ Session::get('error') }}
                                    </span>
                                @endif
                                @if (!empty(Session::get('error')))
                                    <script>
                                        $(function() {
                                            $('#myModal').modal('show');
                                        });
                                    </script>
                                @endif
                                <label for="newpassword" class="p-0 mt-2 mb-1">New Password</label>
                                <div class="input-group p-0">
                                    <input type="password" id="newpassword" name="newpassword"
                                        placeholder="Enter your new password" class="newpassword form-control">
                                    <span class="input-group-text bg-white"><i class="fa fa-eye icon"></i></span>
                                </div>
                                <label for="newpassword" class="error" id="newpassword-error"></label>
                                <label for="cpassword" class="p-0 mt-2 mb-1">Confirm Password</label>

                                <input type="password" id="cpassword" name="cpassword"
                                    placeholder="Cofirm your password" class="cpassword form-control">

                            </div>
                            <div class="button mt-4">
                                <button type="button" class="btn me-3"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" name="submit" id="submit"
                                    class="btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
    <script src="{{ asset('assets/plugins/jqueryvalidation.js') }}"></script>
    <!--datatable-->
    <script src="{{ asset('assets/plugins/datatable/datatable.js')}}"></script>
    <!--sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    <script>
        // password hide and show eye toggle
        $('.icon').mousedown(function() {
            $('.newpassword').attr('type', 'text');
        });

        $('.icon').on('mouseup mouseleave', function() {
            $('.newpassword').attr('type', 'password');
        });
        $('.cicon').mousedown(function() {
            $('.oldpassword').attr('type', 'text');
        });

        $('.cicon').on('mouseup mouseleave', function() {
            $('.oldpassword').attr('type', 'password');
        });
        // client side validation
        $("#pform").validate({
            rules: {
                oldpassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                },
                newpassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                },
                cpassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                    equalTo: '#newpassword',
                },

            },
        });
        // ajax call for password update
        $(document).ready(function() {
            $('#submit').click(function(e) {
                e.preventDefault();
                let formdata = $('#pform').serialize();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ route('passwordupdate') }}',
                    data: formdata,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "{{ route('login') }}";
                        } else {
                            $("#myModal").find(".modal-body").find(".Error").html(response
                                .message);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
