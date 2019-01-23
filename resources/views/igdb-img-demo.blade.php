@extends('layouts.master')

@section('page-title')Page Title @endsection

@section('head')  @endsection

@section('main-content')
    <section>
        <div class="container">
            <div class="toolbar-custom">
                <a class="btn btn-default btn-icon m-r-10 float-left hidden-xs-down" href="#" data-toggle="tooltip" title="refresh" data-placement="bottom" role="button"><i class="fa fa-refresh"></i></a>
                <div class="dropdown float-left">
                    <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All Platform <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item active" href="#">All Platform</a>
                        <a class="dropdown-item" href="#">Playstation 4</a>
                        <a class="dropdown-item" href="#">Xbox One</a>
                        <a class="dropdown-item" href="#">Origin</a>
                        <a class="dropdown-item" href="#">Steam</a>
                    </div>
                </div>

                <div class="btn-group float-right m-l-5 hidden-xs-down" role="group">
                    <a class="btn btn-default btn-icon" href="#" role="button"><i class="fa fa-th-large"></i></a>
                    <a class="btn btn-default btn-icon" href="#" role="button"><i class="fa fa-bars"></i></a>
                </div>

                <div class="dropdown float-right">
                    <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Date Added <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item active" href="#">Date Added</a>
                        <a class="dropdown-item" href="#">Popular</a>
                        <a class="dropdown-item" href="#">Newest</a>
                        <a class="dropdown-item" href="#">Oldest</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="">
                    <div>
                        @php
                        $imgArray = [
                            'cover_small',
                            'screenshot_med',
                            'cover_big',
                            'logo_med',
                            'screenshot_big',
                            'screenshot_huge',
                            'thumb',
                            'micro',
                            '720p',
                            '1080p'
                        ]

                        @endphp
                        @foreach($imgArray as $name)
<p>{{$name}}</p>
                            <img src="https://images.igdb.com/igdb/image/upload/t_{{$name}}/rkldlhsginkkabox1hk6.jpg" alt="">
                         @endforeach
                    </div>
                </div>
            </div>
         </div>
    </section>
@endsection

@section('footer-js')  @endsection