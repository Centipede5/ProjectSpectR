@extends('layouts.master')

@section('page-title')Register @endsection

@section('head')
<script>
    $( document ).ready(function() {
        $('#display_name').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str)) { return true; }
            e.preventDefault();

            return false;
        });
    });
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('main-content')
  <!-- main -->
  <section class="bg-image bg-image-sm" style="background-image: url('/img/background/background-8.jpg');">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fas fa-user-plus"></i> Register a new account</h4>
            </div>
            <div class="card-block">
              <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <!--<a class="btn btn-social btn-google-plus btn-block btn-icon-left" href="" role="button"><i class="fas fa-google-plus"></i> Register with Google Plus</a>
                <div class="divider"><span>or</span></div>-->
                <div class="form-group input-icon-left m-b-10">
                  <i class="fas fa-user"></i>
                  <input type="text" class="form-control form-control-secondary {{ $errors->has('display_name') ? ' has-error' : '' }}" placeholder="Username" id="display_name" name="display_name" value="{{ old('display_name') }}" maxlength="20" autocomplete="off" required autofocus>
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
                <div class="divider"><span>Security</span></div>
                <div class="form-group input-icon-left m-b-10 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <i class="fas fa-lock"></i>
                  <input type="password" id="password" name="password" class="form-control form-control-secondary" placeholder="Password" autocomplete="on" required>
                  @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group input-icon-left m-b-10">
                  <i class="fas fa-unlock"></i>
                  <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-secondary" placeholder="Repeat Password" autocomplete="on" required>
                </div>

                  <div class="form-group input-icon-left m-b-10">
                    <i class="fas fa-key"></i>
                    <input type="text" id="code" name="code" class="form-control form-control-secondary form-group{{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Invitation Code" value="{{ old('code') }}" maxlength="12" autocomplete="off" required>
                    @if ($errors->has('code'))
                      <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                    @endif
                  </div>
                <div class="divider"><span>I am not a machine</span></div>
                <div class="g-recaptcha-outer">
                  <div class="g-recaptcha" data-sitekey="6LdoeIUUAAAAAEpNO3r5HKXx5zEu675htSUAFXIH"></div>
                </div>
                <div class="divider"><span>Terms of Service</span></div>
                <label class="custom-control custom-checkbox custom-checkbox-primary">
                  <input type="checkbox" class="custom-control-input" required>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Accept <a href="#" data-toggle="modal" data-target="#terms">terms of service</a></span>
                </label>
                <button type="submit" class="btn btn-primary m-t-10 btn-block">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="terms">
      <div class="modal-dialog modal-top" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-file-text-o"></i> Terms of Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h6>1. Morbi ut pharetra tellus</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lobortis justo vel lorem sagittis, eu bibendum ipsum accumsan. Donec congue eget elit ut posuere. Curabitur congue, enim a viverra ultrices, elit velit auctor neque, eget vehicula
              augue purus et lectus. Mauris cursus ac ex in vehicula. Sed ut sagittis eros. Vivamus accumsan diam vitae lectus consectetur aliquet. Proin varius tempor ullamcorper. Quisque malesuada mollis arcu, in euismod nisi pharetra pellentesque.
              Sed ullamcorper quis dui sed varius. Fusce efficitur augue purus, vitae mattis orci blandit ac. Integer suscipit arcu ac diam tincidunt, sed elementum augue lobortis.</p>
            <p>Pellentesque finibus dui dui, sit amet scelerisque neque venenatis non. Nullam gravida nisi pretium malesuada luctus. Nunc porttitor ipsum a massa gravida congue. Vestibulum dapibus mauris sit amet volutpat faucibus. Nulla lacinia diam sed
              ultricies venenatis. Ut ultricies, urna commodo aliquam molestie, lectus leo efficitur tellus, et aliquam magna magna id est. In euismod ac magna quis imperdiet.</p>
            <p>Aliquam ornare elit neque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Morbi ut pharetra tellus. Vestibulum a dui nisl. Sed commodo sodales dolor, et malesuada nulla consectetur vitae. Quisque nec neque ac tellus auctor pellentesque
              vel eleifend urna. Phasellus non urna id tellus fringilla hendrerit. Quisque vel mauris nisi. Mauris nec odio vitae sapien sodales lacinia. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam sit amet nisi quis ex pretium
              congue id id magna. Aenean dictum justo sit amet augue mollis ullamcorper. Aliquam mattis vel mauris et elementum. Morbi et risus quis nisl ullamcorper pulvinar eget et erat.</p>
            <p>Ut viverra urna non orci interdum, in viverra urna pretium. Suspendisse potenti. Mauris et massa a enim lobortis facilisis. In hac habitasse platea dictumst. Ut varius erat vulputate libero sagittis, vitae feugiat nibh malesuada. Sed vel lacinia
              urna. Curabitur eget dui nisi.</p>
            <p>Vivamus orci felis, varius tempor lacus eu, scelerisque bibendum nunc. Vestibulum rutrum, enim quis maximus pretium, nisi est condimentum magna, venenatis dignissim magna nulla quis felis. Quisque id tellus nec mauris sagittis mattis non et
              quam. Etiam posuere, tellus sed tincidunt egestas, tortor orci interdum risus, nec egestas dolor tortor non turpis. Curabitur in tellus laoreet, congue eros a, bibendum tortor. Nulla in facilisis libero, sit amet sagittis tellus. Aliquam
              nec pulvinar velit, mattis pharetra urna. Donec et tincidunt libero. Duis at nisi in neque vulputate tempus. Curabitur et lobortis lacus. In sagittis egestas lorem, nec bibendum lacus maximus sed.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /main -->

@endsection