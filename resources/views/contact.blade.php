@extends('layouts.master')

@section('page-title')Contact Us @endsection

@section('head')
    <!-- plugins css -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
@endsection

@section('main-content')
    <!-- main -->
    <section class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">Contact</li>
            </ol>
        </div>
    </section>

    <section class="p-b-0">
        <div class="container">
            <div class="heading">
                <i class="far fa-envelope"></i>
                <h2>Get in touch with us</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
            </div>
        </div>
    </section>

    <section class="p-t-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto">
                    <form method="post" action="">
                        {{ csrf_token() }}
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <b>Well done!</b> You successfully read this important alert message.
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                            <small class="form-text">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select id="subject" class="form-control select2">
                                        <option>General</option>
                                        <option>Partnership</option>
                                        <option>Report Bug</option>
                                        <option>Support</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" rows="6"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-rounded btn-effect btn-shadow float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /main -->
@endsection

@section('footer-js')
    <!-- plugins js -->
    <script src="plugins/select2/js/select2.min.js"></script>
    <script type="text/javascript">
        // select2
        $('.select2').select2();
    </script>
@endsection