@extends('layouts.master')

@section('page-title')Posts @endsection

@section('main-content')
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

            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Posts
                                @can('create-post')
                                    <a class="pull-right btn btn-sm btn-primary" href="{{ route('create_post') }}">New</a>
                                @endcan
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    @foreach($posts as $post)
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3><a href="{{ route('show_post', ['post_id' => $post->id]) }}">{{ $post->post_title }}</a></h3>
                                                    <p>{{ str_limit($post->post_content, 50) }}</p>
                                                    @can('update-post', $post)
                                                        <p>
                                                            <a href="{{ route('edit_post', ['post_id' => $post->id]) }}" class="btn btn-sm btn-default" role="button">Edit</a>
                                                        </p>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection