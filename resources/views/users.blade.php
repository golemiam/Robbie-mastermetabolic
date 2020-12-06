@extends('layouts.dashboard')

@section('pagetitle')
Users
@endsection
@section('titleaction')
<a href="/users/new"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection
@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
	@foreach ($users as $user)
	@if(count($user->client) >= 1)
	<div class="col-md-6">
		<div class="example-wrap">
			<h4 class="example-title">{{ $user->name }}<a href="/users/update/{{ $user['id'] }}"><i aria-hidden="true" class="icon wb-wrench" style="margin-left: 10px;"></i></a><a href="/users/myclients/{{ $user['id'] }}"><i aria-hidden="true" class="icon wb-users" style="margin-left: 10px;"></i></a></h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($user->client as $c)
							@if($c['status'] == 'active')
							<tr>
								<td>{{ $c['id'] }}</td>
								<td>{{ $c['name'] }}</td>
								<td>{{ $c['email'] }}</td>
								<td>{{ date("F j, Y", strtotime($c['created_at'])) }}</td>
								<td>
									<a href="/users/update/{{ $c['id'] }}">
										<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
												<i aria-hidden="true" class="icon wb-wrench"></i>
										</button></a>
									<button data-error-message="User not deleted" data-success-message="done" data-redirect-url="/users/delete/{{ $c['id'] }}" data-confirm-title="Are you sure you want to delete {{ $c['name'] }}" data-type="confirm" data-plugin="alertify" id="confirm" data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
										<i aria-hidden="true" class="icon wb-close"></i>
									</button>
								</td>
							</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	@endif
	@endforeach
		<div class="col-md-6">
		<div class="example-wrap">
			<h4 class="example-title">Additional Trainers</h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						@if($user['role'] == 'trainer' && !count($user->client) >= 1)
						<tr>
							<td>{{ $user['name'] }}</td>
							<td>{{ $user['email'] }}</td>
							<td>{{ date("F j, Y", strtotime($user['created_at'])) }}</td>
							<td>
								<a href="/users/update/{{ $user['id'] }}">
									<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-wrench"></i>
									</button></a>
								<button data-error-message="User not deleted" data-success-message="done" data-redirect-url="/users/delete/{{ $user['id'] }}" data-confirm-title="Are you sure you want to delete {{ $user['name'] }}" data-type="confirm" data-plugin="alertify" id="confirm" data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
									<i aria-hidden="true" class="icon wb-close"></i>
								</button>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
		<div class="col-md-6">
		<div class="example-wrap">
			<h4 class="example-title">Additional Clients</h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						@if($user['role'] == 'client' && $user['owner_id'] == 0)
						<tr>
							<td>{{ $user['name'] }}</td>
							<td>{{ $user['email'] }}</td>
							<td>{{ date("F j, Y", strtotime($user['created_at'])) }}</td>
							<td>
								<a href="/users/update/{{ $user['id'] }}">
									<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-wrench"></i>
									</button></a>
								<button data-error-message="User not deleted" data-success-message="done" data-redirect-url="/users/delete/{{ $user['id'] }}" data-confirm-title="Are you sure you want to delete {{ $user['name'] }}" data-type="confirm" data-plugin="alertify" id="confirm" data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
									<i aria-hidden="true" class="icon wb-close"></i>
								</button>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
		<div class="col-md-6">
		<div class="example-wrap">
			<h4 class="example-title">Archived Clients</h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						@if($user['status'] == 'archived')
						<tr>
							<td>{{ $user['name'] }}</td>
							<td>{{ $user['email'] }}</td>
							<td>{{ date("F j, Y", strtotime($user['created_at'])) }}</td>
							<td>
								<a href="/users/update/{{ $user['id'] }}">
									<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-wrench"></i>
									</button></a>
								<button data-error-message="User not deleted" data-success-message="done" data-redirect-url="/users/delete/{{ $user['id'] }}" data-confirm-title="Are you sure you want to delete {{ $user['name'] }}" data-type="confirm" data-plugin="alertify" id="confirm" data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
									<i aria-hidden="true" class="icon wb-close"></i>
								</button>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>

	
	<a href="/users/new"><button class="btn btn-raised btn-primary btn-default" type="button">Add New</button></a>
	
@endsection