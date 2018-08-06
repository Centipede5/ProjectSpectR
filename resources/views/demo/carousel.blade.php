@extends('layouts.master')

@section('page-title')Blank Page @endsection

@section('main-content')
  <!-- main -->
  <section class="bg-primary">
    <div class="container">
      <h3 class="text-white font-weight-300 m-b-0">Carousel Component</h3>
    </div>
  </section>

  <section class="breadcrumbs">
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Compontents</a></li>
        <li class="active">Carousel</li>
      </ol>
    </div>
  </section>

  <section>
    <div class="container">
      <h5>Bootstrap Carousel</h5>
      <p class="p-b-10">A slideshow component for cycling through elements, like a carousel. Place just about any optional HTML within there and it will be automatically aligned and formatted.</p>
      <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel" data-slide-to="0" class="active"></li>
          <li data-target="#carousel" data-slide-to="1"></li>
          <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Uncharted: The Lost Legacy</h2>
                <p>Uncharted: The Lost Legacy is the first standalone adventure in Uncharted franchise history.</p>
                <a href="#" class="btn btn-primary btn-lg btn-rounded">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/BlINFsdTKQ4/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Monster Hunter World</h2>
                <p>Journey to System 3 and discover an unimaginable world filled with unusual characters.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/OzRs7AMR4e8/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">God of War</h2>
                <p>God of War is a shared-world action-RPG, where players can delve into a vast world teeming with amazing technology.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <h5 class="m-t-80">Carousel Fade</h5>
      <p class="p-b-10">A slideshow component for cycling through elements, like a carousel. Place just about any optional HTML within there and it will be automatically aligned and formatted.</p>
      <div id="carousel-fade" class="carousel slide fade" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-fade" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-fade" data-slide-to="1"></li>
          <li data-target="#carousel-fade" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Uncharted: The Lost Legacy</h2>
                <p>Uncharted: The Lost Legacy is the first standalone adventure in Uncharted franchise history.</p>
                <a href="#" class="btn btn-primary btn-lg btn-rounded">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/BlINFsdTKQ4/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Monster Hunter World</h2>
                <p>Journey to System 3 and discover an unimaginable world filled with unusual characters.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/OzRs7AMR4e8/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">God of War</h2>
                <p>God of War is a shared-world action-RPG, where players can delve into a vast world teeming with amazing technology.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-fade" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-fade" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <h5 class="m-t-80">Ken Burns effect</h5>
      <p class="p-b-10">A slideshow component for cycling through elements, like a carousel. Place just about any optional HTML within there and it will be automatically aligned and formatted.</p>
      <div id="carousel-ken-burns" class="carousel slide fade ken-burns" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-ken-burns" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-ken-burns" data-slide-to="1"></li>
          <li data-target="#carousel-ken-burns" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active item-active">
            <img src="https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Uncharted: The Lost Legacy</h2>
                <p>Uncharted: The Lost Legacy is the first standalone adventure in Uncharted franchise history.</p>
                <a href="#" class="btn btn-primary btn-lg btn-rounded">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/BlINFsdTKQ4/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">Monster Hunter World</h2>
                <p>Journey to System 3 and discover an unimaginable world filled with unusual characters.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/OzRs7AMR4e8/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title">God of War</h2>
                <p>God of War is a shared-world action-RPG, where players can delve into a vast world teeming with amazing technology.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-ken-burns" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-ken-burns" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <h5 class="m-t-80">Animated Caption</h5>
      <p class="p-b-10">A slideshow component for cycling through elements, like a carousel. Place just about any optional HTML within there and it will be automatically aligned and formatted.</p>
      <div id="carousel-animated" class="carousel slide carousel-animated" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-animated" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-animated" data-slide-to="1"></li>
          <li data-target="#carousel-animated" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://img.youtube.com/vi/K5tRSwd-Sc0/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title" data-animation="animated fadeInDown">Uncharted: The Lost Legacy</h2>
                <p data-animation="animated animate3 fadeIn">Uncharted: The Lost Legacy is the first standalone adventure in Uncharted franchise history.</p>
                <a href="#" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate5 fadeInUp">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/BlINFsdTKQ4/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title" data-animation="animated animate2 bounceInDown">Monster Hunter World</h2>
                <p data-animation="animated animate5 fadeInUp fast">Journey to System 3 and discover an unimaginable world filled with unusual characters.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate7 fadeIn fast">Watch Gameplay</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://img.youtube.com/vi/OzRs7AMR4e8/maxresdefault.jpg" alt="">
            <div class="carousel-overlay"></div>
            <div class="carousel-caption">
              <div>
                <h2 class="carousel-title" data-animation="animated animate3 bounceIn">God of War</h2>
                <p data-animation="animated animate3 fadeIn">God of War is a shared-world action-RPG, where players can delve into a vast world teeming with amazing technology.</p>
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate3 fadeIn">Watch Gameplay</a>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carousel-animated" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-animated" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>
  <!-- /main -->
@endsection