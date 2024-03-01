@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <!--breadcrumbs of page-->
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Product</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Additional Information</h5>
        </div>
        <div class="card-body px-5 py-3" style="background-color: #eaeaea;">
            <form action="{{ route('product.additionalInfo.post') }}" method="post" id="addInfoFrom" name="addInfoFrom">
                @csrf
                <div class="row">
                    <div class="from-group col-6">
                        <label for="brand" class="required">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control mt-2">
                    </div>
                    <div class="from-group col-6">
                        <label for="manufacturer" class="required">Manufacturer</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control mt-2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="from-group col-6">
                        <label for="manufacturerDate" class="required">Manufacturer Date</label>
                        <input type="date" name="manufacturerDate" id="manufacturerDate"
                            placeholder="Ex: SteveVendor(SV)" class="form-control mt-2">
                    </div>
                    <div class="from-group col-6">
                        <label for="expiryDate" class="required">Expiry Date</label>
                        <input type="date" name="expiryDate" id="expiryDate" placeholder="Enter product name"
                            class="form-control mt-2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="deliveryType" class="required">Delivery type</label>
                        <select class="form-control mt-2" name="deliveryType " id="deliveryType">
                            <option value="option_select" disabled selected>Select Category</option>
                            @foreach ($deliveryTypes as $deliveryType)
                                <option value="{{ $deliveryType->id }}">{{ $deliveryType->types }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Tax Include ?
                                </legend>
                                <input type="radio" name="taxInclude" id="yes" value="1" class="taxInclude">
                                <label for="yes" class="me-2 ms-1">Yes</label>
                                <input type="radio" name="taxInclude" id="no" value="0" class="taxInclude">
                                <label for="no" class="ms-1">No</label>
                            </fieldset>
                            <label for="taxInclude" class="ms-1 error" id="taxInclude-error"></label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-between">
                    <div class="col-3"> <a href="{{ route('product.basicInfo') }}" class="btn btn-light">Back</a></div>
                    <div class="col-3"><button type="submit" class="btn">Next</button></div>
                </div>
            </form>
        </div>
        @push('scripts')
            <script>
                $("#addInfoFrom").validate({
                    rules: {
                        brand: 'required',
                        manufacturer : 'required',
                        manufacturerDate : 'required',
                        expiryDate : 'required',
                    }
                });
            </script>
        @endpush
    @endsection
