@extends('layouts.master')

@section('page-title'){{ $user->display_name }} @endsection


@section('main-content')
  <!-- main -->
  <section class="hero hero-profile" style="background-image: url('https://s3.us-east-2.amazonaws.com/projectspectr/img/user/{{ $user->id }}_profile_backgroud.png');">
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
        <a href="https://s3.us-east-2.amazonaws.com/projectspectr/img/user/{{ $user->id }}_{{ $user->display_name }}_profile_full.jpg" data-lightbox ><img src="https://s3.us-east-2.amazonaws.com/projectspectr/img/user/{{ $user->id }}_profile_200x200.png" alt=""></a>
        <div class="sticky">
          <a href="#"><img src="/img/user/avatar-sm.jpg" alt=""></a>
          <div class="profile-info">
            <h5>{{ $user->display_name }}</h5>
            <span>{{ $user->display_name }}</span>
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

          <!-- widget friends -->
          <div class="widget widget-friends">
            <h5 class="widget-title">Friends <span>(628)</span></h5>
            <ul>
              <li><a href="#" data-toggle="tooltip" title="Elizabeth"><img src="/img/widget/widget-user-1.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Clark"><img src="/img/widget/widget-user-2.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Trevor"><img src="/img/widget/widget-user-3.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Franklin"><img src="/img/widget/widget-user-4.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="John"><img src="/img/widget/widget-user-5.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Bruce"><img src="/img/widget/widget-user-6.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Sherlock"><img src="/img/widget/widget-user-7.jpg" alt=""></a></li>
              <li><a href="#" data-toggle="tooltip" title="Clara"><img src="/img/widget/widget-user-8.jpg" alt=""></a></li>
            </ul>
          </div>

          <!-- Widget Forums -->
          <div class="widget widget-forums">
            <h5 class="widget-title">Recent Forums</h5>
            <ul>
              <li>
                <div class="forum-icon">
                  <i class="fa fa-comment-o"></i>
                </div>
                <div class="forum-title">
                  <h5><a href="forum-post.html">What is your favorite game?</a></h5>
                  <span>5 weeks ago</span>
                </div>
              </li>
              <li>
                <div class="forum-icon">
                  <i class="fa fa-comment-o"></i>
                </div>
                <div class="forum-title">
                  <h5><a href="forum-post.html">Battlefield 1 multiplayer</a></h5>
                  <span>1 month ago</span>
                </div>
              </li>
              <li>
                <div class="forum-icon">
                  <i class="fa fa-bug"></i>
                </div>
                <div class="forum-title">
                  <h5><a href="forum-post.html">Uncharted 4 Bug Reports</a></h5>
                  <span>July 20, 2017</span>
                </div>
              </li>
              <li>
                <div class="forum-icon">
                  <i class="fa fa-envelope-open-o"></i>
                </div>
                <div class="forum-title">
                  <h5><a href="forum-post.html">Days Gone is a promising game</a></h5>
                  <span>July 10, 2017</span>
                </div>
              </li>
              <li>
                <div class="forum-icon">
                  <i class="fa fa-comment-o"></i>
                </div>
                <div class="forum-title">
                  <h5><a href="forum-post.html">Q: Black Friday Playstation Sale</a></h5>
                  <span>July 09, 2017</span>
                </div>
              </li>
            </ul>
          </div>

          <!-- Widget Images -->
          <div class="widget widget-images">
            <h5 class="widget-title">Images</h5>
            <ul>
              <li><a href="#"><img src="/img/widget/widget-images-1.jpg" alt=""></a></li>
              <li><a href="#"><img src="/img/widget/widget-images-2.jpg" alt=""></a></li>
              <li><a href="#"><img src="/img/widget/widget-images-3.jpg" alt=""></a></li>
              <li><a href="#"><img src="/img/widget/widget-images-4.jpg" alt=""></a></li>
              <li><a href="#"><img src="/img/widget/widget-images-5.jpg" alt=""></a></li>
              <li><a href="#"><img src="/img/widget/widget-images-6.jpg" alt=""></a></li>
            </ul>
            <a class="" href="#" role="button"></a>
          </div>
        </div>

        <div class="col-lg-9">
          <!-- post -->
          <div class="post post-card post-profile">
            <div class="post-header">
              <div>
                <a href="profile.html">
                  <img src="/img/user/avatar-sm.jpg" alt="">
                </a>
              </div>
              <div>
                <h2 class="post-title">
                  <a href="profile.html">Nathan Drake</a>
                </h2>
                <div class="post-meta">
                  <span><i class="fa fa-clock-o"></i> June 16, 2017</span>
                  <span><a href="#"><i class="fa fa-comment-o"></i> 98 comments</a></span>
                  <span><a href="#"><i class="fa fa-heart-o"></i> 523 likes</a></span>
                </div>
                <div class="dropdown float-right">
                  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Moderate</a>
                    <a class="dropdown-item" href="#">Embed</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Mark as spam</a>
                  </div>
                </div>
              </div>
            </div>
            <p>Injustice 2 is getting a brand new character, and EA reveal the games that they’ll be talking about in their E3 Press Conference! Power up and build the ultimate version of your favorite DC legends in Injustice 2.</p>
            <div class="post-thumbnail">
              <img src="/img/profile/profile-1.jpg" alt="">
            </div>
            <div class="post-footer">
              <a href="#"><i class="fa fa-reply"></i> 34 shares</a>
              <a href="#"><i class="fa fa-comment-o"></i> 98 comments</a>
              <a href="#"><i class="fa fa-heart-o"></i> 523 likes</a>
            </div>
          </div>

          <!-- post -->
          <div class="post post-card post-profile">
            <div class="post-header">
              <div>
                <a href="profile.html">
                  <img src="/img/user/user-2.jpg" alt="">
                </a>
              </div>
              <div>
                <h2 class="post-title">
                  <a href="profile.html">Elizabeth</a>
                  <a href="profile.html">Nathan Drake</a>
                </h2>
                <div class="post-meta">
                  <span><i class="fa fa-clock-o"></i> June 13, 2017</span>
                  <span><a href="#"><i class="fa fa-comment-o"></i> 12 comments</a></span>
                  <span><a href="#"><i class="fa fa-heart-o"></i> 3 likes</a></span>
                </div>
                <div class="dropdown float-right">
                  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Moderate</a>
                    <a class="dropdown-item" href="#">Embed</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Mark as spam</a>
                  </div>
                </div>
              </div>
            </div>
            <p>Ubisoft showed off more of Far Cry 5 at its E3 2017 press conference. The video opened in a church in which armed citizens raised their guns as they sang Amazing Grace. Dan Hay, executive producer for Far Cry 5, then appeared on the stage
              to talk about Hope County.</p>
            <div class="post-thumbnail">
              <div class="video-play" data-src="https://www.youtube.com/embed/Kdaoe4hbMso?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
                <div class="embed-responsive embed-responsive-16by9">
                  <img class="embed-responsive-item" src="https://img.youtube.com/vi/kUKrStkG-hE/maxresdefault.jpg">
                  <div class="video-play-icon">
                    <i class="fa fa-play"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="post-footer">
              <a href="#"><i class="fa fa-reply"></i> 3 shares</a>
              <a href="#"><i class="fa fa-comment-o"></i> 12 comments</a>
              <a href="#"><i class="fa fa-heart-o"></i> 3 likes</a>
            </div>
          </div>

          <!-- post -->
          <div class="post post-card post-profile">
            <div class="post-header">
              <div>
                <a href="profile.html">
                  <img src="/img/user/avatar-sm.jpg" alt="">
                </a>
              </div>
              <div>
                <h2 class="post-title">
                  <a href="profile.html">Nathan Drake</a>
                </h2>
                <div class="post-meta">
                  <span><i class="fa fa-clock-o"></i> June 10, 2017</span>
                  <span><a href="#"><i class="fa fa-comment-o"></i> 7 comments</a></span>
                  <span><a href="#"><i class="fa fa-heart-o"></i> 18 likes</a></span>
                </div>
                <div class="dropdown float-right">
                  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Moderate</a>
                    <a class="dropdown-item" href="#">Embed</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Mark as spam</a>
                  </div>
                </div>
              </div>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at faucibus erat. In hac habitasse platea dictumst. Proin faucibus, massa sed condimentum sodales.</p>
            <div class="post-thumbnail">
              <iframe width="100%" height="200" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/312296129&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true"></iframe>
            </div>
            <div class="post-footer">
              <a href="#"><i class="fa fa-reply"></i> 3 shares</a>
              <a href="#"><i class="fa fa-comment-o"></i> 7 comments</a>
              <a href="#"><i class="fa fa-heart-o"></i> 18 likes</a>
            </div>
          </div>

          <!-- post -->
          <div class="post post-card post-profile">
            <div class="post-header">
              <div>
                <a href="profile.html">
                  <img src="/img/user/avatar-sm.jpg" alt="">
                </a>
              </div>
              <div>
                <h2 class="post-title">
                  <a href="profile.html">Nathan Drake</a>
                </h2>
                <div class="post-meta">
                  <span><i class="fa fa-clock-o"></i> June 10, 2017</span>
                  <span><a href="#"><i class="fa fa-comment-o"></i> 21 comments</a></span>
                  <span><a href="#"><i class="fa fa-heart-o"></i> 312 likes</a></span>
                </div>
                <div class="dropdown float-right">
                  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Moderate</a>
                    <a class="dropdown-item" href="#">Embed</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Mark as spam</a>
                  </div>
                </div>
              </div>
            </div>
            <p>The Witcher 3: Wild Hunt is a story-driven, next-generation open world role-playing game, set in a visually stunning fantasy universe, full of meaningful choices and impactful consequences.</p>
            <div class="post-thumbnail">
              <img src="/img/profile/profile-2.jpg" alt="">
            </div>
            <div class="post-footer">
              <a href="#"><i class="fa fa-reply"></i> 27 shares</a>
              <a href="#"><i class="fa fa-comment-o"></i> 21 comments</a>
              <a href="#"><i class="fa fa-heart-o"></i> 312 likes</a>
            </div>
          </div>

          <!-- post -->
          <div class="post post-card post-profile">
            <div class="post-header">
              <div>
                <a href="profile.html">
                  <img src="/img/user/avatar-sm.jpg" alt="">
                </a>
              </div>
              <div>
                <h2 class="post-title">
                  <a href="profile.html">Nathan Drake</a>
                </h2>
                <div class="post-meta">
                  <span><i class="fa fa-clock-o"></i> June 09, 2017</span>
                  <span><a href="#"><i class="fa fa-comment-o"></i> 5 comments</a></span>
                  <span><a href="#"><i class="fa fa-heart-o"></i> 6 likes</a></span>
                </div>
                <div class="dropdown float-right">
                  <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Moderate</a>
                    <a class="dropdown-item" href="#">Embed</a>
                    <a class="dropdown-item" href="#">Report</a>
                    <a class="dropdown-item" href="#">Mark as spam</a>
                  </div>
                </div>
              </div>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at faucibus erat.</p>
            <div class="post-thumbnail">
              <img src="https://maps.googleapis.com/maps/api/staticmap?size=640x150&zoom=13&scale=2&maptype=roadmap&markers=size:mid%7Ccolor:red%7CSan+Francisco,CA&key=AIzaSyCFHwOU3OoTBLDkppUsfRJLWYYq8kdCm28">
            </div>
            <div class="post-footer">
              <a href="#"><i class="fa fa-reply"></i> 3 shares</a>
              <a href="#"><i class="fa fa-comment-o"></i> 3 comments</a>
              <a href="#"><i class="fa fa-heart-o"></i> 6 likes</a>
            </div>
          </div>

          <div class="text-center"><a href="games.html" class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg m-b-20">Show More</a></div>
        </div>
      </div>
    </div>
  </section>
  <!-- /main -->
@endsection

@section('footer-js')
  <script src="/plugins/sticky/jquery.sticky.js"></script>
  <script>
      (function($) {
          "use strict";
          // lightbox
          $('[data-lightbox]').lightbox({
              disqus: 'gameforestyakuzieu'
          });
      })(jQuery);
  </script>
@endsection
