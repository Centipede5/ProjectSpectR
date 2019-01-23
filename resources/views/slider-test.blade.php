@extends('layouts.master')

@section('page-title')Blank Page @endsection

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
        <div class="container blank">
            @foreach($slides as $slide)
                <p>{{$slide->slide_title}}</p>
                <p>{{$slide->slide_description}}</p>
                <p>{{$slide->button_text}}</p>
            @endforeach
        </div>
    </section>
<!-- /main -->
@endsection