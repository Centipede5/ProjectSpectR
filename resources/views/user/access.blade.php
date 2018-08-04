@extends('layouts.master')

@section('page-title')Blank Page @endsection

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
                <p>update-profile: @can('update-profile')YES</p>@endcan
                <p>comment-on-post: @can('comment-on-post')YES</p>@endcan
                <p>create-post: @can('create-post')YES</p>@endcan
                <p>publish-post: @can('publish-post')YES</p>@endcan
                <p>post-unlimited: @can('post-unlimited')YES</p>@endcan
                <p>site-moderator: @can('site-moderator')YES</p>@endcan
                <p>site-admin: @can('site-admin')YES</p>@endcan
                <p>god-mode: @can('god-mode')YES</p>@endcan
            </div>
        </div>
    </section>
    <!-- /main -->
    @endsection