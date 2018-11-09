@extends('layouts.master')

@section('page-title')Contact Us @endsection

@section('head')
    <link rel="stylesheet" href="/plugins/cropper/cropper.css" />
    <style type="text/css">
        #cropperContainer{ width:1000px; height:563px; position: relative; border:1px solid #ccc;}
    </style>

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
                <div id="cropperContainer"><img src="/uploads/00-default-canopy-old.jpg" style="width: 100%;" /></div>
            </div>
        </div>
    </section>
    <!-- /main -->
@endsection

@section('footer-js')
    <script src="/plugins/cropper/cropper.js"></script>
    <script>
        var cropperContainerOptions = {
            uploadUrl:'/util/sliderImageUpload',
            cropUrl:'/util/sliderImageCrop',
            imgEyecandy:false,
            doubleZoomControls:false,
            rotateControls: false,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onError:function(errormessage){ console.log('onError:'+errormessage) }
        };
        new Cropper('cropperContainer', cropperContainerOptions);

    </script>
@endsection