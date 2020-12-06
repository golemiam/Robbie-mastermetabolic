@if(count($categories) == 0)
No Results Found
@else
<div class="nav-tabs-horizontal">
	<div class="tab-content">
		<div role="tabpanel">
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
							<?php $i = 0; ?>
							@foreach ($exercises as $exe)
							<tr>
								<td>{{ $exe['name'] }}</td>
								<td>
									<button data-original-title="Add" onclick="addExercise(['{{ $exe['name'] }}', '{{ $exe['portion_name'] }}', '{{ $exe['calories'] }}', '{{ $exe['fats'] }}', '{{ $exe['carbs'] }}', '{{ $exe['proteins'] }}', '{{ $exe['category'] }}'], {{ $i }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
										<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</td>
							</tr>
							<?php $i++; ?>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endif