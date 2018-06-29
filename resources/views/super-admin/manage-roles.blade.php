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
												<form class="m-form">
													<div class="m-form__group form-group">
														<label for="">
															Administrator
														</label>
														<div class="m-checkbox-inline">
															<label class="m-checkbox">
																<input type="checkbox">
																Update Profile
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Comment on Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Create Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Update Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Publish Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Update Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Post Limit
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Site Moderator
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Site Admin
																<span></span>
															</label>
														</div>
														<span class="m-form__help">
															 Nothing is off limits. Reserved for Elite Team members. Able to remove and elevate users. They can also help with support tickets. All updates and changes are logged and reversible.
														</span>
													</div>
													<div class="m-form__group form-group">
														<label for="">
															Editor / Site Moderator
														</label>
														<div class="m-checkbox-inline">
															<label class="m-checkbox">
																<input type="checkbox">
																Update Profile
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Comment on Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Create Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Update Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Publish Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Update Post
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Post Limit
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Site Moderator
																<span></span>
															</label>
															<label class="m-checkbox">
																<input type="checkbox">
																Site Admin
																<span></span>
															</label>
														</div>
														<span class="m-form__help">
															 Nothing is off limits. Reserved for Elite Team members. Able to remove and elevate users. They can also help with support tickets. All updates and changes are logged and reversible.
														</span>
													</div>
												</form>
												<!--end::Form-->
											</div>
										</div>
									</div>
								</div>
								<!--end::Section-->
								@foreach($roles as $role)

									<div class="col-sm-6 col-md-4">
										{{ $role->name }} <br>
									</div>
								@endforeach
							</div>
						</div>
						<!--end::Portlet-->
					</div>
				</div>
			</div>
@endsection
