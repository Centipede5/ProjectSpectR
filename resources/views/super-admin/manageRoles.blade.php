@extends('super-admin-layouts.master')
@section('page-title')Manage Roles @endsection

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
											Permissions
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
								<!--begin::Section-->
								<div class="m-section">
									<span class="m-section__sub">
										Choose the permissions for each Access Role:
									</span>
									<div class="m-section__content">
										<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
											<div class="m-demo__preview">
												<!--begin::Form-->
												<form class="m-form" method="post" action="">
													{{ csrf_field() }}
														<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
														<thead>
														<tr>
															<th>
																Role
															</th>
															<th style="text-align: center">
																Update Profile
															</th>
															<th style="text-align: center">
																Comment on Post
															</th>
															<th style="text-align: center">
																Create Post
															</th>
															<th style="text-align: center">
																Update Post
															</th>
															<th style="text-align: center">
																Publish Post
															</th>
															<th style="text-align: center">
																Post Unlimited
															</th>
															<th style="text-align: center">
																Site Moderator
															</th>
															<th style="text-align: center">
																Site Admin
															</th>
														</tr>
														</thead>
														<tbody>
														@foreach($roles as $role)
															<tr>
																<td>
																	{{$role->name}}
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-update-profile" name="{{$role->slug}}-update-profile" type="checkbox" @if ( $role->permissions['update-profile'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-comment-on-post" name="{{$role->slug}}-comment-on-post" type="checkbox" @if ( $role->permissions['comment-on-post'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-create-post" name="{{$role->slug}}-create-post" type="checkbox" @if ( $role->permissions['create-post'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-update-post" name="{{$role->slug}}-update-post" type="checkbox" @if ( $role->permissions['update-post'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-publish-post" name="{{$role->slug}}-publish-post" type="checkbox" @if ( $role->permissions['publish-post'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-post-unlimited" name="{{$role->slug}}-post-unlimited" type="checkbox" @if ( $role->permissions['post-unlimited'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->naslugme}}-site-moderator" name="{{$role->slug}}-site-moderator" type="checkbox" @if ( $role->permissions['site-moderator'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
																<td style="text-align: center"><label class="m-checkbox">
																		<input id="{{$role->slug}}-site-admin" name="{{$role->slug}}-site-admin" type="checkbox" @if ( $role->permissions['site-admin'] ) checked="checked" @endif>
																		<span></span>
																	</label>
																</td>
															</tr>
														@endforeach
														</tbody>
													</table>
													<input type="submit" value="Update" />
												</form>
												<!--end::Form-->
											</div>
										</div>
									</div><!--begin: Datatable -->
									@foreach($roles as $role)
										<div><h4>{{$role->name}}</h4>
											<p>
											{{$role->description}}
											</p>
										</div>
									@endforeach
								</div>
								<!--end::Section-->
							</div>
						</div>
						<!--end::Portlet-->
					</div>
				</div>
			</div>
@endsection
