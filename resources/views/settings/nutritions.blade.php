@extends('layouts.dashboard')

@section('pagetitle')
Nutritions
@endsection
@section('titleaction')
<a href="/settings/addnutrition"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a>
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
<div class="nav-tabs-horizontal">
    <ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs">
    	@for ($i = 0; $i < count($categories); $i++)
    		<li role="presentation" {{ $i == 0 ? 'class=active' : '' }}><a role="tab" aria-controls="Tabs{{ $i }}" href="#Tabs{{ $i }}" data-toggle="tab" aria-expanded="true">{{ $categories[$i]['category'] }}</a></li> 
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
								<th>Food Name</th>
								<th>Portion Size</th>
								<th>Calories</th>
								<th>Fats</th>
								<th>Carbs</th>
								<th>Proteins</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($nutritions as $ntr)
							@if ($ntr['category'] == $categories[$i]['category'])
							<tr>
								<td>{{ $ntr['name'] }}</td>
								<td>{{ $ntr['portion_name'] }}</td>
								<td>{{ $ntr['calories'] }}</td>
								<td>{{ $ntr['fats'] }}</td>
								<td>{{ $ntr['carbs'] }}</td>
								<td>{{ $ntr['proteins'] }}</td>
								<td>
									<a href="/settings/nutritions/star/{{ $ntr['id'] }}/{{ $ntr['favorite'] == 1 ? '0' : '1' }}" style="float:left;">
										<button data-original-title="Favorite" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="submit">
											<i aria-hidden="true" class="icon wb-star" {{ $ntr['favorite'] == 1 ? 'style=color:red;' : '' }}></i>
										</button>
									</a>
									<form action="/settings/nutritions/{{ $ntr['id'] }}" method="POST" style="float:left;">
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