<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Nutrition Program
@endsection

@section('titleaction')
<h1 class="page-title" style="float: left;">&nbsp;- Session</h1> {!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
<!--  Determine if Latest session already has program --> 
@if(empty($latestsession->nutritionProgram['id']))
<a href="/user/{{ $client->id }}/copynutritionprogram/{{ $latestsession->id }}/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy To New Session</button></a>
@endif
@endsection

@section('formaction')
#
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

@if(!empty($session->nutritionProgram['id']))
	<link rel="stylesheet" href="/vendor/filament-tablesaw/tablesaw.min.css?v2.2.0">
	<style>
	.page-header{
		display: none;
	}
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
	.removemeal, .removeline, .addline, .addmeal, .save{
		display: none;
	}
	.counter-cal{
		display: none;
	}
	
	/* Mobile */

	.panel-body{
		padding: 0px;
	}
	.panel-body .panel-body{
		padding: 30px;
	}

	.page-content {
	    padding: 15px 15px;
	}

	body .hamburger{
		display: block;
	}

	</style>

	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body program-header">
				<h1>{{ $client->name }} - Nutrition Program Session {{$sessions[$session->id]}}</h1>
				<div class="titleright" style="float: right;">
					<!--  Determine if Latest session already has program --> 
					<div class="links">
						@foreach($sessions as $key => $val)
							@if($val == ($sessions[$session->id]-1))
								<a href="/user/{{$client->id}}/nutritionprogram/{{$key}}">
									<i class="icon wb-arrow-left" aria-hidden="true"></i>
								</a>
							@endif
							@if($val == ($sessions[$session->id]+1))
								<a href="/user/{{$client->id}}/nutritionprogram/{{$key}}">
									<i class="icon wb-arrow-right" aria-hidden="true"></i>
								</a>
							@endif
						@endforeach
					</div>
				</div> 
			</div>
		</div>
	</div>

	<style>
	.modal .modal-body .tab-content {
	    max-height: 620px;
	    overflow-y: auto;
	}
	</style>
	<?php
	if(!isset($template)){$template=array();}
	?>

	<form method="POST" action="@yield('formaction')" autocomplete="off" onsubmit="return validate(this);" id="nutritionform">
		<div class="col-sm-12">
			<div class="panel topdata">
				<div class="panel-body form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">Date: </label>
						<div class="col-sm-4">
							<input type="text" autocomplete="off" data-plugin="datepicker" placeholder="Current Date" name="date" class="form-control" value="{{ isset($session->NutritionProgram['date']) ? $session->NutritionProgram['date'] : date('m/d/Y') }}">
						</div>
						<label class="col-sm-2 control-label">Daily Water Intake: </label>
						<div class="col-sm-4">
							<input type="text" autocomplete="off" placeholder="Water Amount" name="water_intake" class="form-control" value="{{ isset($session->NutritionProgram['water_intake']) ? $session->NutritionProgram['water_intake'] : '' }}">
						</div>
					</div>
				</div>
			</div>
			<div class="panel templatedata" style="display: none;">
				<div class="panel-body form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">Template Name: </label>
						<div class="col-sm-4">
							<input type="text" autocomplete="off" placeholder="Template Name" name="templatename" class="form-control" value="{{ isset($template['name']) ? $template['name'] : '' }}">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix visible-md-block visible-lg-block"></div>
		
		<div class="col-lg-12">
			<div id="meals" class="">
			</div>
		</div>
		<div class="right" style="width: 270px; float: right; margin-right: 15px;">
			<div class="panel" style="float: left; margin-right: 15px;">
				<button style="text-align: center; padding: 15px;" onclick="templateModal()" data-original-title="Replace From Template" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addmeal" type="button">
					<i aria-hidden="true" class="icon wb-library"></i>
				</button>
			</div>
			<div class="panel" style="float: left; margin-right: 15px;">
				<button style="text-align: center; padding: 15px;" onclick="mealModal()" data-original-title="Add Built Meal" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addmeal" type="button">
					<i aria-hidden="true" class="icon wb-layout"></i>
				</button>
			</div>
			<div class="panel" style="float: left;">
				<button style="text-align: center; padding: 15px;" onclick="addMeal()" data-original-title="Add Meal" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addmeal" type="button">
					<i aria-hidden="true" class="icon wb-plus"></i>
				</button>
			</div>
			<button class="btn btn-primary save" onclick="needToConfirm = false;" style="float: right; height: 44px;" type="submit">Save Plan</button>
		</div>
		<div class="clearfix visible-md-block visible-lg-block"></div>

		<div class="col-sm-12" id="totals">
			<div class="panel">
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr style="background-color: #3c3f48;">
								<th>Calories</th>
								<th>Fats</th>
								<th>Carbs</th>
								<th>Proteins</th>
								<th width="150"></th>
							</tr>
						</thead>
						<tbody>
							<tr class="totals">
								<td><span id="totalcalories">0</span></td>
								<td><span id="totalfats">0</span></td>
								<td><span id="totalcarbs">0</span></td>
								<td><span id="totalproteins">0</span></td>
								<td>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="clearfix visible-md-block visible-lg-block"></div>
					<div class="col-lg-4" id="chartLineTime">
						<div class="ct-chart chart-pie-right width-200 height-200" style="position: relative; margin-top: 80px;">
							<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
								<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 40px;">0</span><br>Calories</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 printhide">
						<ul class="list-unstyled margin-bottom-0" style="margin-top: 80px;">
							<li class="counter-cal">
								<div class="counter counter-sm text-left">
									<div class="counter-number-group margin-bottom-10">
										<span class="counter-number-related">Calories - </span>
										<span class="counter-number">0</span>
										<span class="counter-number-related"></span>
									</div>
								</div>
								<div class="progress progress-xs">
									<div role="progressbar" style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" class="progress-bar progress-bar-info bg-blue-600">
										<span class="sr-only">0</span>
									</div>
								</div>
							</li>
							<li class="counter-fats">
								<div class="counter counter-sm text-left">
									<div class="counter-number-group margin-bottom-10">
										<span class="counter-number-related">Fats - </span>
										<span class="counter-number">30</span>
										<span class="counter-number-related">%</span>
									</div>
								</div>
								<div class="progress progress-xs">
									<div role="progressbar" style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" class="progress-bar progress-bar-info bg-yellow-600">
										<span class="sr-only">30%</span>
									</div>
								</div>
							</li>
							<li class="counter-pro">
								<div class="counter counter-sm text-left">
									<div class="counter-number-group margin-bottom-10">
										<span class="counter-number-related">Proteins - </span>
										<span class="counter-number">30</span>
										<span class="counter-number-related">%</span>
									</div>
								</div>
								<div class="progress progress-xs">
									<div role="progressbar" style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" class="progress-bar progress-bar-info bg-red-600">
										<span class="sr-only">30%</span>
									</div>
								</div>
							</li>
							<li class="counter-carb">
								<div class="counter counter-sm text-left">
									<div class="counter-number-group margin-bottom-10">
										<span class="counter-number-related">Carbs - </span>
										<span class="counter-number">30</span>
										<span class="counter-number-related">%</span>
									</div>
								</div>
								<div class="progress progress-xs margin-bottom-0 counter-carbs">
									<div role="progressbar" style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" class="progress-bar progress-bar-info bg-green-600">
										<span class="sr-only">30%</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
						<div class="col-lg-1" >
						</div>
						<div class="col-lg-4" >
							<textarea rows="3" id="programnotes" name="program_notes" class="form-control" placeholder="Program Notes:" style="height: 250px; margin-top: 100px;"><?php if(isset($session->NutritionProgram['program_notes'])){ echo $session->NutritionProgram['program_notes']; }else{ if(isset($template['program_notes'])){ echo $template['program_notes']; }}?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix visible-md-block visible-lg-block"></div>

		<div class="col-lg-12">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="hidden" name="session_id" value="<?php if(isset($newsession)){ echo $newsession; }elseif(isset($session->id)){ echo $session->id;} ?>">
				<input type="hidden" name="program_id" value="<?php if(isset($session->NutritionProgram['id'])){ echo $session->NutritionProgram['id'];}elseif(isset($template['id'])){ echo $template['id']; } ?>" >
				<input type="hidden" name="meals" id="mealsinput" value="">
				<button class="btn btn-primary save" style="float: right;" type="submit" onclick="needToConfirm = false;">Save Plan</button>
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
													<td><input type="text" style="text-align: center; float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $mc }}" /> {{ $ntr['portion_name'] }}</td>
													<td>{{ $ntr['calories'] }}</td>
													<td>{{ $ntr['fats'] }}</td>
													<td>{{ $ntr['carbs'] }}</td>
													<td>{{ $ntr['proteins'] }}</td>
													<td>
														<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $ntr['category'] }}'], {{ $mc }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
															<i aria-hidden="true" class="icon wb-plus"></i>
														</button>
													</td>
												</tr>
												<?php $mc++; ?>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
							@for ($i = 1; $i < (count($categories)+1); $i++)
							<div role="tabpanel" id="Tabs{{ $i }}" class="tab-pane">
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
													<td><input type="text" style="text-align: center; float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multiplier{{ $mc }}" /> {{ $ntr['portion_name'] }}</td>
													<td>{{ $ntr['calories'] }}</td>
													<td>{{ $ntr['fats'] }}</td>
													<td>{{ $ntr['carbs'] }}</td>
													<td>{{ $ntr['proteins'] }}</td>
													<td>
														<button data-original-title="Add" onclick="addNutrtion(['{{ addslashes($ntr['name']) }}', '{{ $ntr['portion_name'] }}', '{{ $ntr['calories'] }}', '{{ $ntr['fats'] }}', '{{ $ntr['carbs'] }}', '{{ $ntr['proteins'] }}', '{{ $categories[$i-1]['category'] }}'], {{ $mc }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
															<i aria-hidden="true" class="icon wb-plus"></i>
														</button>
													</td>
												</tr>
												<?php $mc++; ?>
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

	<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="addMeal" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg modal-center">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-label="Close" data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="exampleModalTabs" class="modal-title">Add Meal</h4>
				</div>
				<div class="modal-body">
					<?php echo '<script> var meals = ' . json_encode($meals) . ';</script>'; ?>
					<div id="meal-data-container"></div>
					<div id="meal-pagination-container"></div>
				</div>
			</div>
		</div>
	</div>

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
				<div class="modal-body" id="templates-div">
					<?php echo '<script> var templates = ' . json_encode($templates) . ';</script>'; ?>
					<div id="template-data-container"></div>
					<div id="template-pagination-container"></div>
				</div>
			</div>
		</div>
	</div>
	@endif

	<script>

	function templatesTemplate(data) {
	    var html = '\
	    <table class="table">\
			<thead>\
				<tr>\
					<th>Name</th>\
					<th>Actions</th>\
				</tr>\
			</thead>\
			<tbody>';
			    $.each(data, function(index, item){
			    	html += '\
			    	<tr>\
						<td>'+ item['name'] +'</td>\
						<td>\
							<button data-original-title="Use Template" onclick=\'importTemplate(temp' + index + ')\' data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">\
									<i aria-hidden="true" class="icon wb-plus"></i>\
							</button>\
						</td>\
					</tr>';
			    });
		html += '\
			</tbody>\
		</table>';
		return html;
	}

	function mealsTemplate(data) {
	    var html = '\
	    <table class="table">\
			<thead>\
				<tr>\
					<th>Name</th>\
					<th>Actions</th>\
				</tr>\
			</thead>\
			<tbody>';
			    $.each(data, function(index, item){
			    	html += '\
			    	<tr>\
						<td>'+ item['name'] +'</td>\
						<td>\
							<button data-original-title="Add Meal" onclick=\'addNewMeal(' + item['meal'] + ')\' data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">\
									<i aria-hidden="true" class="icon wb-plus"></i>\
							</button>\
						</td>\
					</tr>';
			    });
		html += '\
			</tbody>\
		</table>';
		return html;
	}

	$('#meal-pagination-container').pagination({
	    dataSource: meals,
	    callback: function(data, pagination) {
	        var html = mealsTemplate(data);
	        $('#meal-data-container').html(html);
	    }
	});

	$('#template-pagination-container').pagination({
	    dataSource: templates,
	    callback: function(data, pagination) {
	        var html = templatesTemplate(data);
	        $('#template-data-container').html(html);
	    }
	});




	</script>

	<script src="/vendor/sparkline/jquery.sparkline.min.js"></script>
	<script src="/vendor/chartist-js/chartist.js"></script>
	<script src="/vendor/matchheight/jquery.matchHeight-min.js"></script>
	<script src="/js/nutrition.program.js"></script>
	<script src="/vendor/filament-tablesaw/tablesaw.js"></script>
  	<script src="/vendor/filament-tablesaw/tablesaw-init.js"></script>
	
	<a href="/user/{{ $client->id }}/nutritionprogram/pdf/{{ $session->id }}" target="_blank"><button type="button" style="float: right; margin-right: 20px;" class="btn btn-primary">Download PDF</button></a>
	
	<script>

	var oldmeals = '{!! addslashes($session->NutritionProgram['meals']) !!}';
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
			addMobileMeal(newmeal);
			$.each(meal.items, function(i, item) {
				console.log(item);
				if(item != null){
					addMobileNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, meal.mealnum, item.mulipiler);
				}
			});
		});
	});
	
	$("#nutritionform :input").prop("disabled", true);

	</script>

@else
	<p> There is no Nutrition Program for this session.
	@if(Auth::user()->role == 'trainer')
	<!-- <a href="/user/{{ $client->id }}/newnutritionprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a><a href="/user/{{ $client->id }}/copynutritionprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy From Last Session</button></a> -->
	@endif
@endif

@endsection