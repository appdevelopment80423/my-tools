@extends('admin.layout.main')
@section('title', 'Update User')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4">
        <h5 class="card-header">Edit User</h5>
        <form class="card-body" id="user-form" action="{{ route('admin.users.update') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <hr class="my-4 mx-n4" />
            <div class="row g-4">
                <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="{{$user->name}}"/>
                    <label for="name">Name</label>

                </div>
                @error('name')
                    <span id="name_error" class="error">{{ $message }}</span>
                @enderror
                <span id="name_error"></span>
                </div>
                <div class="col-md-6">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" value="{{$user->email}}"/>
                        <label for="email">Email</label>
                    </div>
                </div>
                @error('email')
                    <span id="email_error" class="error">{{ $message }}</span>
                @enderror
                <span id="email_error"></span>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                    <input
                        type="text"
                        id="email_verified_at"
                        name="email_verified_at"
                        class="form-control dob-picker"
                        placeholder="YYYY-MM-DD" value="{{date('Y-m-d',strtotime($user->email_verified_at))}}" />
                    <label for="email_verified_at">Email verified at</label>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                        <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="multicol-password2" value="{{$user->password}}"/>
                        <label for="multicol-password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="multicol-password2"
                        ><i class="mdi mdi-eye-off-outline"></i
                    ></span>
                    </div>
                </div>
                @error('password')
                    <span id="password_error" class="error">{{ $message }}</span>
                @enderror
                <span id="password_error"></span>
                </div>
            </div>


          <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">Update</button>
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
          </div>
        </form>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function(){
        $("#user-form").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                password: {
                     required: true,
                }

            },
            messages: {
                    name: {
                        required: "Please enter name.",
                    },
                    email: {
                        required: "Please enter email.",
                    },
                    password: {
                        required: "Please enter password.",
                    }
            },
            errorPlacement: function (error, element) {
                error.insertAfter($("#"+element.attr("name")+"_error"));
            },
            submitHandler: function (form) {
                $(".proceed-btn").hide();
                return true;
            }
        });
    });
</script>
@endpush
@endsection
