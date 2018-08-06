@extends('layouts.master')

@section('page-title')Login @endsection

@section('main-content')
    <!-- main -->
    <section class="bg-image bg-image-sm" style="background-image: url('img/bg/bg-login.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-4 mx-auto">
                    <div class="card m-b-0">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fa fa-sign-in"></i> Reset Password</h4>
                        </div>
                        <div class="card-block">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                                <div class="form-group input-icon-left m-b-10 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <i class="fa fa-user"></i>
                                    <input id="email" name="email" type="email" class="form-control form-control-secondary" placeholder="E-Mail Address"  value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <button type="submit" class="btn btn-primary btn-block m-t-10">Send Password Reset Link <i class="fa fa-sign-in"></i></button>
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
