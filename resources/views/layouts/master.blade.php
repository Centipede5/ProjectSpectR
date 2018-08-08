<!doctype html>
<html lang="en">
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