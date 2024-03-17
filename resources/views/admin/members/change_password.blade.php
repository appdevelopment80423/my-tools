@extends('admin.layout.main')
@section('title', 'Changes Password')
@section('content')
      <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Change Password -->
        <div class="card mb-4">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body">
                <form id="formChangePassword" method="POST" action="{{route('admin.new-password-store')}}" >
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6 form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                            <input
                                class="form-control"
                                type="password"
                                name="currentPassword"
                                id="currentPassword"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <label for="currentPassword">Current Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer"
                            ><i class="mdi mdi-eye-off-outline"></i
                            ></span>
                        </div>
                        @error('currentPassword')
                            <span id="currentPassword" class="error">{{ $message }}</span>
                        @enderror
                        <span id="currentPassword_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-4 col-md-6 form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                            <input
                                class="form-control"
                                type="password"
                                id="newPassword"
                                name="newPassword"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <label for="newPassword">New Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer"
                            ><i class="mdi mdi-eye-off-outline"></i
                            ></span>
                        </div>
                        @error('newPassword')
                            <span id="newPassword" class="error">{{ $message }}</span>
                        @enderror
                        <span id="newPassword_error"></span>
                    </div>
                    <div class="mb-4 col-md-6 form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                            <input
                                class="form-control"
                                type="password"
                                name="confirmPassword"
                                id="confirmPassword"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <label for="confirmPassword">Confirm New Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer"
                            ><i class="mdi mdi-eye-off-outline"></i
                            ></span>
                        </div>
                        @error('confirmPassword')
                            <span id="confirmPassword" class="error">{{ $message }}</span>
                        @enderror
                        <span id="confirmPassword_error"></span>
                    </div>
                </div>
                <h6 class="text-body">Password Requirements:</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                    <li class="mb-1">At least one lowercase character</li>
                    <li>At least one number, symbol, or whitespace character</li>
                </ul>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                </div>
                </form>
            </div>
        </div>
        <!--/ Change Password -->
    </div>


    @push('script')
        <script>
            $(document).ready(function(){

                $("#formChangePassword").validate({
                    rules: {
                        currentPassword: {
                            required: true,
                        },
                        newPassword: {
                            required: true,
                            minlength: 8,
                        },
                        confirmPassword: {
                            required: true,
                            minlength: 8,
                            equalTo: '[name="newPassword"]'
                        }
                    },
                    messages: {
                        currentPassword: {
                            required: "Please enter current password.",
                        },
                        newPassword: {
                            required: "Please enter password.",
                            minlength: "Please enter minimum length is 8."
                        },
                        confirmPassword: {
                            required: "Please enter confirmation password.",
                            minlength: "Please enter minimum length is 8.",
                            equalTo: "Password and confirm password not same."
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
