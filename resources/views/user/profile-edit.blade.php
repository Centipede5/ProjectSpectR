@extends('layouts.master', ['profile_image' => $user->profile_image_small])

@section('page-title'){{ $user->display_name }} @endsection

@section('head')
    <link href="/plugins/cropper/cropper.css" rel="stylesheet">
    <style type="text/css">
        #cropperContainer{ width:180px; height:180px; position: relative; border:1px solid #ccc;}
    </style>
@endsection

@section('main-content')
    <!-- main -->
    <section class="hero hero-profile" style="background-image: url('{{ $user->background_image }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="hero-block">
                <h5>{{ $user->display_name }}</h5>
                @if(isset(Auth::user()->id) && Auth::user()->id == $user->id )
                    <a class="btn btn-primary btn-sm btn-shadow btn-rounded btn-icon btn-add" href="{{ route('edit_profile', ['id' => Auth::user()->id]) }}" data-toggle="tooltip" title="Add friend" role="button"><i class="fas fa-edit"></i> Save Profile</a>
                @else
                    <a class="btn btn-primary btn-sm btn-shadow btn-rounded btn-icon btn-add" href="#" data-toggle="tooltip" title="Add friend" role="button"><i class="fa fa-user-plus"></i></a>
                @endif
            </div>
        </div>
    </section>

    <section class="toolbar toolbar-profile" data-fixed="true">
        <div class="container">
            <div class="profile-avatar">
                <a href="{{ $user->profile_image_full }}" data-lightbox ><img id="avatar-image" name="avatar-image" src="{{ $user->profile_image_large }}" alt=""></a>
                <div class="sticky">
                    <a href="#"><img src="/img/user/avatar-sm.jpg" alt=""></a>
                    <div class="profile-info">
                        <h5>{{ $user->display_name }}</h5>
                        <span>&commat;{{ $user->display_name }}</span>
                    </div>
                </div>
            </div>
            <div class="dropdown float-right hidden-md-down">
                <a class="btn btn-secondary btn-icon btn-sm m-l-25 float-right" href="#" data-toggle="dropdown" role="button"><i class="fa fa-cog"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item active" href="#">Setting</a>
                    <a class="dropdown-item" href="#">Mail</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Block</a>
                </div>
            </div>
            <ul class="toolbar-nav hidden-md-down">
                <li class="active"><a href="#">Timeline</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Games (38)</a></li>
                <li><a href="#">Friends (628)</a></li>
                <li><a href="#">Images (23)</a></li>
                <li><a href="#">Videos</a></li>
                <li><a href="#">Groups</a></li>
                <li><a href="#">Forums</a></li>
            </ul>
        </div>
    </section>

    <section class="p-y-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 hidden-md-down">
                    <!-- widget about -->
                    <div class="widget widget-about">
                        @if(isset($user_info->bio))
                            <h5 class="widget-title">About</h5>
                            <p>{{ $user_info->bio }}</p>
                        @endif
                        <ul>
                            <li><i class="far fa-calendar-check"></i>Joined {{ $user->created_date }}</li>
                            @if(isset($user_info->social_meta->website))
                                <li><a href="{{ $user_info->social_meta->website }}" target="_blank"><i class="fas fa-link"></i>{{ $user_info->social_meta->website_display }}</a></li>
                            @endif
                            @if(isset($user_info->social_meta->youtube))
                                <li><a href="https://www.youtube.com/{{ $user_info->social_meta->youtube }}" class="youtube-link" target="_blank"><i class="fab fa-youtube"></i>/{{ $user_info->social_meta->youtube }}</a></li>
                            @endif
                            @if(isset($user_info->social_meta->twitter))
                                <li><a href="https://www.twitter.com/{{ $user_info->social_meta->twitter }}" class="twitter-link" target="_blank"><i class="fab fa-twitter"></i>&commat;{{ $user_info->social_meta->twitter }}</a></li>
                            @endif
                            @if(isset($user_info->social_meta->facebook))
                                <li><a href="https://www.facebook.com/{{ $user_info->social_meta->facebook }}" class="facebook-link" target="_blank"><i class="fab fa-facebook"></i>/{{ $user_info->social_meta->facebook }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- post -->
                    <div class="post post-card post-profile">
                        <div class="container">
                            <h1>Edit Profile</h1>
                            <hr>
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-3">
                                    <div id="cropperContainer"><img src="{{ $user->profile_image_large }}" style="width: 100%;" /></div>
                                </div>

                                <!-- Edit form column -->
                                <div class="col-md-9 personal-info">
                                    <h3>User info</h3>
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fas fa-user"></i>
                                            <input type="text" class="form-control form-control-secondary {{ $errors->has('display_name') ? ' has-error' : '' }}" placeholder="Username" id="display_name" name="display_name" value="{{$user->display_name}}" maxlength="20" autocomplete="off" required>
                                            @if ($errors->has('display_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('display_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group input-icon-left m-b-10 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" id="email" name="email" class="form-control form-control-secondary" placeholder="Email Address" value="{{ old('email') }}" maxlength="255" required>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="message">About</label>
                                            <textarea name="message" title="Bio" class="form-control" rows="4">@if(isset($user_info->bio)){{ $user_info->bio }} @endif</textarea>
                                        </div>

                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fas fa-user"></i>
                                            <input type="text" class="form-control form-control-secondary" placeholder="Website URL" id="user_info_website" name="user_info_website" value="@if(isset($user_info->social_meta->website)) {{$user_info->social_meta->website}} @endif" maxlength="50" autocomplete="off">
                                        </div>

                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fab fa-youtube"></i>
                                            <input type="text" class="form-control form-control-secondary" placeholder="YouTube Channel / URL" id="user_info_youtube" name="user_info_youtube" value="@if(isset($user_info->social_meta->youtube)) {{$user_info->social_meta->youtube}} @endif" maxlength="100" autocomplete="off">
                                        </div>

                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fab fa-twitter"></i>
                                            <input type="text" class="form-control form-control-secondary" placeholder="Twitter Name" id="user_info_twitter" name="user_info_twitter" value="@if(isset($user_info->social_meta->twitter)) {{$user_info->social_meta->twitter}} @endif" maxlength="50" autocomplete="off">
                                        </div>

                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fab fa-facebook"></i>
                                            <input type="text" class="form-control form-control-secondary" placeholder="Facebook URL" id="user_info_facebook" name="user_info_facebook" value="@if(isset($user_info->social_meta->facebook)) {{$user_info->social_meta->facebook}} @endif" maxlength="100" autocomplete="off">
                                        </div>

                                        <div class="divider"><span>Password Reset</span></div>
                                        <div class="form-group input-icon-left m-b-10 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <i class="fas fa-lock"></i>
                                            <input type="password" id="password" name="password" class="form-control form-control-secondary" placeholder="Password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group input-icon-left m-b-10">
                                            <i class="fas fa-unlock"></i>
                                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-secondary" placeholder="Repeat Password">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-8">
                                                <input class="btn btn-primary" value="Save Changes" type="button">
                                                <span></span>
                                                <input class="btn btn-default" value="Cancel" type="reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /main -->
@endsection

@section('footer-js')
    <script>
        (function($) {
            "use strict";
            // lightbox
            $('[data-lightbox]').lightbox({
                disqus: 'gameforestyakuzieu'
            });
        })(jQuery);
    </script>
    <script src="/plugins/cropper/cropper.js"></script>
    <script>
        var cropperContainerOptions = {
            uploadUrl:'/util/profileImageUpload',
            cropUrl:'/util/profileImageCrop',
            imgEyecandy:false,
            doubleZoomControls:false,
            rotateControls: false,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
            onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
            onImgDrag: function(){ console.log('onImgDrag') },
            onImgZoom: function(){ console.log('onImgZoom') },
            onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
            onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
            onReset:function(){ console.log('onReset') },
            onError:function(errormessage){ console.log('onError:'+errormessage) }
        };
        new Cropper('cropperContainer', cropperContainerOptions);
    </script>
@endsection
