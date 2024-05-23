@extends('admin.layouts.master')
@section('content')
    <div class="row justify-content-between w-100 mt-2">
        <div class="page-title col-6"><h5>Dashboard</h5></div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item" aria-current="page" active >Dashboard</li>
            </ol>
        </div>
    </div>
    <div class="container d-flex justify-content-center align-items-center mh-100 mt-5">
        <h2>Page Content</h2>
    </div>
@endsection
