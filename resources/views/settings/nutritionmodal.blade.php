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
								<th>Portion Size</th>
								<th>Calories</th>
								<th>Fats</th>
								<th>Carbs</th>
								<th>Proteins</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($nutritions as $ntr)
								<tr>
									<td>{{ $ntr['name'] }}</td>
									<td><select style="float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $i }}"> <option>.25</option> <option>.33</option> <option>.50</option> <option>.75</option> <option selected>1</option> <option>1.25</option> <option>1.5</option><option>1.75</option><option>2</option><option>2.5</option> <option>3</option> <option>3.5</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> <option>9</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option> </select>{{ $ntr['portion_name'] }}</td>
									<td>{{ $ntr['calories'] }}</td>
									<td>{{ $ntr['fats'] }}</td>
									<td>{{ $ntr['carbs'] }}</td>
									<td>{{ $ntr['proteins'] }}</td>
									<td>
										<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $ntr['category'] }}'], {{$i}})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
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