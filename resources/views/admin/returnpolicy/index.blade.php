@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-2 mb-5">
        <div class="page-title col-6">
            <h5>Products Return Policy</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products Return Policy</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Return Policy</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal"
                    data-bs-target="#returnPolicyModal">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- model for edit products Return Policy --}}
    <div class="modal" tabindex="-1" id="returnPolicyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Return Policy</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="returnPolicyForm" name="returnPolicyForm" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="policyName" class="mb-1">Policy Name</label>
                            <input type="text" class="form-control" name="policyName" id="policyName">
                        </div>
                        <div class="form-group mt-2">
                            <label for="policyDetails" class="mb-1">Policy details</label>
                            <input type="text" class="form-control" name="policyDetails" id="policyDetails">
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
                        <div class="buttons my-2">
                            <button type="button" class="btn me-3" data-bs-dismiss="modal" id="cancel">Cancel</button>
                            <button type="submit" name="save" id="save" class="btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
            language: {
                lengthMenu: 'Show _MENU_ entries',
            },
            ajax: "{{ route('return_policy.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },{
                    data: 'policy_name',
                    name: 'policy_name',
                },
                {
                    data: 'policy_details',
                    name: 'policy_details',
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
          /* passing data to the store function in controller*/
          $('#returnPolicyForm').submit(function(e) {
            e.preventDefault();
            $("#save").html('Sending..');
            let data = new FormData(this);
            $.ajax({
                data: data,
                url: "{{ route('return_policy.store') }}",
                contentType: false,
                processData: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#returnPolicyForm').trigger("reset");
                    $('#returnPolicyModal').modal('hide');
                    table.draw();
                    location.reload();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#save').html('Save Changes');
                }
            });
        });
        /* Edit return policy */
        $('body').on('click', '.editProduct', function() {
            var returnPolicy_id = $(this).data('id');
            $.get("{{ route('return_policy.index') }}" + '/' + returnPolicy_id + '/edit', function(data) {
                $('#id').val(data.id);
                $('#modelHeading').html("Edit brand");
                $('#save').val("edit-brand");
                $('#returnPolicyModal').modal('show');
                $('#policyName').val(data.policy_name);
                $('#policyDetails').val(data.policy_details);
                $('.status').each(function() {
                    if ($(this).val() == data.status) {
                        $(this).prop("checked", true);
                    }
                });
            })
        });
        /* Delete brand */
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
                        var returnPolicy_id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('return_policy.index') }}" + '/' + returnPolicy_id,
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
            $('#cancel').click(function () {
                 $('#returnPolicyForm').trigger('reset');
                 location.reload();
            });
            /* product form validation */
            $("#returnPolicyForm").validate({
               rules:{
                 policyName:'required',
                 status:'required',
                 policyDetails:'required',
               }
            });
    </script>
@endpush
