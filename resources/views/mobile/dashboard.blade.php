@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Dashboard
@endsection

@section('content')

<!-- Display Validation Errors -->
@include('common.errors')
<link rel="stylesheet" href="/vendor/filament-tablesaw/tablesaw.min.css?v2.2.0">
<style>
	.chart-pie-right.ct-chart .ct-series.ct-series-c .ct-slice-donut {
		stroke: #fdd448;
	}
	.chart-pie-right.ct-chart .ct-series.ct-series-b .ct-slice-donut {
		stroke: #e4eaec;
	}
	.chart-pie-right.ct-chart .ct-series.ct-series-a .ct-slice-donut {
		stroke: #46be8a;
	}
	#startChart .chart-pie-right.ct-chart .ct-series.ct-series-a .ct-slice-donut {
		stroke: #fdd448;
	}
	#currentChart .chart-pie-right.ct-chart .ct-series.ct-series-a .ct-slice-donut {
		stroke: #89bceb;
	}
	#goalChart .chart-pie-right.ct-chart .ct-series.ct-series-a .ct-slice-donut {
		stroke: #f96868;
	}
	#dashboard table{
		width: 100%;
		margin: 40px auto;
	}
	.chart-pie-right{
		margin: 0 auto;
	}
	.val{
		text-align: center;
		font-weight: bold;
	}
	#dashboard .table > tbody > tr > td{
		padding: 10px 20px;
	}
	.panel{
		padding: 30px;
	}
	.panel .panel-title{
		padding: 0 0 40px;
	}
	.page-content > .panel {
    	background-color: transparent;
	}
	.page-content > .panel > .panel-body{
		padding: 0px;
	}
	.chartTitle {
		font-size: 20px;
		margin-top: 40px;
		text-align: center;
		text-transform: uppercase;
	}
	table{
		border-radius: 10px;
	}
	.panel > .table-bordered{
		border: 1px solid #e4eaec;
	}
	#overview{
	}
	#overview td, #overview th, #results td,  #results th{
		padding: 10px;
	}
	#overview .table > thead > tr > th, #results .table > thead > tr > th{
		color: white;
	}
	#overview .table > tbody > tr > td span.label, #results .table > tbody > tr > td span.label{
		text-transform: uppercase;
		margin-right: 20px;
	}
	.highlightbox{
		padding: 10px 0;
		text-align: center;
	}
	.highlightbox h3{
		color: white;
		font-weight: 300;
		font-size: 36px;
	}
	.highlightbox h5{
		color: white;
		font-weight: 300;
		font-size: 16px;
		margin-bottom: 0px;
		text-transform: uppercase;
	}
	.hb-blue .panel{
		background-color: #63a8eb;
		margin-bottom: 0px;
	}
	.hb-purple .panel{
		background-color: #926dde;
		margin-bottom: 0px;
	}
	.highlightbox.last{
		margin-right: 0px;
		padding-bottom: 35px;
	}

	body .hamburger{
		display: block;
	}

	.panel{
		padding: 0px;
	}
	.panel .panel{
		padding: 30px;
	}

	.page-content {
	    padding: 15px 15px;
	}
</style>

<?php 

	$startLean = round($first->weight*(100-$first->body_fat)/100, 2);
	$startFat = round($first->weight*$first->body_fat/100, 2);
	
	$currentLean = round($current->weight*(100-$current->body_fat)/100, 2);
	$currentFat = round($current->weight*$current->body_fat/100, 2);
	
	$goalLean = $currentLean + $client->target_mg;
	$goalweight = round($goalLean / ((100 - $client->target_bf)/100), 2);
		
?>

