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


  <!-- /main -->
@endsection