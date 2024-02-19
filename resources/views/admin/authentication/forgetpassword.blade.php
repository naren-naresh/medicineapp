@extends('admin.authentication.layout')

@section('content')
    <div class="forget px-5">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <form action="{{ route('forget.password.post') }}" method="post" name="eform" id="eform" class="pb-5">
            @csrf
            <div class="row">
                <label for="email" class="p-0 mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <p class="error" id="email-error"></p>
                <div class="button d-flex justify-content-between mt-2">
                    <a href="{{ route('login') }}" class="btn btn-dark ">Cancel</a>
                    <button type="submit" id="sbtn" class="btn btn-primary">Get code</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
           $('#eform').validate({
             rules:{
                email:'required',
             }
           });
        });
    </script>
@endsection
