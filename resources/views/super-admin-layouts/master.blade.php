<!DOCTYPE html>
<html lang="en" >
<!-- begin:: Head -->
<head>
    <title>@yield('page-title')| {{ env('APP_NAME') }}</title>
    @include('super-admin-layouts.head')
    @yield('head')
</head>
<!-- end:: Head -->

<!-- begin:: Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Primary Wrapper -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    @include('super-admin-layouts.header')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    @include('super-admin-layouts.navigation')
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            @yield('main-content')
        </div>
    </div>
    @include('super-admin-layouts.footer')
</div>
<!-- end:: Primary Wrapper -->
@include('super-admin-layouts.quick-sidebar')

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
@include('super-admin-layouts.quick-sticky-nav-right')
@include('super-admin-layouts.footer-js')
</body>
<!-- end::Body -->
</html>