<div class="col-lg-12 panel" id="dashboard">
	<div class="col-lg-4" id="startChart">
		<div class="ct-chart chart-pie-right width-250 height-250" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 40px;">{{ $first->body_fat }}%</span><br>{{ $first->weight }} lbs</div>
			</div>
		</div>
		<h3 class="chartTitle"> Start Of Program </h3>
		<table class="table table-bordered" cellpadding="10">
			<tbody>
				<tr>
					<td>Starting Weight</td>
					<td class="val">{{ $first->weight }}</td>
				</tr>
				<tr>
					<td>Starting Body Fat</td>
					<td class="val">{{ $first->body_fat }}%</td>
				</tr>
				<tr>
					<td>Lean Tissue Mass</td>
					<td class="val">{{ $startLean }} lbs</td>
				</tr>
				<tr>
					<td>Fat Mass</td>
					<td class="val">{{ $startFat }} lbs</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="col-lg-12 panel" id="dashboard">
	<div class="col-lg-4" id="currentChart">
		<div class="ct-chart chart-pie-right width-250 height-250" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 40px;">{{ $current->body_fat }}%</span><br>{{ $current->weight }} lbs</div>
			</div>
		</div>
		<h3 class="chartTitle"> Current </h3>
		<table class="table table-bordered" cellpadding="10">
			<tbody>
				<tr>
					<td>Current Weight</td>
					<td class="val">{{ $current->weight }}</td>
				</tr>
				<tr>
					<td>Current Body Fat</td>
					<td class="val">{{ $current->body_fat }}%</td>
				</tr>
				<tr>
					<td>Lean Tissue Mass</td>
					<td class="val">{{ $currentLean }} lbs</td>
				</tr>
				<tr>
					<td>Fat Mass</td>
					<td class="val">{{ $currentFat }} lbs</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="col-lg-12 panel" id="dashboard">
	<div class="col-lg-4" id="goalChart">
		<div class="ct-chart chart-pie-right width-250 height-250" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 40px;">{{ $client->target_bf }}%</span><br>{{ $goalweight }} lbs</div>
			</div>
		</div>
		<h3 class="chartTitle"> Goal </h3>
		<table class="table table-bordered" cellpadding="10">
			<tbody>
				<tr>
					<td>Goal Weight</td>
					<td class="val">{{ $goalweight }}</td>
				</tr>
				<tr>
					<td>Goal Body Fat</td>
					<td class="val">{{ $client->target_bf }}%</td>
				</tr>
				<tr>
					<td>Lean Tissue Mass</td>
					<td class="val">{{ $goalLean }} lbs</td>
				</tr>
				<tr>
					<td>Fat Mass</td>
					<td class="val">{{ $goalweight - $goalLean }} lbs</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
