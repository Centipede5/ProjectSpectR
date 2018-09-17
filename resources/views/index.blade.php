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
        <p>Check Out the Hottest Games that are Coming Soon!</p>
      </div>
      <div class="row">

        @foreach($games as $game)
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-ps4">
              <a href="game-post.html"><img src="/img/game/{{$game->image_landscape}}" class="card-img-top" alt="{{$game->slug}}"></a>
              <div>

                @foreach(json_decode($game->platforms) as $platform)
                  <div class="badge badge-{{ $platform }}" style="margin-top: -40px;margin-bottom: 18px;">
                  {{ $platform }}
                  </div>
                @endforeach

              </div>
              <div class="card-likes">
                <a href="#">15</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="/game/{{$game->slug}}">{{$game->title}}</a></h4>
              <div class="card-meta"><span>{{$game->release_date_na}}</span></div>
              <p class="card-text">{{$game->synopsis}}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="text-center"><a class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg m-t-10" href="games.html">Show More</a></div>
    </div>
  </section>

  <section class="bg-secondary no-border-bottom p-y-80">
    <div class="container">
      <div class="heading">
        <i class="fa fa-star"></i>
        <h2>Recent Reviews</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </div>
      <div class="owl-carousel owl-list">
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="/img/game/marvels-spider-man-portrait.png" alt="">
          <div class="badge badge-ps4">8.7</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Spider-Man</a></h4>
            <p>A spectacular adventure.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="/img/game/octopath-traveler-2018-portrait.png" alt="">
          <div class="badge badge-nintendo">9.3</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Octopath Traveler</a></h4>
            <p>Whichever path you travel, this JRPG holds beauty and excellent combat in store.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="/img/game/divinity-original-sin-2-definitive-edition-portrait.png" alt="">
          <div class="badge badge-xbox-one">9.6</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Divinity: Original Sin 2 Definitive Edition</a></h4>
            <p>This brand new Divinity: Original Sin 2 package shows Larian Studios know how to polish a diamond.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="/img/game/donut-county-2018-portrait.png" alt="">
          <div class="badge badge-pc">7.8</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Donut County</a></h4>
            <p>Drop it like it’s hot.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-5.jpg" alt="">
          <div class="badge badge-success">8.9</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Grand Theft Auto: 5</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-6.jpg" alt="">
          <div class="badge badge-warning">4.7</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Dayz</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-7.jpg" alt="">
          <div class="badge badge-danger">3.1</div>
        </a>
          <div class="card-block">
            <h4 class="card-title">
              <a href="review-post.html">Liberty City</a>
            </h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
      </div>
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
      <h2>Get envolved and join a Community</h2>
      <a class="btn btn-outline-default" href="/register" target="_blank" role="button">Sign Me Up! <i class="fas fa-users"></i></a>
      @else
        <h2>Check out the list of known Release Dates</h2>
        <a class="btn btn-outline-default" href="/schedule" target="_blank" role="button">Schedule <i class="fas fa-calendar-alt"></i></a>
      @endguest
    </div>
  </section>
  <!-- /main -->
@endsection