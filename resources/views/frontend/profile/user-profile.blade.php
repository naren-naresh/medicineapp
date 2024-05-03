@extends('frontend.layouts.master')
@section('frontend-content')
    @pushOnce('frontend-styles')
        <link rel="stylesheet" href="{{ asset('assets/css/frontend/user_profile.css') }}">
    @endPushOnce
    <section class="user-profile-section  py-5">
        <div class="container">
            <div class="row profile-content">
                <div class="col-3 pe-5">
                    <div class="row mb-4 user-name-block align-items-center">
                        <div class="col-3 user-icon"> <img
                                src="{{ asset('assets/images/user/' . auth()->id() . '/' . Auth::user()->image . '') }}"
                                class="w-100"></div>
                        <div class="col ps-4">
                            <div class="row">
                                <span>Hello</span>
                                <h5>{{ Auth::user()->name }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row menu-options">
                        <a href="{{ route('useProfile.index') }}">
                            <div class="option active"><i class="fa fa-user"></i>&nbsp; Personal Information</div>
                        </a>
                        <a href="{{ route('address.index') }}">
                            <div class="option"><i class="fa fa-map-location"></i>&nbsp; Manage Addresses</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-heart"></i> &nbsp;My Wishlist</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-cart-shopping"></i> &nbsp;My Orders</div>
                        </a>
                        <a href="#">
                            <div class="option"><i class="fa fa-keyboard"></i> &nbsp;Change Password</div>
                        </a>
                        <a href="{{ route('logout') }}">
                            <div class="option"><i class="fa fa-sign-out"></i> &nbsp;Logout</div>
                        </a>
                    </div>
                </div>
                <div class="col-9 user-profile-information py-5">
                    <div class="row justify-content-between">
                        <div class="col-3">
                            <h4 class="pb-2">Profile</h4>
                        </div>
                        <div class="col-3 text-end" id="action-row">
                            <a href="#" id="edit"><i class="fa fa-edit"></i>&nbsp;Edit </a> &nbsp; | &nbsp;
                            <a href="#" id="delete"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                        </div>
                    </div>
                    @foreach ($userInformation as $info)
                        <form action="{{ route('useProfile.update') }}" method="post" name="userForm" id="userForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row pt-3">
                                <div class="col-6 form-group">
                                    <label for="name" class="pb-2 required">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $info->name }}">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="email" class="required pb-2">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $info->email }}">
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-6 form-group">
                                    <label for="contact" class="required pb-2">Contact</label>
                                    <input type="text" name="contact" id="contact" class="form-control" maxlength="6"
                                        onkeyup="process(this)" value="{{ $info->contact }}">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="gender" class="required pb-2">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" disabled>---select you gender---</option>
                                        <option value="{{ App\Enums\Gender::Male }}"
                                            @if (App\Enums\Gender::Male === $info->gender) selected @endif>{{ App\Enums\Gender::Male }}
                                        </option>
                                        <option value="{{ App\Enums\Gender::Female }}"
                                            @if (App\Enums\Gender::Female === $info->gender) selected @endif>
                                            {{ App\Enums\Gender::Female }}</option>
                                        <option value="{{ App\Enums\Gender::Other }}"
                                            @if (App\Enums\Gender::Other === $info->gender) selected @endif>
                                            {{ App\Enums\Gender::Other }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row  pt-3">
                                <label class="required pb-2 ">Image</label>
                                <input type="file" name="image" id="image" class="d-none" accept="image/*">
                                <label for="image" class="picture d-flex justify-content-center align-items-center ms-3">
                                    <i class="fa fa-plus-circle position-absolute" id="imgIcon"
                                        style="font-size: 1.5rem"></i>
                                    <img src="{{ asset('assets/images/user/' . $info->id . '/' . $info->image . '') }}"
                                        name='demo' id="demo" class="w-100"></label>
                            </div>
                            <div class="row form-group pt-5 ms-1 d-none" id="btn-row">
                                <button type="submit" class="col-1 py-1" id="edit-btn">Update</button>
                                <button type="button" class="col-1 py-1 ms-2" id="cancel-btn">Cancel</button>
                            </div>
                        </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!-- modal for sign in -->
    <div class="modal" tabindex="-1" id="accountDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" aria-label="Close"
                    style="position: absolute; top: 10px; right: 10px; z-index: 999;" data-bs-dismiss="modal"></button>
                <div class="modal-body p-5">
                    <div class="modal-heading text-center pb-3">
                        <h5 class="modal-title" id="modelHeading">Conformation</h5>
                    </div>
                    <form action="" id="accountDeleteForm" name="accountDeleteForm" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-8 pe-0">
                                <input type="email" class="form-control mt-2 py-3" name="email" id="email"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-4 ps-0">
                                <button type="button" class="send-btn form-control mt-2 py-3">Send Code</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @pushOnce('frontend-scripts')
        <script>
            $(document).ready(function() {
                $('input, .picture , select').addClass('read-only');
                $("input, select").prop("readonly", true);
            });
            $('#edit').click(function() {
                $('#name,#contact,#image, .picture , select').removeClass('read-only');
                $("input , select").prop("readonly", false);
                $(this).parent().addClass('d-none');
                $('#btn-row').removeClass('d-none');
            });
            $('#cancel-btn').click(function() {
                $('input, .picture , select').addClass('read-only');
                $("input, select").prop("readonly", true);
                $('#action-row').removeClass('d-none');
                $('#btn-row').addClass('d-none');
            });
            $('#delete').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#accountDeleteModal').modal('show');
                        $('#accountDeleteModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                });
            });
            /*image preview*/
            $('#image').change(function() {
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#demo').attr('src', e.target.result);
                    $('#imgIcon').remove();
                }

                reader.readAsDataURL(this.files[0]);

            });
        </script>
    @endPushOnce
@endsection
