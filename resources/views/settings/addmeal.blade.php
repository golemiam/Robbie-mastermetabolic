<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Add New Meal
@endsection

@section('content')
<style>
	.page-content > .panel{
		background-color: transparent;
	}
	table{
		border-radius: 10px;
	}
	#meals .table > thead > tr > th, #totals .table > thead > tr > th{
		color: white;
	}
	#meals .table > tbody > tr > td span.label{
		text-transform: uppercase;
		margin-right: 20px;
	}
	.panel-heading a{
		color: #3c3f48;
		font-weight: bold;
		font-size: 18px;
		font-family: "Open Sans";
	}
	.totals span{
		font-weight: bold;
	}
	.removemeal{
		display: none;
	}

	.modal .modal-body {
		max-height: 620px;
		overflow-y: auto;
	}
</style>

<form method="POST" action="/settings/meals" autocomplete="off" onsubmit="return validate(this);" id="nutritionform">
	<div class="col-lg-12">
		<div id="meals" class="">
			<div class="panel" id="meal1">
				<div role="tab" id="meal1label" class="panel-heading panel-title">
					<h4 style="float: left; margin-top: 8px;">Meal 1</h4>
					<input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="meal1name" placeholder="Meal Name" autocomplete="off">
				</div>
				<div role="tabpanel" id="meal1panel">
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr style="background-color: #3c3f48;">
									<th width="550">Food Name</th>
									<th>Portion Size</th>
									<th>Calories</th>
									<th>Fats</th>
									<th>Carbs</th>
									<th>Proteins</th>
									<th width="41"></th>
								</tr>
							</thead>
							<tbody>
								<tr class="totals">
									<td>Totals</td>
									<td></td>
									<td><span id="totalmeal1calories">0</span></td>
									<td><span id="totalmeal1fats">0</span></td>
									<td><span id="totalmeal1carbs">0</span></td>
									<td><span id="totalmeal1proteins">0</span></td>
									<td>
										<button style="float: right;" onclick="openModal(1)" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addline" type="button">
											<i aria-hidden="true" class="icon wb-plus"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="col-lg-6" style="padding-left: 0px;">
							<textarea rows="3" id="meal1notes" class="form-control" placeholder="Notes"></textarea>
						</div>
						<div class="col-lg-6" style="padding-right: 0px;">
							<button onclick="removeMeal(1);" style="float: right;" data-original-title="Delete Meal" data-toggle="tooltip" class="removemeal btn btn-sm btn-icon btn-flat btn-default" type="button">
								<i aria-hidden="true" class="icon wb-trash"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<input type="hidden" name="meal" id="mealsinput" value="">
			<input type="hidden" name="name" id="nameinput" value="">
			<button class="btn btn-primary save" style="float: right;" type="submit">Save Meal</button>
		</div>
	</div>
</form>
<?php $mc = 0; ?>
<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="addNutrition" class="modal fade" style="display: none;">
	<div class="modal-dialog modal-lg modal-center">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<h4 id="exampleModalTabs" class="modal-title">Add Nutrition Source</h4>
				<div class="col-lg-3" style="margin-top: 20px;">
					<input type="text" placeholder="Search" id="search" class="form-control"/>
				</div>
				<div class="col-lg-1" style="margin-top: 20px;">
					<button class="btn btn-primary" onclick="searchNut('{{ csrf_token() }}')">Submit</button>
				</div>
			</div>
			<div class="modal-body">
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
											@foreach ($nutritions as $ntr)
											@if ($ntr['favorite'] == 1)
											<tr>
												<td>{{ $ntr['name'] }}</td>
												<td><select style="float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $i }}"> <option>.25</option> <option>.50</option> <option>.75</option> <option selected>1</option> <option>1.25</option> <option>1.5</option><option>1.75</option><option>2</option><option>2.5</option> <option>3</option> <option>3.5</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> <option>9</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option> </select>{{ $ntr['portion_name'] }}</td>
												<td>{{ $ntr['calories'] }}</td>
												<td>{{ $ntr['fats'] }}</td>
												<td>{{ $ntr['carbs'] }}</td>
												<td>{{ $ntr['proteins'] }}</td>
												<td>
													<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $ntr['category'] }}'], {{ $i }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
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
												<td><select style="float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $i }}"> <option>.25</option> <option>.50</option> <option>.75</option> <option selected>1</option> <option>1.25</option> <option>1.5</option><option>1.75</option><option>2</option><option>2.5</option> <option>3</option> <option>3.5</option> <option>4</option> <option>5</option> <option>6</option> <option>7</option> <option>8</option> <option>9</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option> </select>{{ $ntr['portion_name'] }}</td>
												<td>{{ $ntr['calories'] }}</td>
												<td>{{ $ntr['fats'] }}</td>
												<td>{{ $ntr['carbs'] }}</td>
												<td>{{ $ntr['proteins'] }}</td>
												<td>
													<button data-original-title="Add" onclick="addNutrtion(['{{ $ntr['name'] }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $categories[$i-1]['category'] }}'], {{ $i }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
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
			</div>
		</div>
	</div>
</div>

<script src="/js/meals.js"></script>

<script>

var meal1 = {
	mealnum: 1,
	name: '',
	linecount: 0,
	items: [],
	time: '',
};

addMeal(meal1);

</script>

@endsection