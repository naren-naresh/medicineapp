@extends('admin.authentication.layout')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card-header text-center" style="font-size: 26px">Reset Password</div>
                    <div class="">
                        <form action="{{ route('reset.password.post') }}" method="POST" class="pb-5">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group row mt-2">
                                <label for="password" class="mb-2">Password</label>
                                <div class="">
                                    <input type="password" id="password" class="form-control" name="password" required
                                        autofocus>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row  mt-2">
                                <label for="password-confirm" class="mb-2">Confirm Password</label>
                                <div class="">
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation" required autofocus>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
