@extends('layouts.master')

@section('page-title')Create Post @endsection

@section('main-content')
    <!-- main -->
    <section class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Create Post</li>
            </ol>
        </div>
    </section>

    <section>
        <div class="container blank">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">New Post</div>

                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('store_post') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                                        <label for="title" class="col-md-4 control-label">Title</label>

                                        <div class="col-md-6">
                                            <input id="post_title" type="text" class="form-control" name="post_title" value="{{ old('post_title') }}" required autofocus>

                                            @if ($errors->has('post_title'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('post_content') ? ' has-error' : '' }}">
                                        <label for="body" class="col-md-4 control-label">Body</label>

                                        <div class="col-md-6">
                                            <textarea name="post_content" id="post_content" cols="30" rows="10" class="form-control" required>{{ old('post_content') }}</textarea>
                                            @if ($errors->has('post_content'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('post_content') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Create
                                            </button>
                                            <a href="{{ route('list_posts') }}" class="btn btn-primary">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="post_parent" name="post_parent" value="1" />
                                    <input type="hidden" id="post_type" name="post_type" value="review" />
                                    <input type="hidden" id="slug" name="slug" value="SLUG" />
                                    <input type="hidden" id="post_excerpt" name="post_excerpt" value="EXCERPT" />
                                    <input type="hidden" id="post_status" name="post_status" value="1" />
                                    <input type="hidden" id="published" name="published" value="1" />
                                    <input type="hidden" id="comment_count" name="comment_count" value="0" />
                                    <input type="hidden" id="spam_flag" name="spam_flag" value="0" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /main -->
@endsection