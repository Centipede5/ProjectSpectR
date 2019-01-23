@extends('layouts.master')

@section('page-title')Blank Page @endsection
@section('head')
    <link href="/plugins/croppic/assets/css/main.css" rel="stylesheet">
    <link href="/plugins/croppic/assets/css/croppic.css" rel="stylesheet">
@endsection
@section('main-content')
<!-- main -->
    <section class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Blank Page</li>
            </ol>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row mt ">
                <div class="col-lg-4 ">
                    <h4 class="centered"> FINAL </h4>
                    <p class="centered"></p>
                    <div id="cropContainerEyecandy"></div>
                </div>
            </div>
        </div>
    </section>
<!-- /main -->
@endsection


@section('footer-js')
    <script src="/plugins/croppic/croppic.js"></script>
    <script>
        var croppicContainerEyecandyOptions = {
            uploadUrl:'/upload',
            cropUrl:'/crop',
            imgEyecandy:false,
            doubleZoomControls:false,
            rotateControls: true,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
            onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
            onImgDrag: function(){ console.log('onImgDrag') },
            onImgZoom: function(){ console.log('onImgZoom') },
            onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
            onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
            onReset:function(){ console.log('onReset') },
            onError:function(errormessage){ console.log('onError:'+errormessage) }
        };

        new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);

    </script>
@endsection