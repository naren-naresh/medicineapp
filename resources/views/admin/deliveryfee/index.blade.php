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
            <h5>Delivery Fee</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Delivery Fee</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Delivery Fee</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal" data-bs-target="#dfModal">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Zone Group</th>
                        <th>Delivery Fee</th>
                        <th>Delivery Type</th>
                        <th>Status</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
   <!-- Model for Delivery Fee -->
    <div class="modal" tabindex="-1" id="dfModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Delivery Fee</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="dfform" name="dfform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="zgroup" class="mb-1">Zone Group</label>
                            <select class="form-control" name="zgroup" id="zgroup">
                                <option value="option_select" disabled selected>Select Zone</option>
                                @foreach ($zone_groups as $zone)
                                    <option value="{{ $zone->id }}">
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dfee" class="my-1">Delivery Fee</label>
                            <input type="text" id="dfee" name="dfee" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="form-group">
                            <label for="dtype" class="mb-1">Delivery Type</label>
                            <select class="form-control" name="dtype" id="dtype">
                                <option value="option_select" disabled selected>Select Delivery Type</option>
                                @foreach ($delivery_types as $dtype)
                                    <option value="{{ $dtype->id }}">
                                        {{ $dtype->types }}
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
                                <label for="status" class="ms-1 error" id="status-error"></label>
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
    <!-- Scripts -->
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
             /* datatable */
             var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('delivery_fee.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'zone_group_id',
                        name: 'zone_group_id',
                    },
                    {
                        data: 'delivery_fee',
                        name: 'delivery_fee',
                    },
                    {
                        data: 'delivery_type_id',
                        name: 'delivery_type_id',
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
              /*Edit product*/
              $('body').on('click', '.editProduct', function() {
                var id = $(this).data('id');
                $.get("{{ route('delivery_fee.index') }}" + '/' + id + '/edit', function(data) {
                    $('#id').val(data.id);
                    $('#modelHeading').html("Edit Product");
                    $('#save').val("edit-user");
                    $('#dfModal').modal('show');
                    $('#zgroup').val(data.zone_group_id);
                    $('#dfee').val(data.delivery_fee);
                    $('#dtype').val(data.delivery_type_id)
                    $('#zgroup option[value=' + id + ']').hide();
                    $('.status').each(function() {
                        if ($(this).val() == data.status) {
                            $(this).prop("checked", true);
                        }
                    });
                })
            });
             /* passing data to the store function in controller*/
             $('#dfform').submit(function(e) {
                e.preventDefault();
                $("#save").html('Sending..');
                let data = new FormData(this);
                $.ajax({
                    data: data,
                    url: "{{ route('delivery_fee.index') }}",
                    contentType: false,
                    processData: false,
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#dfform').trigger("reset");
                        $('#dfModal').modal('hide');
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
                        var id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('delivery_fee.index') }}" + '/' +id,
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
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            });
            $('#cancel').click(function () {
                 $('#dfform').trigger('reset');
                 location.reload();
            });
             /* deliveryFee form validation */
             $("#dfform").validate({
               rules:{
                 zgroup:'required',
                 dfee:'required',
                 dtype:'required',
                 status:'required',
               }
            });
    </script>
    @endpush
@endsection
