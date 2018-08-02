@extends('layouts.master')

@section('page-title')Home Page @endsection

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

            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                You are logged in!
            </div>
            <div><p>{{ isset($msg) ? $msg : '' }}</p></div>

        </div>
    </section>
    <!-- /main -->
@endsection
