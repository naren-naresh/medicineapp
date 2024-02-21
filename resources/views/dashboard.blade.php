@extends('admin.layouts.master')
@section('content')
<div class="container d-flex justify-content-center align-items-center mh-100 mt-5">
    <h2>Page Content</h2>
</div>
 {{-- model for change password --}}
 <div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Updation</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('passwordupdate') }}" class=" d-flex justify-content-center" id="pform"
                    name="pform" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row w-75">
                        <div class="row">
                            <label for="oldpassword" class="p-0 mb-1">Old Password</label>
                            <div class="input-group p-0">
                                <input type="password" name="oldpassword" id="oldpassword"
                                    placeholder="Enter your old password" class=" form-control oldpassword">
                                <span class="input-group-text bg-transparent"><i
                                        class="fa fa-eye cicon"></i></span>
                            </div>
                            <label for="oldpassword" class="error" id="oldpassword-error"></label>
                            <label for="oldpassword" class="Error text-danger" id="oldpassword-error"></label>
                            @if (Session::has('error'))
                                <span class="text-danger" role="alert">
                                    {{ Session::get('error') }}
                                </span>
                            @endif
                            @if (!empty(Session::get('error')))
                                <script>
                                    $(function() {
                                        $('#myModal').modal('show');
                                    });
                                </script>
                            @endif
                            <label for="newpassword" class="p-0 mt-2 mb-1">New Password</label>
                            <div class="input-group p-0">
                                <input type="password" id="newpassword" name="newpassword"
                                    placeholder="Enter your new password" class="newpassword form-control">
                                <span class="input-group-text bg-transparent"><i
                                        class="fa fa-eye icon"></i></span>
                            </div>
                            <label for="newpassword" class="error" id="newpassword-error"></label>
                            <label for="cpassword" class="p-0 mt-2 mb-1">Confirm Password</label>

                            <input type="password" id="cpassword" name="cpassword"
                                placeholder="Cofirm your password" class="cpassword form-control">

                        </div>
                        <div class="button mt-4">
                            <button type="button" class="btn btn-secondary me-3"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" name="submit" id="submit"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // password hide and show eye toggle
    $('.icon').mousedown(function() {
        $('.newpassword').attr('type', 'text');
    });

    $('.icon').on('mouseup mouseleave', function() {
        $('.newpassword').attr('type', 'password');
    });
    $('.cicon').mousedown(function() {
        $('.oldpassword').attr('type', 'text');
    });

    $('.cicon').on('mouseup mouseleave', function() {
        $('.oldpassword').attr('type', 'password');
    });
    // client side validation
    $("#pform").validate({
        rules: {
            oldpassword: {
                required: true,
                minlength: 6,
                maxlength: 15,
            },
            newpassword: {
                required: true,
                minlength: 6,
                maxlength: 15,
            },
            cpassword: {
                required: true,
                minlength: 6,
                maxlength: 15,
                equalTo: '#newpassword',
            },

        },
    });
    // ajax call for password updation
    $(document).ready(function() {
        $('#submit').click(function(e) {
            e.preventDefault();
            let formdata = $('#pform').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('passwordupdate') }}',
                data: formdata,
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        $("#myModal").find(".modal-body").find(".Error").html(response
                            .message);
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
