@extends('layouts.master')

@section('page-title')Login @endsection

@section('main-content')
    <!-- main -->
    <section class="bg-image bg-image-sm" style="background-image: url('/img/bg/bg-login.jpg');">
        <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-8 col-md-4 mx-auto">
            <div class="card m-b-0">
              <div class="card-header">
                <h4 class="card-title"><i class="fas fa-sign-in"></i> Sign In to Your Account</h4>
              </div>
              <div class="card-block">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <!--<a class="btn btn-social btn-facebook btn-block btn-icon-left" href="" role="button"><i class="fa fa-facebook"></i> Connect with Facebook</a>
                <div class="divider">
                  <span>or</span>
                </div>-->
                  <div class="form-group input-icon-left m-b-10 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <i class="fas fa-user"></i>
                    <input id="email" name="email" type="email" class="form-control form-control-secondary" placeholder="E-Mail Address" value="{{ old('email') }}" autocomplete="on" autofocus required>

                    @if ($errors->has('email'))
                      <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                  </div>
                  <div class="form-group input-icon-left m-b-15 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <i class="fas fa-lock"></i>
                    <input id="password" name="password" type="password" class="form-control form-control-secondary" placeholder="Password" autocomplete="on" required>
                    @if ($errors->has('password'))
                      <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                  <label class="custom-control custom-checkbox custom-checkbox-primary">
                    <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Remember me</span>
                  </label>
                  <button type="submit" class="btn btn-primary btn-block m-t-10">Login <i class="fas fa-sign-in"></i></button>

                  <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                  </a>
                  <div class="divider">
                    <span>Don't have an account?</span>
                  </div>
                  <a class="btn btn-secondary btn-block" href="/register" role="button">Register</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- /main -->
@endsection