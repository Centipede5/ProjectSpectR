<!-- header -->
<header id="header">
<div class="container">
@if(env('APP_DEV_MODE'))
    @include('layouts.navigation')
@else
    @include('layouts.navigation-temp')
@endif
</div>
</header>
<!-- /header -->