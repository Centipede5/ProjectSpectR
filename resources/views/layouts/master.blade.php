<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <title>@yield('page-title')| {{ env('APP_NAME') }}</title>
    @include('layouts.head-std')

    @yield('head')

</head>
<body class="fixed-header">
@include('layouts.header')


<div class="main-container">
    @yield('main-content')
</div>

<div class="footer-container">
    @include('layouts.footer')
</div>

@include('layouts.footer-js')
@yield('footer-js')

</body>
</html>