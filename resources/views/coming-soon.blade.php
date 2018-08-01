<!DOCTYPE html>
<html lang="en">
<head>
  <!-- meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>{{ env('APP_NAME', 'PrOjEcT') }}</title>
  <!-- vendor css -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/animate/animate.min.css">
  <!-- theme css -->
  <link rel="stylesheet" href="css/theme.min.css">
  <link rel="stylesheet" href="css/custom.css">
</head>
<body class="fixed-header">
  <!-- header -->
  <header id="header">
    <div class="container">
      <div class="navbar-backdrop">
        <div class="navbar">
          <div class="navbar-left">
            <a class="navbar-toggle"><i class="fa fa-bars"></i></a>
            <!--<a href="index.html" class="logo"><img src="img/logo.png" alt="Gameforest - Game Theme HTML"></a>-->
            {{ env('APP_NAME', 'PrOjEcT') }}

          </div>
          <div class="nav navbar-right">
            <ul>
              <li class="hidden-xs-down"><a href="login.html">Login</a></li>
              <li class="hidden-xs-down"><a href="register.html">Register</a></li>
              <li><a data-toggle="search"><i class="fa fa-search"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="navbar-search">
        <div class="container">
          <form method="post">
            <input type="text" class="form-control" placeholder="Search...">
            <i class="fa fa-times close"></i>
          </form>
        </div>
      </div>
    </div>
  </header>
  <!-- /header -->

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

  <!-- footer -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-5">
          <h4 class="footer-title">About {{ env('APP_NAME', 'PrOjEcT') }}</h4>
          <p>This project isn't ready for you. Sorry. We are working quickly to get it rolling, but we are not there yet.</p>
          <p>We haven't even setup the newsletter section yet. So don't try it... yet.</p>
        </div>
        <div class="col-sm-12 col-md-3">
          <h4 class="footer-title">Platform</h4>
          <div class="row">
            <div class="col">
              <ul>
                <li><a href="#">Playstation 4</a></li>
                <li><a href="#">Xbox One</a></li>
                <li><a href="#">PC</a></li>
                <li><a href="#">Steam</a></li>
              </ul>
            </div>
            <div class="col">
              <ul>
                <li><a href="games.html">Games</a></li>
                <li><a href="reviews.html">Reviews</a></li>
                <li><a href="videos.html">Videos</a></li>
                <li><a href="forums.html">Forums</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <h4 class="footer-title">Subscribe</h4>
          <p>Subscribe to our newsletter and get notification when new games are available.</p>
          <div class="input-group m-t-25">
            <input type="text" class="form-control" placeholder="Email">
            <span class="input-group-btn">
            <button class="btn btn-primary" type="button">Subscribe</button>
          </span>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="footer-social">
          <a href="https://facebook.com/" target="_blank" data-toggle="tooltip" title="facebook"><i class="fa fa-facebook"></i></a>
          <a href="https://twitter.com/" target="_blank" data-toggle="tooltip" title="twitter"><i class="fa fa-twitter"></i></a>
          <a href="https://steamcommunity.com/" target="_blank" data-toggle="tooltip" title="steam"><i class="fa fa-steam"></i></a>
          <a href="https://www.twitch.tv/" target="_blank" data-toggle="tooltip" title="twitch"><i class="fa fa-twitch"></i></a>
          <a href="https://www.youtube.com/user/" target="_blank" data-toggle="tooltip" title="youtube"><i class="fa fa-youtube"></i></a>
        </div>
        <p>Copyright &copy; 2018 <a href="" target="_blank">{{ env('APP_NAME', 'PrOjEcT') }}</a>. All rights reserved.</p>
      </div>
    </div>
  </footer>
  <!-- /footer -->

  <!-- vendor js -->
  <script src="plugins/jquery/jquery-3.2.1.min.js"></script>
  <script src="plugins/popper/popper.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>

  <!-- plugins js -->
  <script src="plugins/countdown/jquery.countdown.min.js"></script>
  <script>
    (function($) {
      "use strict";
      var d = new Date(),
        month = d.getMonth() + 2,
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

  <!-- theme js -->
  <script src="js/theme.min.js"></script>
</body>
</html>