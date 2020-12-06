@extends('layouts.dashboard')

@section('pagetitle')
My Clients
@endsection
@section('titleaction')
<a href="/users/new"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	@foreach ($groups as $g)
	<div class="col-md-12">
		<div class="example-wrap">
			<h4 class="example-title">{{ $g }}</h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Last Session</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $c)
							@foreach($c->groups as $cg)
								@if($g == $cg->name)
									<tr>
										<td>{{ $c['name'] }}</td>
										<td>{{ $c['email'] }}</td>
										<td>{{ date("F j, Y", strtotime($c['created_at'])) }}</td>
										<td><?php if(count($c->sessions) > 1){ echo date("F j, Y", strtotime($c->sessions[count($c->sessions)-1]['date']));} else{echo date("F j, Y", strtotime($c['created_at']));} ?></td>
										<td>
											@if($c['has_dashboard'])<a href="/user/{{ $c['id'] }}/dashboard"><button data-original-title="Dashboard" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-eye"></i></button></a>@endif
											<a href="/user/{{ $c['id'] }}/newsession"><button data-original-title="New Session" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-book"></i></button></a>
											@if($c['has_nutrition'])<a href="/user/{{ $c['id'] }}/nutritionprogram"><button data-original-title="Nutrition" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-heart"></i></button></a>@endif
											@if($c['has_exercise'])<a href="/user/{{ $c['id'] }}/exerciseprogram"><button data-original-title="Exercise" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-hammer"></i></button></a>@endif
											<a href="/user/{{ $c['id'] }}/sendresults"><button data-original-title="Send Results" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-envelope"></i></button></a>
											<a href="/users/update/{{ $c['id'] }}"><button data-original-title="Profile" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-user"></i></button></a>
										</td>
									</tr>
								@endif
							@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	@endforeach

	<div class="col-md-12">
		<div class="example-wrap">
			<h4 class="example-title">Other Users</h4>
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Email</th>
							<th>Date Joined</th>
							<th>Last Session</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $c)
						@if(count($c->groups) == 0)
						<tr>
							<td>{{ $c['name'] }}</td>
							<td>{{ $c['email'] }}</td>
							<td>{{ date("F j, Y", strtotime($c['created_at'])) }}</td>
							<td><?php if(count($c->sessions) > 1){ echo date("F j, Y", strtotime($c->sessions[count($c->sessions)-1]['date']));} else{echo date("F j, Y", strtotime($c['created_at']));} ?></td>
							<td>
								<a href="/user/{{ $c['id'] }}/dashboard"><button data-original-title="Dashboard" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-eye"></i></button></a>
								<a href="/user/{{ $c['id'] }}/newsession"><button data-original-title="New Session" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-book"></i></button></a>
								<a href="/user/{{ $c['id'] }}/nutritionprogram"><button data-original-title="Nutrition" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-heart"></i></button></a>
								<a href="/user/{{ $c['id'] }}/exerciseprogram"><button data-original-title="Exercise" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-hammer"></i></button></a>
								<a href="/user/{{ $c['id'] }}/sendresults"><button data-original-title="Send Results" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-envelope"></i></button></a>
								<a href="/users/update/{{ $c['id'] }}"><button data-original-title="Profile" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"><i aria-hidden="true" class="icon wb-user"></i></button></a>
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
	
@endsection