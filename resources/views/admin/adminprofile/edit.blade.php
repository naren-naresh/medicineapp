@extends('admin.layouts.master')
@section('content')
    <div class="card w-75 mt-5" style="background-color: #d2d9ea;">
        <div class="card-header">Profile Information</div>
        <div class="card-body">
            <form action="{{ route('profile.update', $user->id) }}" method="post" name="profileform" id="profileform"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row px-5 justify-content-center">
                    <div class="row mb-2">
                        <label for="name" class="p-0 mb-1">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}"
                            class="form-control">
                        <label for="email" class="p-0 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}"
                            class="form-control">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <label for="contact" class="p-0 mb-1">Contact</label>
                        <input type="text" id="contact" name="contact" value="{{ $user->contact }}"
                            class="form-control">
                        <label for="gender" class="p-0 mb-1">Gender</label>
                        <div class="gender">
                            <input type="radio" name="gender" id="male" value="Male"
                                {{ $user->gender == 'Male' ? 'checked' : '' }}>
                            <label for="male" class="me-2">Male</label>
                            <input type="radio" name="gender" id="female"
                                value="Female"{{ $user->gender == 'Female' ? 'checked' : '' }}>
                            <label for="female" class="me-2">Female</label>
                            <input type="radio" name="gender" id="others"
                                value="Others"{{ $user->gender == 'Others' ? 'checked' : '' }}>
                            <label for="others" class="me-2">Others</label>
                            <label for="gender" id="gender-error" class="error"></label>
                        </div>
                        <div class="mb-3 row">
                            <label for="image" class="p-0 mb-1">Image</label>
                            <div class="col-6">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="img col-2"><img src="/assets/images/{{ $user->image }}" alt="profile image"
                                    class="w-50" id="preview"></div>
                        </div>

                        <div class="button">
                            <a href="{{ route('profile') }}" class="btn btn-primary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-5">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- validation and image preview scripts --}}
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#profileform').validate({
                    rules: {
                        name: 'required',
                        email: 'required',
                        gender: 'required',
                        contact: 'required',
                    }
                });
            });
            $('#image').on('change', function() {
                if (this.files && this.files[0]) {
                    const selectedFile = this.files[0];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(selectedFile);
                }
            });
        </script>
    @endpush
@endsection
