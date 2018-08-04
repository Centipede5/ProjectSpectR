@extends('layouts.master')

@section('page-title')Drafts @endsection

@section('main-content')
    <!-- main -->
    <section class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Drafts</li>
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
                                Drafts <a class="btn btn-sm btn-default pull-right" href="{{ route('list_posts') }}">Return</a>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    @foreach($posts as $post)
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3><a href="{{ route('show_post', ['post_id' => $post->id]) }}">{{ $post->post_title }}</a></h3>
                                                    <p>{{ str_limit($post->post_content, 50) }}</p>
                                                    <p>
                                                        @can('publish-post')
                                                            <a href="{{ route('publish_post', ['post_id' => $post->id]) }}" class="btn btn-sm btn-default" role="button">Publish</a>
                                                        @endcan
                                                        <a href="{{ route('edit_post', ['post_id' => $post->id]) }}" class="btn btn-default" role="button">Edit</a>
                                                    </p>
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
    <!-- /main -->
@endsection