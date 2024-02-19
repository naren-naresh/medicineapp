@extends('admin.authentication.layout')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    {{-- login form content --}}
    <form action="{{ route('authenticate') }}" method="post" name="form" id="loginform" class="mt-4 px-3">
        @csrf
        <div class="row px-5 justify-content-center">
            <div class="row mb-2">
                {{-- email inputs --}}
                <input type="email" id="email" name="email" placeholder="Email" class="form-control py-2 rounded-1">
                <p class="error" id="email-error"></p>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                {{-- password inputs --}}
                <div class="input-group p-0">
                    <input type="password" id="password" name="password" placeholder="Password"
                        class="password form-control py-2 rounded-1">
                    <span class="input-group-text bg-white"><i class="fa fa-eye icon rounded-1"></i></span>
                </div>
                <label for="password" id="password-error" class="error"></label>
                <a href="{{ route('forget.password.get') }}" style="text-decoration: none" class="text-end mt-2">Forget
                    password ?</a>
            </div>
            <div class="button text-center mt-3 mb-5">
                <button type="submit" id="submit" class="btn btn-primary form-control py-2 rounded-1">LOGIN</button>
            </div>
        </div>
    </form>
    <script>
        $('.icon').mousedown(function() {
            $('.password').attr('type', 'text');
        });

        $('.icon').on('mouseup mouseleave', function() {
            $('.password').attr('type', 'password');
        });
        // form validation
        $(document).ready(function() {
            $("#loginform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 15,
                    },
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                    },
                    password: {
                        required: "Please enter a password",
                    }
                },
            });
        });
    </script>
@endsection
