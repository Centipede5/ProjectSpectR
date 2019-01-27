@extends('super-admin-layouts.master')
@section('page-title')Game ID Sync @endsection

@section('main-content')
@include('super-admin-layouts.subheader')
			<div class="m-content">
				<div class="row">
					<div class="col-md-12">
						<!--begin::Portlet-->
						<div class="m-portlet m-portlet--tab">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
											Synchronize Game ID's
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
								<!--begin::Section-->
								<div class="m-section">
									<h3>Game</h3>
									<select id="game-list" name="game-list">
										<option>--- SELECT GAME ---</option>
										@foreach($gameList as $game)
											<option id="{{ $game->slug }}" name="{{ $game->slug }}" value="{{ $game->id }}">{{ $game->title }} | {{ $game->release_date }}</option>
										@endforeach
									</select>
									<button>Skip</button>
									<hr />
										<div class="row mb-3 game-response">
										</div>
									<div class="m-section__content">

									</div><!--begin: Datatable -->
								</div>
								<!--end::Section-->
							</div>
						</div>
						<!--end::Portlet-->
					</div>
				</div>
			</div>
@endsection

@section('footer-js')
	<script src="/js/oniadmin/gameSync.js"></script>
@endsection
