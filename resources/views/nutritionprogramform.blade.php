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
			<!-- <div class="panel" id="meal1">
				<div role="tab" id="meal1label" class="panel-heading panel-title">
					<h4 style="float: left; margin-top: 8px;">Meal 1</h4>
					<input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="meal1name" placeholder="Meal Name" autocomplete="off">
					<input type="text" style="float:right; width: 90px;" class="form-control" id="meal1time" placeholder="Time" data-plugin="timepicker">
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
			</div> -->
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
							<th width="550">Totals</th>
							<th width="239"></th>
							<th>Calories</th>
							<th>Fats</th>
							<th>Carbs</th>
							<th>Proteins</th>
							<th width="150"></th>
						</tr>
					</thead>
					<tbody>
						<tr class="totals">
							<td></td>
							<td></td>
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
					<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
						<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
							<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 60px;">0</span><br>Calories</div>
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