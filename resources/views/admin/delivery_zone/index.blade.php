@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-3">
        <div class="page-title col-6">
            <h5>Delivery Zones</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Delivery Zones</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-2 mb-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Delivery Zone</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal" data-bs-target="#dzModal">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Zone Group</th>
                        <th>Postal Code</th>
                        <th>Status</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- model for edit products category --}}
    <div class="modal" tabindex="-1" id="dzModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Delivery Zone</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="dzform" name="dzform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="zonegroup" class="mb-1">Zone Groups</label>
                            <select class="form-control" name="zonegroup" id="zonegroup">
                                <option value="option_select" disabled selected>Select Zone</option>
                                @foreach ($zone_groups as $zone)
                                <option value="{{ $zone->id }}">
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pcode" class="mb-1">Postal Code</label>
                            <input type="text" class="form-control" name="pcode" id="pcode">
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
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                language: {
                lengthMenu: 'Show _MENU_ entries',
                },
                ajax: "{{ route('delivery_zone.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'zone_group_id',
                        name: 'zone_group_id',
                    },
                    {
                        data: 'postal_code',
                        name: 'postal_code',
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
                $.get("{{ route('delivery_zone.index') }}" + '/' + id + '/edit', function(data) {
                    $('#id').val(data.id);
                    $('#modelHeading').html("Edit Delivery Zone");
                    $('#save').val("edit-user");
                    $('#dzModal').modal('show');
                    $('#pcode').val(data.postal_code);
                    $('#zonegroup').val(data.zone_group_id);
                    $('#zonegroup option[value=' + id + ']').hide();
                    $('.status').each(function() {
                        if ($(this).val() == data.status) {
                            $(this).prop("checked", true);
                        }
                    });
                })
            });
            /* ajax call store fuction in controller*/
            $('#dzform').submit(function(e) {
                e.preventDefault();
                $("#save").html('Sending..');
                let data = new FormData(this);
                $.ajax({
                    data: data,
                    url: "{{ route('delivery_zone.index') }}",
                    contentType: false,
                    processData: false,
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#dzform').trigger("reset");
                        $('#dzModal').modal('hide');
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
                            url: "{{ route('category.index') }}" + '/' + id,
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
                 $('#dzform').trigger('reset');
                 location.reload();
            });
            $("#dzform").validate({
               rules:{
                 zonegroup:'required',
                 pcode:'required',
                 status:'required',
               }
            });
        </script>
    @endpush
@endsection
