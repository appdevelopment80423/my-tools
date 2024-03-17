@extends('admin.layout.main')
@section('title', 'Create Member')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header">Add Member</h5>
            <form class="card-body" id="member-form" action="{{ route('admin.members.store') }}" method="post"
                  enctype="multipart/form-data" autocomplete="off">
                @csrf
                <hr class="my-4 mx-n4"/>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name"/>
                            <label for="name">Name<span class="text-danger">*</span></label>
                        </div>
                        @error('name')
                        <span id="name" class="error">{{ $message }}</span>
                        @enderror
                        <span id="name_error"></span>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" />
                            <label for="email">Email<span class="text-danger">*</span></label>
                        </div>
                        @error('email')
                        <span id="email" class="error">{{ $message }}</span>
                        @enderror
                        <span id="email_error"></span>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="password"  passwordCheck="passwordCheck"  class="form-control" placeholder="Enter password" />
                            <label for="password">Password<span class="text-danger">*</span></label>
                        </div>
                        @error('password')
                        <span id="password" class="error">{{ $message }}</span>
                        @enderror
                        <span id="password_error"></span>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="confirm_password" class="form-control"
                                   placeholder="Enter confirm password" />
                            <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        </div>
                        @error('confirm_password')
                        <span id="confirm_password" class="error">{{ $message }}</span>
                        @enderror
                        <span id="confirm_password_error"></span>
                    </div>


                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($role as $roles)
                                    <option value="{{$roles->name}}">{{$roles->name}}</option>
                                @endforeach
                            </select>
                            <label for="Role">Role<span class="text-danger">*</span></label>
                            @error('role')
                            <span id="role" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <span id="role_error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="Ip Restriction">Ip Restriction<span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input name="ip_restriction" class="form-check-input ip_restriction" type="radio"
                                       value="0"
                                       id="no" checked=""/>
                                <label class="form-check-label" for="no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="ip_restriction" class="form-check-input ip_restriction" type="radio"
                                       value="1"
                                       id="yes"/>
                                <label class="form-check-label" for="yes">Yes</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            @error('ip_restriction')
                            <div class="alert alert-danger error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6" id="allow-ip-div" style="display: none">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">Save</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script>
            jQuery.validator.addMethod("passwordCheck",
                function(value, element, param) {
                    if (this.optional(element)) {
                        return true;
                    } else if (!/[A-Z]/.test(value)) {
                        return false;
                    } else if (!/[a-z]/.test(value)) {
                        return false;
                    } else if (!/[0-9]/.test(value)) {
                        return false;
                    } else if (!/[#?!@$%^&*-]/.test(value)){
                        return false;
                    }
                    return true;
                },
                "At least one lowercase character , upercase , number , symbol and minimum 8 characters");


            function getImgPreview(data_id, file) {
                //const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        // console.log(event.target.result);
                        $('#imgPreview' + data_id).attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            }

            $(function () {
                $("#member-form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 8,
                        },
                        confirm_password: {
                            required: true,
                            minlength: 8,
                            equalTo: '[name="password"]'
                        },
                        role: {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter name.",
                        },
                        email: {
                            required: "Please enter email.",
                            email: "Please enter valid email."
                        },
                        password: {
                            required: "Please enter password.",
                            minlength: "Please enter minimum length is 8."
                        },
                        confirm_password: {
                            required: "Please enter confirmation password.",
                            minlength: "Please enter minimum length is 8.",
                            equalTo: "Password and confirm password not same."
                        },
                        role: {
                            required: "Please select role.",
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter($("#" + element.attr("name") + "_error"));
                    },
                    submitHandler: function (form) {
                        $(".proceed-btn").hide();
                        return true;
                    }
                });

                // Email value access in lowercase
                $("#email").on("input", function () {
                    $(this).val($(this).val().toLowerCase());
                });
            });

            $(".ip_restriction").on("change", function () {
                $('#allow-ip-div').html('');

                if (this.value == 1) {

                    $('#allow-ip-div').css({
                        'display': 'block'
                    });

                    $('#allow-ip-div').html(`
                   <div class="form-floating form-floating-outline">
                            <div class="select2-primary">
                                <label for="select2Primary">Select Allowed IPs</label>
                                <select id="select2Primary" name="allow_ip[]" class="select2 form-select" multiple>
                                        <option value="" disabled >Select IPs</option> <!-- Placeholder option -->
                            @foreach ($allottedIp as  $Ip)
                                <option value="{{ $Ip->ip_address }}">{{ $Ip->ip_address }}</option>
                            @endforeach
                               </select>
                          </div>
                     </div>
                        <span id="allow_ip_error"></span>
`);

                } else {
                    $('#allow-ip-div').css({
                        'display': 'none'
                    });
                }
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection
