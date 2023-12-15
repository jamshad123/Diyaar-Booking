<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css?v=1') }}" />
<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css?v=1') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css?v=1') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css?v=1') }}" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css?v=1') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/style.css?v=2') }}" />
<!-- Page CSS -->
<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>
@yield('vendor-style')
<style media="screen">
    .select2-dropdown {
        z-index: 3051 !important;
    }

    .pointer_class {
        cursor: pointer;
    }

    .number {
        text-align: right;
    }
    body{
        zoom: 98%;
    }
</style>