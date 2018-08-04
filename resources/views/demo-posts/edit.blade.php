@extends('layouts.master')

@section('page-title')Edit @endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Post</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('update_post', ['post_id' => $post->id]) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <input id="post_title" type="text" class="form-control" name="post_title" value="{{ old('post_title', $post->post_title) }}" required autofocus>

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
                                    <textarea name="post_content" id="post_content" cols="30" rows="10" class="form-control" required>{{ old('post_content', $post->post_content) }}</textarea>
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
                                        Update
                                    </button>
                                    @can('publish-post')
                                        <a href="{{ route('publish_post', ['post_id' => $post->id]) }}" class="btn btn-primary">
                                            Publish
                                        </a>
                                    @endcan
                                    <a href="{{ route('list_posts') }}" class="btn btn-primary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection