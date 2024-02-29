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
            <h5 class="card-title">Basic Information</h5>
        </div>
        <div class="car-body px-5 py-3" style="background-color: #eaeaea;">
            <form action="{{route('product.basicInfo.post')}}" name="productForm" id="productForm" method="post">
                @csrf
                <div class="row">
                    <div class="from-group col-6">
                        <label for="createdFor" class="required">Created For</label>
                        <input type="text" name="createdFor" id="createdFor" placeholder="Ex: SteveVendor(SV)"
                            class="form-control mt-2">
                    </div>
                    <div class="from-group col-6">
                        <label for="productName" class="required">Product Name</label>
                        <input type="text" name="productName" id="productName" placeholder="Enter product name"
                            class="form-control mt-2">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="category" class="required">Category</label>
                        <select class="form-control mt-2" name="parentCategory " id="parentCategory">
                            <option value="option_select" disabled selected>Select Category</option>
                            @foreach ($categories as $categoryName)
                                <option value="{{ $categoryName->id }}">{{ $categoryName->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="category" class="required">Sub Category</label>
                        <select class="form-control mt-2" name="childCategory " id="childCategory">
                            <option value="option_select" disabled selected>Select Sub Category</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="description" class="mb-2">Product Description</label>
                    <textarea name="description" id="description" class="mt-2"></textarea>
                </div>
                <div class="row mt-2">
                    <label class="mb-3">Product Image</label>
                    <input type="file" name="image" id="image" class="mt-2 d-none"></input>
                    <label for="image" class="mb-3" style="width: fit-content;"><span
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
            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: '#description', // change this value according to your HTML
                    menu: {
                        file: {
                            title: 'File',
                            items: 'newdocument restoredraft | preview | export print | deleteallconversations'
                        },
                        edit: {
                            title: 'Edit',
                            items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'
                        },
                        view: {
                            title: 'View',
                            items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments'
                        },
                        insert: {
                            title: 'Insert',
                            items: 'image link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime'
                        },
                        format: {
                            title: 'Format',
                            items: 'bold italic underline strikethrough superscript subscript codeformat | styles blocks fontfamily fontsize align lineheight | forecolor backcolor | language | removeformat'
                        },
                        tools: {
                            title: 'Tools',
                            items: 'spellchecker spellcheckerlanguage | a11ycheck code wordcount'
                        },
                        table: {
                            title: 'Table',
                            items: 'inserttable | cell row column | advtablesort | tableprops deletetable'
                        },
                        help: {
                            title: 'Help',
                            items: 'help'
                        }
                    }
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
                $('#parentCategory').change(function() {
                    var data = $(this).val();
                    $.ajax({
                        data: {
                            'parentId': data
                        },
                        url: "{{ route('product.basicInfo') }}",
                        type: "get",
                        success: function(data) {
                            $('#childCategory').empty();
                            for (item of data) {
                                $('#childCategory').append("<option>" + item.name + "</option>")
                            }
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
