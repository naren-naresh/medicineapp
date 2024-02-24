@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-2">
        <div class="page-title col-6">
            <h5>Products Category</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products Category</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Categories</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal" data-bs-target="#pcModal">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Created By</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- model for edit products category --}}
    <div class="modal" tabindex="-1" id="pcModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Category</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="pcform" name="pcform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="cname" class="mb-1">Category Name</label>
                            <input type="text" class="form-control" name="cname" id="cname">
                        </div>
                        <div class="form-group">
                            <label for="pcategory" class="mb-1">Parent Category</label>
                            {{-- <input type="text" class="form-control" name="pcategory" id="pcategory"> --}}
                            <select class="form-control" name="pcategory" id="pcategory">
                                <option value="option_select" disabled selected>Select Product</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
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
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-6">
                                <label for="img" class="mb-1">Image</label>
                                <input type="file" name="img" id="img">
                            </div>
                            <div class="col-6">
                                <img src="" alt="product image" class="mt-2 w-25 ms-2" id="preview">
                            </div>
                        </div>
                        <div class="buttons mt-4">
                            <button type="button" class="btn me-3" data-bs-dismiss="modal" id="cancel">Cancel</button>
                            <button type="submit" name="save" id="save" class="btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            /*image preview*/
            $('#img').change(function() {
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });
            /* csrf token*/
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })
            /* datatable*/
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('category.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'parent_category_id',
                        name: 'parent_category_id',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'image',
                        name: 'image',
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            /*Edit product*/
            $('body').on('click', '.editProduct', function() {
                var product_id = $(this).data('id');
                $.get("{{ route('category.index') }}" + '/' + product_id + '/edit', function(data) {
                    $('#id').val(data.id);
                    $('#modelHeading').html("Edit Product");
                    $('#save').val("edit-user");
                    $('#pcModal').modal('show');
                    $('#cname').val(data.name);
                    $('#pcategory').val(data.parent_category_id);
                    $('#pcategory option[value=' + product_id + ']').hide();
                    // $('input[name="status"][value=+data.status]').prop("checked",true);
                    $('.status').each(function() {
                        if ($(this).val() == data.status) {
                            $(this).prop("checked", true);
                        }
                    });
                    if (data.image == '' || data.image == null) {
                        $('#preview').attr('src', 'assets/images/woocommerce-placeholder.webp');
                    }else{
                    $('#preview').attr('src', 'assets/images/' + data.image);
                    }
                })
            });
            /* passing data to the store fuction in controller*/
            $('#pcform').submit(function(e) {
                e.preventDefault();
                $("#save").html('Sending..');
                let data = new FormData(this);
                $.ajax({
                    data: data,
                    url: "{{ route('category.store') }}",
                    contentType: false,
                    processData: false,
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#pcform').trigger("reset");
                        $('#pcModal').modal('hide');
                        table.draw();
                        location.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#save').html('Save Changes');
                    }
                });
            });
            /*Delete products*/
            $('body').on('click', '.deleteProduct', function() {
            /* sweet alert2 package for custom alert */
                Swal.fire({
                    /* confrimation message popup */
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var product_id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('category.index') }}" + '/' + product_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                    /* After conforimation message popup */
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            });
            $('#cancel').click(function () {
                 $('#pcform').trigger('reset');
            });
        </script>
    @endpush
@endsection
