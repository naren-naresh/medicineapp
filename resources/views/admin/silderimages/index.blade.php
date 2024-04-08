@extends('admin.layouts.master')
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row justify-content-between w-100 mt-2 mb-5">
        <div class="page-title col-6">
            <h5>Slider Image</h5>
        </div>
        <div aria-label="breadcrumb" class="col-6">
            <ol class="breadcrumb float-end">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class=" text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Slider Image</li>
            </ol>
        </div>
    </div>
    <div class="card w-100 mt-5">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">All Slider Images</h5>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn" data-bs-toggle="modal"
                    data-bs-target="#sliderImageModel">Add</a>
            </div>
        </div>
        <div class="card-body">
            <!-- Datatables -->
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Image</th>
                        <th>Heading</th>
                        <th>Content</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- model for edit products slider images --}}
    <div class="modal" tabindex="-1" id="sliderImageModel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid black !important">
                    <h5 class="modal-title" id="modelHeading">Add New Slider Image</h5>
                </div>
                <div class="modal-body px-5">
                    <form action="" id="sliderImageForm" name="sliderImageForm" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row mt-2">
                            <div class="form-group col-6 p-0">
                                <label for="image" class="mb-1">Slider Image</label>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="col-6  ps-3 mt-4">
                                <img src="{{ asset('assets/images/woocommerce-placeholder.webp')}}"class="mt-2 w-25 ms-5" id="sliderPreview">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="heading" class="mb-1 p-0">Heading</label>
                            <input type="text" class="form-control" name="heading" id="heading">
                        </div>
                        <div class="form-group row pt-1">
                            <label for="content" class="mb-1 p-0">Content</label>
                            <textarea name="content" id="content" cols="10" rows="5"></textarea>
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
     /*image preview*/
     $('#image').change(function() {
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#sliderPreview').attr('src', e.target.result);
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
            language: {
                lengthMenu: 'Show _MENU_ entries',
            },
            ajax: "{{ route('slider_image.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },{
                    data: 'image',
                    name: 'image',
                },{
                    data: 'heading',
                    name: 'heading',
                },{
                    data: 'content',
                    name: 'content',
                },{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        /* passing data to the store function in controller*/
        $('#sliderImageForm').submit(function(e) {
            e.preventDefault();
            $("#save").html('Sending..');
            let data = new FormData(this);
            $.ajax({
                data: data,
                url: "{{ route('slider_image.store') }}",
                contentType: false,
                processData: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#sliderImageForm').trigger("reset");
                    $('#sliderImageModel').modal('hide');
                    table.draw();
                    location.reload();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#save').html('Save Changes');
                }
            });
        });
         /* Edit slider image */
         $('body').on('click', '.editProduct', function() {
            var sliderImage_id = $(this).data('id');
            $.get("{{ route('slider_image.index') }}" + '/' + sliderImage_id + '/edit', function(data) {
                $('#id').val(data.id);
                $('#heading').val(data.heading);
                $('#content').val(data.content);
                $('#modelHeading').html("Edit slider image");
                $('#save').val("edit-image");
                $('#sliderImageModel').modal('show');
                console.log(data.image);
                if (data.image == '' || data.image == null) {
                        $('#sliderPreview').attr('src', 'assets/images/woocommerce-placeholder.webp');
                    }else{
                    $('#sliderPreview').attr('src', 'assets/images/sliderimages/' + data.image);
                    }
            })
        });
           /* Delete slider image */
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
                        var sliderImage_id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('slider_image.index') }}" + '/' + sliderImage_id,
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
                 $('#sliderImageModel').trigger('reset');
                 location.reload();
            });
            /* product form validation */
            $("#sliderImageForm").validate({
               rules:{
                 image:'required',
               }
            });
</script>
@endpush
