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
            <form action="/fileupload" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </section>
<!-- /main -->
@endsection