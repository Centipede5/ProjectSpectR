@extends('super-admin-layouts.master')
@section('page-title')Manage Users @endsection

@section('main-content')
    @include('super-admin-layouts.subheader')
    <div class="m-content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Responsive tables
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__sub">
                                <input id="searchData" type="text" />
                                <select id="searchBy">
                                    <option id="searchByEmail">Email</option>
                                    <option id="searchByDisplayName">Display Name</option>
                                    <option id="searchByName">Name</option>
                                    <option id="searchById">Id</option>
                                </select>
                                <button id="searchButton">Search</button>
                            </div>
                            <div class="m-section__content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email Address</th>
                                            <th>Display Name</th>
                                            <th>Name</th>
                                            <th>Profile Image</th>
                                            <th>Background Image</th>
                                            <th>Unique ID</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr id="{{$user->id}}">
                                                <td scope="row">{{$user->id}}</td>
                                                <td id="email-{{$user->id}}"><span onclick="updateField(this)">{{$user->email}}</span></td>
                                                <td id="display_name-{{$user->id}}"><span onclick="updateField(this)">{{$user->display_name}}</span></td>
                                                <td id="name-{{$user->id}}"><span onclick="updateField(this)">{{$user->name}}</span></td>
                                                <td><a href="/uploads/{{$user->profile_image}}" target="_blank"><img src="/uploads/{{$user->profile_image}}" style="width: 40px" /></a></td>
                                                <td><a href="/uploads/{{$user->background_image}}" target="_blank"><img src="/uploads/{{$user->background_image}}" style="width: 120px" /></a></td>
                                                <td>{{$user->uniqid}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
