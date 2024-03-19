@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Product Manufacturer</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Manufacturer</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Manufacturers</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal"
                    data-bs-target="#manufacturerModal">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Company Logo</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- model for edit products Manufacturer --}}
    <div class="modal" tabindex="-1" id="manufacturerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Manufacturer</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="manufacturerForm" name="manufacturerForm" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row justify-content-between">
                            <div class="form-group col-6">
                                <label for="manufacturerName" class="mb-1">Manufacturer Name</label>
                                <input type="text" class="form-control" name="manufacturerName" id="manufacturerName">
                            </div>
                            <div class="form-group col-6">
                                <label for="companyName" class="mb-1">Company Name</label>
                                <input type="text" class="form-control" name="companyName" id="companyName">
                            </div>
                        </div>
                        <div class="row my-3 justify-content-between">
                            <div class="form-group col-6">
                                <label for="companyLogo" class="mb-1">Company Logo</label>
                                <input type="file" name="companyLogo" id="companyLogo">
                            </div>
                            <div class="col-6 ps-3 mt-4">
                                <img src="{{ asset('assets/images/woocommerce-placeholder.webp') }}" alt="company logo"
                                    class=" w-25 ms-5" id="preview">
                            </div>
                            <label for="companyLogo" class="error" id="companyLogo-error"></label>
                        </div>
                        <div class="row my-3 justify-content-between">
                            <div class="form-group col-6">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" placeholder="Enter company address"
                                    class="form-control">
                            </div>
                            <div class="form-inline col-6">
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
                        <div class="buttons my-2 row justify-content-between">
                            <div class="col-2"><button type="button" class="btn me-3" data-bs-dismiss="modal"
                                    id="cancel">Cancel</button></div>
                            <div class="col-2"><button type="submit" name="save" id="save"
                                    class="btn">Save</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        /*image preview*/
        $('#companyLogo').change(function() {
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
        /* datatables*/
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manufacturer.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'name',
                    name: 'Name',
                },
                {
                    data: 'company_name',
                    name: 'company_name',
                },
                {
                    data: 'company_logo',
                    name: 'company_logo',
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        /* passing data to the store function in controller */
        $('#manufacturerForm').submit(function(e) {
            e.preventDefault();
            $("#save").html('Sending..');
            let data = new FormData(this);
            $.ajax({
                data: data,
                url: "{{ route('manufacturer.store') }}",
                contentType: false,
                processData: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#manufacturerForm').trigger("reset");
                    $('#manufacturerModal').modal('hide');
                    table.draw();
                    location.reload();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#save').html('Save Changes');
                }
            });
        });
        /* Edit manufacturer */
        $('body').on('click', '.editProduct', function() {
            var menu_id = $(this).data('id');
            $.get("{{ route('manufacturer.index') }}" + '/' + menu_id + '/edit', function(data) {
                $('#id').val(data.id);
                $('#modelHeading').html("Edit Manufacturer");
                $('#save').val("edit-manufacturer");
                $('#manufacturerModal').modal('show');
                $('#manufacturerName').val(data.name);
                $('#companyName').val(data.company_name);
                $('#address').val(data.address);
                $('.status').each(function() {
                    if ($(this).val() == data.status) {
                        $(this).prop("checked", true);
                    }
                });
                if (data.company_logo == '' || data.company_logo == null) {
                    $('#preview').attr('src', 'assets/images/woocommerce-placeholder.webp');
                } else {
                    $('#preview').attr('src', 'assets/images/manufacturers/' + data.company_logo);
                }
            })
        });
        /* Delete Manufacturer */
        $('body').on('click', '.deleteProduct', function() {
            /* sweet alert2 package for custom alert */
            Swal.fire({
                /* confirmation message popup */
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var menu_id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('manufacturer.index') }}" + '/' + menu_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                    /* After confirmation message popup */
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your details has been deleted.",
                        icon: "success"
                    });
                }
            });
        });
        $('#cancel').click(function() {
            $('#manufacturerForm').trigger('reset');
            location.reload();
        });
        /* product form validation */
        $("#manufacturerForm").validate({
            rules: {
                manufacturerName: 'required',
                status: 'required',
                companyLogo: 'required',
            }
        });
    </script>
@endpush
