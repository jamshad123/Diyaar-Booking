<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    @include('admin.layout.header')
    @yield('style')
    @livewireStyles
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('admin.layout.sidebar')
            <div class="layout-page">
                @include('admin.layout.navbar')
                <div class="content-wrapper">
                    @yield('content')
                    @include('admin.layout.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        @component('components.DayCloseModal') @endcomponent
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
        @include('admin.layout.script')
        @yield('script')
        @livewireScripts
    </div>
</body>

</html>