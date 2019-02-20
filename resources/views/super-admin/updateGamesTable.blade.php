@extends('super-admin-layouts.master')
@section('page-title')Update Games Table @endsection
@section('head')
<script>
  function updateField(property){
      const gameId = $(property).closest("tr").prop("id");
      const container =  $(property).closest("td").prop("id");
      const containerId = "#"+container;
      let textToUpdate = $(property).html();

      $(containerId).empty();
      $(containerId).append("<textarea>"+textToUpdate+"</textarea><button onclick='saveField(this)'>save</button>");
  }

  function saveField(property){
      const gameId = $(property).closest("tr").prop("id");
      const container =  $(property).closest("td").prop("id");
      const containerId = "#"+container;
      const newText =  $(property).prev().val();

      console.log("Updated Text: " + newText);

      // Add Save Logic
      $(containerId).empty();
      $(containerId).append("<span onclick='updateField(this)'>"+newText+"</span>");
  }

</script>
@endsection

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
                                <h3 class="m-portlet__head-text">DB Table :: games</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__sub">
                                When information is loaded into the DB Tables, sometimes the info is incorrect and needs to be updated. You can do that here and it will be saved to a separate UPDATE file and will also be applied to the table record.
                                <br>
                                <em>** I need to add a search feature here.* *</em>
                            </div>
                            <div class="m-section__content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Email Address</th>
                                            <th>Display Name</th>
                                            <th>Name</th>
                                            <th>Profile Image</th>
                                            <th>Background Image</th>
                                            <th>Unique Id</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($games as $game)
                                            <tr id="{{$game->id}}">
                                                <th scope="row">{{$game->id}}</th>
                                                <td id="slug-{{$game->id}}"><span onclick="updateField(this)">{{$game->slug}}</span></td>
                                                <td id="title-{{$game->id}}"><span onclick="updateField(this)">{{$game->title}}</span></td>
                                                <td><a href="{{$game->image_portrait}}" target="_blank"><img src="{{$game->image_portrait}}" style="width: 40px" /></a></td>
                                                <td><a href="{{$game->image_portrait}}" target="_blank"><img src="{{$game->image_landscape}}" style="width: 120px" /></a></td>
                                                <td id="synopsis-{{$game->id}}"><span onclick="updateField(this)">{{$game->synopsis}}</span></td>
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
