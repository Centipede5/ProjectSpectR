@extends('layouts.master')

@section('page-title')Home @endsection

@section('main-content')
  <!-- main -->
  <!-- Start Slider -->
  <section class="bg-inverse p-y-0">
    <div class="owl-carousel owl-slide full-height">
      @foreach($slides as $slide)
      <div class="carousel-item" style="background-image: url('{{$slide->image}}');">
        <div class="carousel-overlay"></div>
        <div class="carousel-caption">
          <div>
            <h3 class="carousel-title">{{$slide->slide_title}}</h3>
            <p>{{$slide->slide_description}}</p>
            <a class="btn btn-primary btn-rounded btn-shadow btn-lg" href="{{$slide->button_link}}" data-lightbox role="button">{{$slide->button_text}}</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  <!-- End Slider -->

  <section class="p-y-80">
    <div class="container">
      <div class="heading">
        <i class="fab fa-steam-symbol"></i>
        <h2>Upcoming Games</h2>
        <p>Check Out Some Of The Hottest Games That Are Coming Soon!</p>
      </div>
      <div class="row">

        @foreach($games as $game)
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-ps4">
              <a href="https://www.igdb.com/games/{{$game->slug}}" target="_blank"><img src="{{$game->image_landscape}}" class="card-img-top" alt="{{$game->slug}}"></a>
              <div style="margin: -40px 0 18px 0">

                @foreach(json_decode($game->platforms) as $platform)
                  <div class="badge badge-{{ strtolower($platform) }}" style="position: unset; ">
                      <a href="/platform/{{ $platform }}">{{ $platform }}</a>
                  </div>
                @endforeach

              </div>
              <div class="card-likes">
                <a href="#">15</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="https://www.igdb.com/games/{{$game->slug}}" target="_blank">{{$game->title}}</a></h4>
              <div class="card-meta"><span>{{$game->release_date}}</span></div>
              <p class="card-text">{{$game->synopsis}}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="text-center"><a class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg m-t-10" href="javascript:alert('Coming Soon. Work in Progress.')">Show More</a></div>
    </div>
  </section>

  <section class="bg-image" style="background-image: url('https://i.ytimg.com/vi/ZFwylDNpgFc/maxresdefault.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="video-play" data-src="https://www.youtube.com/embed/ZFwylDNpgFc?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
        <div class="embed-responsive embed-responsive-16by9">
          <img class="embed-responsive-item" src="https://i.ytimg.com/vi/ZFwylDNpgFc/maxresdefault.jpg" alt="">
          <div class="video-play-icon">
            <i class="fa fa-play"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-primary promo">
    <div class="container">
      @guest
      <h2>Get envolved and join the Community</h2>
        <a class="btn btn-outline-default" href="https://www.facebook.com/groups/SpectreGameClub/" target="_blank" role="button">Facebook Group <i class="fas fa-users"></i></a>
      @else
        <h2>Check out the list of known Release Dates</h2>
        <a class="btn btn-outline-default" href="/schedule" target="_blank" role="button">Schedule <i class="fas fa-calendar-alt"></i></a>
      @endguest
    </div>
  </section>
  <!-- /main -->
@endsection