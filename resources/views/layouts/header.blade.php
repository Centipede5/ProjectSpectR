<header id="header">
<div class="container">
@if(env('APP_DEV_MODE'))
    @include('layouts.navigation-dev')
@else
    @include('layouts.navigation')
@endif
</div>
</header>