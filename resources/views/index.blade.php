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
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-ps4">
              <a href="game-post.html"><img src="/img/game/spider-man-2018.jpg" class="card-img-top" alt="Marvel's Spider-Man"></a>
              <div class="badge badge-ps4">ps4</div>
              <div class="card-likes">
                <a href="#">15</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">Marvel's Spider-Man</a></h4>
              <div class="card-meta"><span>September 7, 2018</span></div>
              <p class="card-text">When a new villain threatens New York City, Peter Parker and Spider-Man’s worlds collide. To save the city and those he loves, he must rise up and be greater.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-xbox">
              <a href="game-post.html"><img src="img/game/shadow-of-the-tomb-raider-2018.jpg" class="card-img-top" alt="Shadow of the Tomb Raider"></a>
              <div class="badge badge-xbox-one">Xbox One</div>
              <div class="card-likes">
                <a href="#">87</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">Shadow of the Tomb Raider</a></h4>
              <div class="card-meta"><span>September 14, 2018</span></div>
              <p class="card-text">Experience Lara Croft’s defining moment as she becomes the Tomb Raider. Lara must master a deadly jungle and persevere through her darkest hour.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-ps4">
              <a href="game-post.html"><img src="img/game/mega-man-11-2018.png" class="card-img-top" alt="Mega Man 11"></a>
              <div class="badge badge-ps4">ps4</div>
              <div class="card-likes">
                <a href="#">23</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">Mega Man 11</a></h4>
              <div class="card-meta"><span>Oct 02, 2018</span></div>
              <p class="card-text">The Blue Bomber is Back! The newest entry in this iconic series blends classic, challenging 2D platforming action with a fresh look.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-nintendo">
              <a href="game-post.html"><img src="img/game/super-mario-party-2018.jpg" class="card-img-top" alt="Super Mario Party"></a>
              <div class="badge badge-nintendo">Switch</div>
              <div class="card-likes">
                <a href="#">19</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">Super Mario Party</a></h4>
              <div class="card-meta"><span>October 05, 2018</span></div>
              <p class="card-text">The Mario Party series is coming to the Nintendo Switch system with super-charged fun for everyone! The original board game style has been kicked up a notch with deeper strategic elements.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-ps4">
              <a href="game-post.html"><img src="img/game/black-ops-4-2018.png" class="card-img-top" alt="COD: Black Ops 4"></a>
              <div class="badge badge-ps4">Ps4</div>
              <div class="card-likes">
                <a href="#">36</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">COD: Black Ops 4</a></h4>
              <div class="card-meta"><span>October 12, 2018</span></div>
              <p class="card-text">Black Ops is back!<br />Featuring gritty, grounded, fluid Multiplayer combat, the biggest Zombies offering ever with three full undead adventures at launch, and Blackout.</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card card-lg">
            <div class="card-img bottom-border-xbox">
              <a href="game-post.html"><img src="/img/game/soulcalibur-6-2018.jpg" class="card-img-top" alt="Soulcalibur 6"></a>
              <div class="badge badge-xbox-one">Xbox One</div>
              <div class="card-likes">
                <a href="#">73</a>
              </div>
            </div>
            <div class="card-block">
              <h4 class="card-title"><a href="game-post.html">Soulcalibur 6</a></h4>
              <div class="card-meta"><span>October 19, 2017</span></div>
              <p class="card-text">SOULCALIBUR VI represents the latest entry in the premier weapons-based, head-to-head fighting series and continues the epic struggle of warriors searching for the legendary Soul Swords.</p>
            </div>
          </div>
        </div>
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
          <img src="img/review/review-1.jpg" alt="">
          <div class="badge badge-success">7.2</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Uncharted 4</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-2.jpg" alt="">
          <div class="badge badge-warning">5.4</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Hitman: Absolution</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-3.jpg" alt="">
          <div class="badge badge-danger">2.1</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Last of us: Remastered</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          </div>
        </div>
        <div class="card card-review">
          <a class="card-img" href="review-post.html">
          <img src="img/review/review-4.jpg" alt="">
          <div class="badge badge-success">7.8</div>
        </a>
          <div class="card-block">
            <h4 class="card-title"><a href="review-post.html">Bioshock: Infinite</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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