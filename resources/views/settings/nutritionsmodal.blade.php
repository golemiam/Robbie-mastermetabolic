@if(count($categories) == 0)
No Results Found
@else
<div class="nav-tabs-horizontal">
	<ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs">
		<li role="presentation" class="active"><a role="tab" aria-controls="Tabs0" href="#Tabs0" data-toggle="tab" aria-expanded="true">Favorites</a></li> 
		@for ($i = 1; $i < (count($categories)+1); $i++)
			<li role="presentation" {{ $i == 0 ? 'class=active' : '' }}><a role="tab" aria-controls="Tabs{{ $i }}" href="#Tabs{{ $i }}" data-toggle="tab" aria-expanded="true">{{ $categories[$i-1]['category'] }}</a></li> 
		@endfor
	</ul>
	<div class="tab-content">
		<div role="tabpanel" id="Tabs0" class="tab-pane active">
			<div class="col-md-12">
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
							<?php $ic = 0; ?>
							@foreach ($nutritions as $ntr)
							@if ($ntr['favorite'] == 1)
							<tr>
								<td>{{ $ntr['name'] }}</td>
								<td><input type="text" style="text-align: center; float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $ic }}" /> {{ $ntr['portion_name'] }}</td>
								<td>{{ $ntr['calories'] }}</td>
								<td>{{ $ntr['fats'] }}</td>
								<td>{{ $ntr['carbs'] }}</td>
								<td>{{ $ntr['proteins'] }}</td>
								<td>
									<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $ntr['category'] }}'], {{ $ic }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
										<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</td>
							</tr>
							<?php $ic++; ?>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
		@for ($i = 1; $i < (count($categories)+1); $i++)
		<div role="tabpanel" id="Tabs{{ $i }}" class="tab-pane {{ $i == 0 ? 'active' : '' }}">
			<div class="col-md-12">
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
							@if ($ntr['category'] == $categories[$i-1]['category'])
								<tr>
									<td>{{ $ntr['name'] }}</td>
									<td><input type="text" style="text-align: center; float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $ic }}" /> {{ $ntr['portion_name'] }}</td>
									<td>{{ $ntr['calories'] }}</td>
									<td>{{ $ntr['fats'] }}</td>
									<td>{{ $ntr['carbs'] }}</td>
									<td>{{ $ntr['proteins'] }}</td>
									<td>
										<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $ntr['category'] }}'], {{ $ic }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-plus"></i>
										</button>
									</td>
								</tr>
							<?php $ic++; ?>
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