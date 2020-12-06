<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Edit Nutrition Program Template
@endsection

@section('titleaction')
@endsection

@section('formaction')
/settings/editnutritiontemplate/{{ $template->id }}
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

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
		margin-top: 50px;
	}
	#chartLineTime .chart-pie-right.ct-chart .ct-series.ct-series-c .ct-slice-donut {
		stroke: #46be8a;
	}
	#chartLineTime .chart-pie-right.ct-chart .ct-series.ct-series-b .ct-slice-donut {
		stroke: #f96868;
	}
	#chartLineTime .chart-pie-right.ct-chart .ct-series.ct-series-a .ct-slice-donut {
		stroke: #fdd448;
	}
	.counter-cal{
		display: none;
	}
	
	.topdata{
		display: none;
	}
	.templatedata{
		display: block !important;
	}

	</style>

	@include('nutritionprogramform')

	<script>

	var oldmeals = '{!! addslashes($template['mealtemplate']) !!}';
	mealcount = 0;
	$.each($.parseJSON(oldmeals), function(i, omeals) {
		$.each(omeals, function(i, meal) {
			var newmeal = {
				mealnum: meal.mealnum,
				name: meal.name,
				linecount: 0,
				items: [],
				notes: meal.notes,
				time: meal.time
			};
			addMeal(newmeal);
			$.each(meal.items, function(i, item) {
				console.log(item);
				if(item != null){
					addNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, meal.mealnum, item.mulipiler);
				}
			});
		});
	});
	
	</script>
	
	@if(isset($templates))
	<script>
	<?php
	$i = 0;
	foreach($templates as $template){
		echo "var temp".$i." = '".addslashes($template['mealtemplate'])."';\n";
		$i++;
	}
	?>
	</script>
	<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="templates" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg modal-center">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-label="Close" data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="exampleModalTabs" class="modal-title">Import Template</h4>
				</div>
				<div class="modal-body">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach($templates as $template){
							?>
							<tr>
								<td>{{ $template['name'] }}</td>
								<td>
									<button data-original-title="Use Template" onclick='importTemplate(temp{{$i}})' data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</td>
							</tr>
							<?php
							$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endif


@endsection