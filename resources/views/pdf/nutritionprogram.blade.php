	<!-- -->

<?php 
$meals = json_decode($session->NutritionProgram['meals']);
?>

<title>{{ $client->name }} Nutrition Program</title>

<style>

@page { margin: 25px; }
body { margin: 0px; }

*{
	font-family: 'Roboto', sans-serif;
}
td {
	padding: 5px;
}
table{
	font-size: 11px;
	text-align: center;
	width: 100%;
	margin-top: -10px;
}
th{
	color: white;
	font-weight: 400;
	padding: 8px;
	text-transform: uppercase;
	font-size: 9px;
	
}
#meals{
	width: 100%;
}
#header{
	padding: 25px;
	background-color: #333335;
	font-size: 9px;
	font-weight: normal;
}
#header img{
	float: left;
}
.meal{
	margin-top: -10px;
}
#hcont{
	margin-top: -50px;
	text-align: right;
	color: white;
	font-size: 9px;
}
.headlable{
	font-weight: bold;
	margin-left: 5px;
	font-size: 14px;
}
hr{
	height: 1px;
	background-color: #A2A1A2;
	border: none;
	margin-top: -10px;
}
.aleft{
	text-align: left;
}
.time{
	text-align: right;
	margin-top: -15px;
	font-size: 14px;
}
.mealname{
	margin-bottom: -20px;
}
.totals{
	font-weight: 400;
	padding: 10px;
	text-transform: uppercase;
	font-size: 9px;
	background-color: #EDEDED;
}
.totals td{
	padding: 8px;
}
textarea{
	width: 50%;
	margin-top: 10px;
	margin-bottom: 10px;
	font-size: 11px;
}
.cat{
}
#totals table{
	margin-top: 20px;
}
#totals th{
	border-bottom: 1px solid black;
}
#totals th, #totals .totals td {
	background-color: white;
	color: black;
}
</style>
<div id="header">
	<img style="margin-top: -15px;" src="{{ url('/images/mm_logo.png') }}">	
	<div id="hcont">
		<p style="font-size: 20px; margin-top: 30px;">Nutrition Program</p> 
		<p style="margin-bottom: -15px;">{{ $client->name }} - <span style="color: #F1C326;">{{ isset($session->NutritionProgram['date']) ? $session->NutritionProgram['date'] : date('m/d/Y') }}</span></p>
	</div>
</div>
<p class="headlable">Daily Water Intake: {{ isset($session->NutritionProgram['water_intake']) ? $session->NutritionProgram['water_intake'] : '' }}</p>
<hr>
<div id="meals" class="">
	<?php $totals = array(
		'cal' => 0,
		'fats' => 0,
		'carb' => 0,
		'pro' => 0,
	); ?>
	@foreach($meals->meal as $meal)
	<div class="meal">
		<div role="tab" id="meal1label" class="panel-heading panel-title">
			<p class="headlable mealname">Meal {{ $meal->mealnum }}: {{ $meal->name }}</p>
			<p class="headlable time">{{ $meal->time }}</p>
		</div>
		<div role="tabpanel" id="meal1panel">
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr style="background-color: #3c3f48;">
							<th width="41">Category</th>
							<th class="aleft" width="200">Food Name</th>
							<th>Portion</th>
							<th>Calories</th>
							<th>Fats</th>
							<th>Carbs</th>
							<th>Proteins</th>
						</tr>
					</thead>
					<tbody>
						<?php $mealtotals = array(
							'cal' => 0,
							'fats' => 0,
							'carb' => 0,
							'pro' => 0,
						); ?>
						@foreach($meal->items as $item)
						<tr>
							<td ><span class="cat">{{ $item->category }}</span></td>
							<td class="aleft" >{{ $item->name }}</td>
							<td>{{ $item->mulipiler }} {{ $item->portion_name }}</td>
							<td>{{ $item->calories }}</td>
							<td>{{ $item->fats }}</td>
							<td>{{ $item->carbs }}</td>
							<td>{{ $item->proteins }}</td>
						</tr>
						<?php
							$mealtotals['cal'] += $item->calories;
							$mealtotals['fats'] += $item->fats;
							$mealtotals['carb'] += $item->carbs;
							$mealtotals['pro'] += $item->proteins;
						?>
						@endforeach
						<?php
							$totals['cal'] += $mealtotals['cal'];
							$totals['fats'] += $mealtotals['fats'];
							$totals['carb'] += $mealtotals['carb'];
							$totals['pro'] += $mealtotals['pro'];
							$count = $mealtotals['fats'] + $mealtotals['carb'] + $mealtotals['pro'];
						?>
						<tr class="totals">
							<td>Totals</td>
							<td></td>
							<td></td>
							<td><strong>{{ $mealtotals['cal'] }}</strong></td>
							<td><strong>{{ $mealtotals['fats'] }} ({{ round(($mealtotals['fats']/$count) * 100) }}%)</strong></td>
							<td><strong>{{ $mealtotals['carb'] }} ({{ round(($mealtotals['carb']/$count) * 100) }}%)</strong></td>
							<td><strong>{{ $mealtotals['pro'] }} ({{ round(($mealtotals['pro']/$count) * 100) }}%)</strong></td>
						</tr>
					</tbody>
				</table>
				<div class="col-lg-6" style="padding-left: 0px;">
					<?php if(!empty($meal->notes)){ echo '<p style="width:500px; padding: 6px; border: 1px solid black; font-size: 10px;">'.$meal->notes."</p>"; } ?>
				</div>
			</div>
		</div>
	</div> 
	@endforeach
</div>
<div class="clearfix visible-md-block visible-lg-block"></div>
<?php
	$totalCount = $totals['fats'] + $totals['carb'] + $totals['pro'];
?>
<div class="col-sm-12" id="totals">
	<div class="panel">
		<div class="panel-body">
			<table class="table">
				<thead>
					<tr style="background-color: #3c3f48;">
						<th width="41">Totals</th>
						<th width="200"> </th>
						<th width="46"> </th>
						<th>Calories</th>
						<th>Fats</th>
						<th>Carbs</th>
						<th>Proteins</th>
					</tr>
				</thead>
				<tbody>
					<tr class="totals">
						<td></td>
						<td></td>
						<td></td>
						<td><span id="totalcalories"><strong>{{ $totals['cal'] }}</strong></span></td>
						<td><span id="totalfats"><strong>{{ $totals['fats'] }} ({{ round(($totals['fats']/$totalCount) * 100) }}%)</strong></span></td>
						<td><span id="totalcarbs"><strong>{{ $totals['carb'] }} ({{ round(($totals['carb']/$totalCount) * 100) }}%)</strong></span></td>
						<td><span id="totalproteins"><strong>{{ $totals['pro'] }} ({{ round(($totals['pro']/$totalCount) * 100) }}%)</strong></span></td>
					</tr>
				</tbody>
			</table>
			<div class="clearfix visible-md-block visible-lg-block"></div>
				<div class="col-lg-4" >
					<p style="width:500px; padding: 6px; border: 1px solid black; font-size: 10px;">{{ isset($session->NutritionProgram['program_notes']) ? $session->NutritionProgram['program_notes'] : '' }}</p>
				</div>
			</div>
		</div>
	</div>
</div>