@extends('admin.layout.main')
@section('title', 'View Member Details')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header">Edit Member</h5>
            <form class="card-body" id="member-form" action="{{ route('admin.members.update') }}" method="post"
                  enctype="multipart/form-data" autocomplete="off">
                @csrf
                <hr class="my-4 mx-n4"/>
                <input type="hidden" name="id" value="{{$admin->id}}">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="name" class="form-control" value="{{$admin->name}}"
                                   placeholder="Enter name"/>
                            <label for="name">Name<span class="text-danger">*</span></label>
                        </div>
                        @error('name')
                        <span id="name" class="error">{{ $message }}</span>
                        @enderror
                        <span id="name_error"></span>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="email" name="email" id="email" class="form-control" value="{{$admin->email}}"
                                   placeholder="Enter email"/>
                            <label for="email">Email<span class="text-danger">*</span></label>
                        </div>
                        @error('email')
                        <span id="email" class="error">{{ $message }}</span>
                        @enderror
                        <span id="email_error"></span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($role as $roles)
                                    <option
                                        value="{{$roles->name}}" {{$admin->get_roles()[0] == $roles->name ? 'selected' : ''}}>{{$roles->name}}</option>
                                @endforeach
                            </select>
                            <label for="status">Role<span class="text-danger">*</span></label>
                            @error('role')
                            <span id="role" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <span id="role_error"></span>
                    </div>
                    <div class="col-md-6 mb-3" >
                        <label for="Delivered">Is Ip Restriction<span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input name="ip_restriction" class="form-check-input ip_restriction" type="radio" value="0"
                                       id="no" @if($admin->ip_restriction == 0) checked @endif/>
                                <label class="form-check-label" for="no">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="ip_restriction" class="form-check-input ip_restriction" type="radio" value="1"
                                       id="yes" @if($admin->ip_restriction == 1) checked @endif/>
                                <label class="form-check-label" for="yes">Yes</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            @error('ip_restriction')
                            <div class="alert alert-danger error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    @php
                        $allow_ip = explode(',',$admin->allow_ip);
                        @endphp
                    <div class="col-md-6"  id="allow-ip-div" >
                        <div class="form-floating form-floating-outline">
                            <div class="select2-primary">
                                <label for="select2Primary">Select Allowed IPs</label>
                                <select id="select2Primary" name="allow_ip[]" class="select2 form-select" multiple>
                                    <option value="" disabled >Select IPs</option> <!-- Placeholder option -->
                                @foreach ($allottedIp as  $Ip)
                                        <option value="{{ $Ip->ip_address }}" {{ in_array($Ip->ip_address, $allow_ip) ? 'selected' : '' }}>
                                            {{ $Ip->ip_address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('allow_ip')
                            <span id="allow_ip" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <span id="allow_ip_error"></span>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script>
            let ip_restriction_val = "<?php echo $admin->ip_restriction?>";
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

            $(document).ready(function () {

                $("#member-form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true
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


            if(ip_restriction_val == 0){
                $('#allow-ip-div').css({
                    'display': 'none'
                });
            }


            $(".ip_restriction").on("change", function() {
                $("#delivery-fees-val").css({
                    'display': 'none'  });
                $('#allow-ip-div').html('');

                if (this.value == 1) {

                    $('#allow-ip-div').css({
                        'display': 'block'
                    });

                    $('#allow-ip-div').html(
                        `  <div class="form-floating form-floating-outline">
                            <div class="select2-primary">
                                <label for="select2Primary">Select Allowed IPs</label>
                                <select id="select2Primary" name="allow_ip[]" class="select2 form-select" multiple>
                                <option value="" disabled >Select IPs</option>
                                    @foreach ($allottedIp as  $Ip)
                            <option value="{{ $Ip->ip_address }}" {{ in_array($Ip->ip_address, $allow_ip) ? 'selected' : '' }}>
                                                                {{ $Ip->ip_address }}
                                            </option>
                    @endforeach
                                            </select>
                                        </div>
                    @error('allow_ip')
                        <span id="allow_ip" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <span id="allow_ip_error"></span>`
                    );

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
