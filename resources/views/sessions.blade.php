@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Sessions
@endsection
@section('titleaction')
<a href="/user/{{ $client->id }}/newsession"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
	<div class="col-md-6">
		<div class="example-wrap">
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Location</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($client->sessions as $session)
						<tr>
							<td>{{ $session['session_number'] }}</td>
							<td>{{ $session['date'] }}</td>
							<td>{{ $session['location'] }}</td>
							<td>
								<a href="/user/{{ $client['id'] }}/editsession/{{ $session['id'] }}" style="float: left">
									<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-wrench"></i>
									</button></a>
								<form action="/user/{{ $client['id'] }}/destroysession/{{ $session['id'] }}" method="POST">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}

									<button data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="submit">
										<i aria-hidden="true" class="icon wb-close"></i>
									</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	
@endsection