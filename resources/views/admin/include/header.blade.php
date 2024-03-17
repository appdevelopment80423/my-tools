<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('constants.APP_NAME') }} Admin - @yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/refer-earn.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}" />

    <!-- Vendors CSS -->
    @stack('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-profile.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />


    <!-- Page CSS -->
    @stack('page-css')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <style>

        .container-p-y:not([class^="pb-"]):not([class*=" pb-"]) {
            min-width: 100%;
        }
        .layout-navbar.navbar-detached.container-xxl {
            max-width: calc(1440px - calc(1.5rem * -24));
        }
        .bg-menu-theme .menu-item.active > .menu-link:not(.menu-toggle) {
            background-color: #2E4053 !important;
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
        .page-item.active .page-link, .page-item.active .page-link:hover, .page-item.active .page-link:focus, .pagination li.active > a:not(.page-link), .pagination li.active > a:not(.page-link):hover, .pagination li.active > a:not(.page-link):focus {
            border-color: #2E4053!important;
            background-color: #2E4053!important;
        }
        .dropdown-item:not(.disabled).active, .dropdown-item:not(.disabled):active {
            background-color: rgba(102, 108, 255, 0.1);
            color: #2E4053 !important;
        }
        .bg-label-primary {
            color: #2E4053 !important;
        }
        .form-floating-outline .form-control:focus, .form-floating-outline .form-select:focus {
            border-color: #2E4053;
        }
        .form-floating > .form-control:focus ~ label, .form-floating > .form-control:focus:not(:placeholder-shown) ~ label, .form-floating > .form-select:focus ~ label, .form-floating > .form-select:focus:not(:placeholder-shown) ~ label {
            color: #2E4053;
        }
        .nav-pills .nav-link.active, .nav-pills .nav-link.active:hover, .nav-pills .nav-link.active:focus {
            background-color: #2E4053;
        }
        .table > thead {
            background-color: #f7f7f9;
        }
        .table-responsive {
            padding-bottom: 80px;
        }
        .sortable {
            cursor: pointer;
            position: relative;
        }

        .sortable .sort-indicator {
            display: inline-block;
            margin-left: 5px;
            vertical-align: middle;
            position: relative;
        }

        .sortable.asc .sort-indicator::before {
            content: "";
            display: inline-block;
            border-style: solid;
            border-width: 0.3em 0.3em 0 0;
            border-color: #565869;
            transform: rotate(-45deg);
            margin-right: 0.25em;
            width: 0.8em;
            height: 0.8em;
        }

        .sortable.desc .sort-indicator::before {
            content: "";
            display: inline-block;
            border-style: solid;
            border-width: 0 0.3em 0.3em 0;
            border-color: #565869;
            transform: rotate(45deg);
            margin-right: 0.25em;
            width: 0.8em;
            height: 0.8em;
        }

        form .error:not(li):not(input) {
            font-size: 100%;
        }
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
        }

        .loader {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 6px solid #2E4053;
            border-top-color: transparent;
            animation: spin 1.5s infinite linear;
        }
        .user-card-head{
            color: #2E4053;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
