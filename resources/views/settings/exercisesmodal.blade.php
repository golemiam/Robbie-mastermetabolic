@if(count($categories) == 0)
No Results Found
@else
<div class="nav-tabs-horizontal">
	<ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs">
		@for ($i = 0; $i < count($categories); $i++)
			<li role="presentation" {{ $i == 0 ? 'class=active' : '' }}><a role="tab" aria-coexeols="Tabs{{ $i }}" href="#Tabs{{ $i }}" data-toggle="tab" aria-expanded="true">{{ $categories[$i]['category'] }}</a></li> 
		@endfor
	</ul>
	<div class="tab-content">
		@for ($i = 0; $i < count($categories); $i++)
		<div role="tabpanel" id="Tabs{{ $i }}" class="tab-pane {{ $i == 0 ? 'active' : '' }}">
			<div class="col-md-12">
			<div class="example-wrap">
				<div class="example table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Food Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($exercises as $exe)
							@if ($exe['category'] == $categories[$i]['category'])
							<tr>
								<td>{{ $exe['name'] }}</td>
								<td>
									<button data-original-title="Add" onclick="addExercise(['{{ $exe['name'] }}', '{{ $exe['portion_name'] }}', '{{ $exe['calories'] }}', '{{ $exe['fats'] }}', '{{ $exe['carbs'] }}', '{{ $exe['proteins'] }}', '{{ $categories[$i]['category'] }}'], {{ $i }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
										<i aria-hidden="true" class="icon wb-plus"></i>
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
	</div>
	@endfor
</div>
</div>
@endif