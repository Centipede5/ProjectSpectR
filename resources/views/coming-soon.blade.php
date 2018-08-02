@extends('layouts.master')

@section('page-title')Coming Soon... @endsection

@section('main-content')
  <!-- main -->
  <section class="bg-image bg-image-sm" style="background-image: url('https://img.youtube.com/vi/NxI7cPQxAPc/maxresdefault.jpg');">
    <div class="overlay"></div>
    <div class="coming-soon p-y-80">
      <div>
        <h2>Coming Soon!</h2>
        <div class="countdown">
          <div id="clock"></div>
        </div>
        <p>Our website is under construction, We'll be here soon, with our new site. Subscribe to be notified.</p>
        <div class="m-t-30">
          <a href="games.html" class="btn btn-primary btn-shadow btn-rounded btn-effect btn-lg">Subscribe</a>
          <a href="games.html" class="btn btn-outline-default btn-rounded btn-lg m-l-10">Contact Us</a>
        </div>
      </div>
    </div>
  </section>
  <!-- /main -->
@endsection

@section('footer-js')
  <!-- plugins js -->
  <script src="plugins/countdown/jquery.countdown.min.js"></script>
  <script>
    (function($) {
      "use strict";
      var d = new Date(),
        month = 10,
        year = d.getFullYear();
      // CountDown
      $('#clock').countdown(year + '/' + month + '/25', function(event) {
        var $this = $(this).html(event.strftime('' +
          '<div><span>%D</span> days </div> ' +
          '<div><span>%H</span> hours </div> ' +
          '<div><span>%M</span> min </div> ' +
          '<div><span>%S</span> sec</div> '));
      });
    })(jQuery);
  </script>
@endsection
