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
            <h5 class="card-title">Sales Information</h5>
        </div>
        <div class="card-body px-5 py-3" style="background-color: #eaeaea;">
            <form action="" method="post" id="salesForm" name="salesForm">
                @csrf
                <div class="row">
                    <div class="from-group col-6">
                        <label for="retailPrice" class="required">Retail Price</label>
                        <input type="text" name="retailPrice" id="retailPrice" class="form-control mt-2">
                    </div>
                    <div class="from-group col-6">
                        <label for="sellingPrice" class="required">Selling Price</label>
                        <input type="text" name="sellingPrice" id="sellingPrice" class="form-control mt-2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="from-group col-6">
                        <label for="stocks">Stocks</label>
                        <input type="text" name="stocks" id="stocks" class="form-control mt-2">
                    </div>
                    <div class="from-group col-6">
                        <label for="thresholdQty">Threshold Qty</label>
                        <input type="text" name="thresholdQty" id="thresholdQty" class="form-control mt-2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="from-group col-6">
                        <label for="sku">Sku</label>
                        <input type="text" name="sku" id="sku" class="form-control mt-2">
                    </div>
                    <div class="col-6">
                        <div class="form-inline">
                            <fieldset>
                                <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;"> Have return
                                    policy ?
                                </legend>
                                <input type="radio" name="returnPolicy" id="yes" value="1"
                                    class="returnPolicy">
                                <label for="yes" class="me-2 ms-1">Yes</label>
                                <input type="radio" name="returnPolicy" id="no" value="0"
                                    class="returnPolicy">
                                <label for="no" class="ms-1">No</label>
                            </fieldset>
                            <label for="returnPolicy" class="ms-1 error" id="returnPolicy-error"></label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-between">
                    <div class="col-3"> <a href="{{ route('product.additionalInfo') }}" class="btn btn-light">Back</a></div>
                    <div class="col-3"><button type="submit" class="btn btn-primary">Next</button></div>
                </div>
            </form>
        </div>
        @push('scripts')
            <script>
                $("#salesForm").validate({
                    rules: {
                        retailPrice: 'required',
                        sellingPrice: 'required',
                    }
                });
            </script>
        @endpush
    @endsection
