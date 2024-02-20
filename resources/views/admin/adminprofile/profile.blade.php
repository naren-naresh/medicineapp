@extends('admin.layouts.master')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card w-50 mt-5 bg-secondary text-white">
        <div class="card-header">Profile Information</div>
        <div class="card-body">
            <div class="row ms-5 mt-2">
                <div class="col-4">
                    <div class="from-group d-flex flex-column">
                        <img src="assets/images/{{ $user->image }}" alt="profile" class="w-50 h-25 mb-4 ms-2"
                            style="border-radius: 30%;">
                        <div class="button mb-5">
                            <a href="{{ route('dashboard') }}" class="btn btn-info p-1">Back</a>
                            <a href="" class="btn btn-info ms-2 p-1">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="col-8 px-0">
                    <div class="from-group">
                        <label for="name">Name :</label>&nbsp;
                        <span>{{ $user->name }}</span>
                    </div>
                    <div class="from-group mt-1">
                        <label for="name">Email :</label>&nbsp;
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="from-group mt-1">
                        <label for="name">Contact :</label>&nbsp;
                        <span>{{ $user->contact }}</span>
                    </div>
                    <div class="from-group mt-1">
                        <label for="name">Gender :</label>&nbsp;
                        <span>{{ $user->gender }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
