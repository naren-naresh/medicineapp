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
            <h5>Delivery Types</h5>
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
            <h5 class="card-title">Products Information</h5>
        </div>
        <div class="car-body px-5 py-3" style="background-color: #eaeaea;">
            <form action="" name="productForm" id="productForm" method="post">
                @csrf
                <div class="row">
                    <div class="from-group col-6">
                        <label for="createdFor" class="required">Created For</label>
                        <input type="text" name="createdFor" id="createdFor" placeholder="Ex: SteveVendor(SV)"
                            class="form-control">
                    </div>
                    <div class="from-group col-6">
                        <label for="productName" class="required">Product Name</label>
                        <input type="text" name="productName" id="productName" placeholder="Enter product name"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label for="category" class="required">Category</label>
                    <div class="row">
                        <div class="col-5">
                            <select class="form-control" name="parentCategory " id="parentCategory">
                                <option value="option_select" disabled selected>Select Category</option>
                                @foreach ($categories as $categoryName)
                                    <option value="{{ $categoryName->id }}">{{ $categoryName->name }} <i
                                            class="fa fa-angle-double-right"></i></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <select class="form-control" name="childCategory " id="childCategory">
                                <option value="option_select" disabled selected>Select Sub Category</option>
                                @foreach ($parentCategory as $parentCategory)
                                    <option class=" border-bottom py-1">{{ $parentCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row w-100">
                    <label for="description">Product Description</label>
                    <div name="description" id="description" class="mt-2"></div>
                </div>
                <div class="row">
                    <label class="mb-3">Product Image</label>
                    <input type="file" name="image" id="image" class="mt-2 d-none"></input>
                    <label for="image" class="mb-3"><span
                            class="py-3 px-2 bg-white text-secondary">image</span></label>
                </div>
                <div class="row mt-2">
                    <div class="form-inline">
                        <fieldset>
                            <legend class="mb-1" style=" font-size:16px;font-weight:unset !important;">Status
                            </legend>
                            <input type="radio" name="status" id="active" value="1" class="status">
                            <label for="active" class="me-2 ms-1">Active</label>
                            <input type="radio" name="status" id="inactive" value="0" class="status">
                            <label for="inactive" class="ms-1">InActive</label>
                        </fieldset>
                        <label for="status" class="ms-1 error" id="status-error"></label>
                    </div>
                </div>
                <div class="row mt-3 d-flex justify-content-between">
                    <div class="col-3"> <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a></div>
                    <div class="col-3"><button type="submit" class="btn btn-primary">Next</button></div>
                </div>
            </form>
        </div>
        @push('scripts')
            <!-- CK Editor -->
            <script src="{{ asset('assets/plugins/ck_editor/editor.js') }}"></script>
            <script>
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch(error => {
                        console.error(error);
                    });
                $("#productForm").validate({
                    rules: {
                        productName: 'required',
                        createdFor: 'required',
                    }
                });
                /* csrf token*/
                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                })
                /* passing parent id data to controller*/
                $('#parentCategory ').change(function(e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    $.ajax({
                        data: data,
                        url: "{{ route('product.index') }}",
                        contentType: false,
                        processData: false,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            console.log('success:', 'hello');
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#save').html('Save Changes');
                        }
                    });
                });
            </script>
        @endpush
    @endsection
