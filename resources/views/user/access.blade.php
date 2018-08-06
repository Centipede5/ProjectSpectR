@extends('layouts.master')

@section('page-title')Access Levels @endsection

@section('main-content')
<!-- main -->
    <section class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Blank Page</li>
            </ol>
        </div>
    </section>

    <section>
        <div class="container blank">
            <div>
                <p>update-profile: @can('update-profile')YES @else NO</p>@endcan
                <p>comment-on-post: @can('comment-on-post')YES @else NO</p>@endcan
                <p>create-post: @can('create-post')YES @else NO</p>@endcan
                <p>publish-post: @can('publish-post')YES @else NO</p>@endcan
                <p>post-unlimited: @can('post-unlimited')YES @else NO</p>@endcan
                <p>site-moderator: @can('site-moderator')YES @else NO</p>@endcan
                <p>site-admin: @can('site-admin')YES @else NO</p>@endcan
                <p>god-mode: @can('god-mode')YES @else NO</p>@endcan
            </div>
            <div>
                GUEST:
                @guest
                    TRUE
                @endguest
            </div>
            <div>
                AUTH:
                @auth
                    TRUE
                @endauth
            </div>
            <div>AUTH CHECK:
                @if(Auth::check())
                    TRUE
                @else
                    FALSE
                @endif
            </div>
        </div>

    </section>
    <!-- /main -->
    @endsection