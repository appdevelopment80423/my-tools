<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets/').'/'}}"
  data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>{{config('constants.APP_NAME')}}</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/refer-earn.png') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/materialdesignicons.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}"/>
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}"/>
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
    <style>
        form .error:not(li):not(input) {
            font-size: 100%;
        }
        .btn-primary {
            background-color: #2E4053;
            border-color: #2E4053;
        }

        .btn-check:focus + .btn-primary, .btn-primary:focus, .btn-primary.focus {
            background-color: #2E4053;
            border-color: #2E4053;
        }

        .btn-primary:hover {
            background-color: #2E4053 !important;
            border-color: #2E4053 !important;
        }
    </style>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <span class="app-brand-text demo text-heading fw-bold">{{config('constants.APP_NAME')}}</span>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">
                    <h4 class="mb-2 fw-semibold">Welcome to {{config('constants.APP_NAME')}}! 👋</h4>

                    @if (Session::has('error'))
                        <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif


                    @if($errors->any())
                        <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form method="POST" id="admin-login-form" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                placeholder="Enter your email"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                            <label for="email">Email</label>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                            </div>

                        <span id="email_error" class="mb-3"></span>
                        </div>
                            <div class="form-password-toggle mb-3">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" required autocomplete="current-password"/>
                                        <label for="password">Password</label>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember"> Remember Me </label>
                            </div>
                            {{--  <a href="{{ route('password.request') }}" class="float-end mb-1">
                              <span>Forgot Password?</span>
                            </a>  --}}
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Login -->
            <img
                alt="mask"
                src="{{asset('assets/img/illustrations/auth-basic-login-mask-light.png')}}"
                class="authentication-image d-none d-lg-block"
                data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                data-app-dark-img="illustrations/auth-basic-login-mask-light.png"/>
        </div>
    </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/libs/node-waves/node-waves.js')}}"></script>

<script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>

<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('assets/js/main.js')}}"></script>

<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>

<script>
    $(document).ready(function () {
        $.validator.addMethod("noSpace", function (value, element) {
            return /^\S+$/.test(value); // Ensure the value has no spaces
        }, "Email must not contain spaces.");

        $("#admin-login-form").validate({
            rules: {
                email: {
                    required: true,
                    noSpace: true, // Apply our custom rule to the email field
                    email: true
                },
                // Add other validation rules for other form fields if needed
            },
            messages: {
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address."
                },
                // Add custom error messages for other validation rules if needed
            },
            errorPlacement: function (error, element) {
                error.insertAfter($("#" + element.attr("name") + "_error"));
            },
            submitHandler: function (form) {
                return true;
            }
        });
    });
    $(document).ready(function() {
        $("#email").on("input", function () {
            $(this).val($(this).val().toLowerCase());
        });
    });
</script>
<!-- Page JS -->
<script src="{{asset('assets/js/pages-auth.js')}}"></script>

</body>
</html>
