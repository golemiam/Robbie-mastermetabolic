@extends('layouts.dashboard')

@section('pagetitle')
Exercise Programs
@endsection
@section('titleaction')
<a href="/settings/addexercisetemplate"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
	<div class="col-md-12">
		<div class="example-wrap">
			<div class="example table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($templates as $template)
						<tr>
							<td>{{ $template['name'] }}</td>
							<td>
								<a href="/settings/editexercisetemplate/{{ $template['id'] }}" style="float: left">
									<button data-original-title="Edit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-wrench"></i>
									</button></a>
								<form action="/settings/exercisetemplates/{{ $template['id'] }}" method="POST" style="float: left">
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