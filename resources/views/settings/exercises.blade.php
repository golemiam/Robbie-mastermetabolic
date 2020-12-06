@extends('layouts.dashboard')

@section('pagetitle')
Exercises
@endsection
@section('titleaction')
<a href="/settings/addexercise"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
<div class="nav-tabs-horizontal">
    <ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs">
    	@for ($i = 0; $i < count($categories); $i++)
    		<li role="presentation" {{ $i == 0 ? 'class=active' : '' }}><a role="tab" aria-coexeols="Tabs{{ $i }}" href="#Tabs{{ $i }}" data-toggle="tab" aria-expanded="true">{{ $categories[$i]['category'] }}</a></li> 
		@endfor
    </ul>
    <div class="tab-content padding-top-20">
    	@for ($i = 0; $i < count($categories); $i++)
        <div role="tabpanel" id="Tabs{{ $i }}" class="tab-pane {{ $i == 0 ? 'active' : '' }}">
			<div class="col-md-6">
			<div class="example-wrap">
				<div class="example table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Exercise Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($exercise as $exe)
							@if ($exe['category'] == $categories[$i]['category'])
							<tr>
								<td>{{ $exe['name'] }}</td>
								<td>
									<a href="/settings/exercises/star/{{ $exe['id'] }}/{{ $exe['favorite'] == 1 ? '0' : '1' }}" style="float:left;">
										<button data-original-title="Favorite" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="submit">
											<i aria-hidden="true" class="icon wb-star" {{ $exe['favorite'] == 1 ? 'style=color:red;' : '' }}></i>
										</button>
									</a>
									<form action="/settings/exercises/{{ $exe['id'] }}" method="POST">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}

										<button data-original-title="Delete" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="submit">
											<i aria-hidden="true" class="icon wb-close"></i>
										</button>
									</form>
								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endfor
</div>
</div>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	
@endsection