// If first week, skip section
if(count($trainingsessions) >= 2){
	$lastweek = $trainingsessions[count($trainingsessions)-2];
	$lastLean = round($lastweek->weight*(100-$lastweek->body_fat)/100, 2);
	$lastFat = round($lastweek->weight*$lastweek->body_fat/100, 2);

?>
<div class="col-lg-12 highlightbox hb-blue">
	<div class="panel">
		<h3>{{ abs($current->weight - $first->weight) + abs($currentLean - $startLean) }} lbs</h3>
		<h5> Total LBS of Change </h5>
	</div>
</div>
<div class="clearfix visible-md-block visible-lg-block hidden-xlg"></div>
<div class="col-lg-12 highlightbox hb-purple">
	<div class="panel">
		<h3>{{ round(abs($current->weight - $first->weight) / count($trainingsessions), 2) }} %</h3>
		<h5> Average % Change Per Week </h5>
	</div>
</div>
<div class="col-lg-12 highlightbox hb-blue last">
	<div class="panel">
	<?php
		$weeklyChange = round(abs($current->weight - $first->weight)+1 / count($trainingsessions), 2);
		$weeksLeft = ($current->body_fat - $client->target_bf) / $weeklyChange;
		$weeks = 'Weeks';
		if($weeksLeft <= 1 && $weeksLeft > 0){ $weeksLeft = 1; $weeks = 'Week'; }
		elseif($weeksLeft < 0){ $weeksLeft = 0; $weeks = 'Week'; }
		else{$weeksLeft = round($weeksLeft);}
	?>
		<h3>{{ $weeksLeft }}</h3>
		<h5> {{ $weeks }} Until Goal </h5>
	</div>
</div>	
<div class="col-lg-12 panel" id="overview">
	<h3 class="panel-title">OVERVIEW</h3>
	<table data-tablesaw-minimap="" data-tablesaw-mode="columntoggle" class="tablesaw table-striped table-bordered tablesaw-columntoggle" id="table-1102">
		<thead>
			<tr style="background-color: #3c3f48;">
				<th data-tablesaw-priority="persist">Stats</th>
				<th data-tablesaw-priority="1">Scale Weight</th>
				<th data-tablesaw-priority="2">Body Fat %</th>
				<th data-tablesaw-priority="3">Fat Loss</th>
				<th data-tablesaw-priority="4">Muscle Gain</th>
				<th data-tablesaw-priority="5">Pounds of Change</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Current Week</td>
				<td class="tablesaw-priority-1">{{ $current->weight }} lbs</td>
				<td class="tablesaw-priority-2">{{ $current->body_fat }}%</td>
				<td class="tablesaw-priority-3">{{ $currentFat - $lastFat }} lbs</td>
				<td class="tablesaw-priority-4">{{ $currentLean - $lastLean }} lbs</td>
				<td class="tablesaw-priority-5">{{ $current->weight - $lastweek->weight }} lbs</td>
			</tr>
			<tr>
				<td>Total Change</td>
				<td class="tablesaw-priority-1">{{ $current->weight - $first->weight  }} lbs</td>
				<td class="tablesaw-priority-2">{{ $current->body_fat - $first->body_fat  }}%</td>
				<td class="tablesaw-priority-3">{{ round($current->body_fat - $first->body_fat, 2)  }} lbs</td>
				<td class="tablesaw-priority-4">{{ $currentLean - $startLean  }} lbs</td>
				<td class="tablesaw-priority-5">{{ $current->weight - $first->weight }} lbs</td>
			</tr>
			<tr>
				<td>Goal</td>
				<td class="tablesaw-priority-1">{{ $goalweight }} lbs</td>
				<td class="tablesaw-priority-2">{{ $client->target_bf  }}%</td>
				<td class="tablesaw-priority-3">{{ ($goalweight - $goalLean) - $startFat  }} lbs</td>
				<td class="tablesaw-priority-4">{{ $client->target_mg  }} lbs</td>
				<td class="tablesaw-priority-5">{{ ($goalweight - $first->weight) + $client->target_mg }} lbs</td>
			</tr>
			<tr>
				<td>Remaining</td>
				<td class="tablesaw-priority-1">{{ $goalweight - $current->weight  }} lbs</td>
				<td class="tablesaw-priority-2">{{ $current->body_fat - $client->target_bf  }}%</td>
				<td class="tablesaw-priority-3">{{ (($goalweight - $goalLean) - $startFat) - ($current->body_fat - $first->body_fat) }} lbs</td>
				<td class="tablesaw-priority-4">{{ $client->target_mg - ($currentLean - $startLean)  }} lbs</td>
				<td class="tablesaw-priority-5">{{ (($goalweight - $first->weight) + $client->target_mg) - ($current->weight - $first->weight) }} lbs</td>
			</tr>
		</tbody>
	</table>
</div>
<?php
}
?>
<div class="col-lg-12 panel" id="results" style="display: none;">
	<h3 class="panel-title">RESULTS BY SESSION</h3>
	<table class="table table-bordered">
		<thead>
			<tr style="background-color: #3c3f48;">
				<th>Session</th>
				<th>Date</th>
				<th>Weight</th>
				<th>Body Fat %</th>
				<th>Lean Tissue</th>
				<th>Body Fat</th>
				<th>Scale Change</th>
				<th>% Change</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach($trainingsessions as $session){
			?>
			<tr>
				<td>{{ $session['session_number'] }}</td>
				<td>{{ $session['date'] }}</td>
				<td>{{ $session['weight'] }}</td>
				<td>{{ $session['body_fat'] }}%</td>
				<td>{{ round($session['weight']*(100-$session['body_fat'])/100, 2) }}</td>
				<td>{{ round($session['weight']*$session['body_fat']/100, 2) }}</td>
				<td><?php if($i==0){echo 'N/A';}else{ echo round($session['weight'] - $trainingsessions[$i-1]['weight'], 2);} ?></td>
				<td><?php if($i==0){echo 'N/A';}else{ echo $session['body_fat'] - $trainingsessions[$i-1]['body_fat'] . '%';} ?></td>
			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>
</div>

<script src="/vendor/sparkline/jquery.sparkline.min.js"></script>
<script src="/vendor/chartist-js/chartist.js"></script>
<script src="/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="/vendor/filament-tablesaw/tablesaw.js"></script>
<script src="/vendor/filament-tablesaw/tablesaw-init.js"></script>
<script>

var totalchart = new Chartist.Pie('#startChart .chart-pie-right', {
	series: [{{ 100-$first->body_fat }},{{ $first->body_fat }}]
	}, {
	donut: true,
	donutWidth: 10,
	startAngle: 0,
	showLabel: false
});
var totalchart = new Chartist.Pie('#currentChart .chart-pie-right', {
	series: [{{ 100-$current->body_fat }},{{ $current->body_fat }}]
	}, {
	donut: true,
	donutWidth: 10,
	startAngle: 0,
	showLabel: false
});
var totalchart = new Chartist.Pie('#goalChart .chart-pie-right', {
	series: [{{ 100-$client->target_bf }},{{ $client->target_bf }}]
	}, {
	donut: true,
	donutWidth: 10,
	startAngle: 0,
	showLabel: false
});

</script>

<a href="/user/{{ $client->id }}/dashboard/pdf" target="_blank"><button type="button" style="float: right; margin-right: 20px;" class="btn btn-primary">Download PDF</button></a>

@endsection