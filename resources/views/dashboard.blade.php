@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Dashboard
@endsection

@section('content')

<!-- Display Validation Errors -->
@include('common.errors')

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
		width: 57%;
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
		padding-bottom: 0px;
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
		padding: 25px 0;
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
		margin-right: 20px;
	}
	.hb-purple .panel{
		background-color: #926dde;
		margin-bottom: 0px;
		margin-left: 20px;
		margin-right: 20px;
	}
	.highlightbox.last .panel{
		margin-right: 0px;
		margin-left: 20px;
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
	<h3 class="panel-title">CURRENT PROGRESS</h3>
	<div class="col-lg-4" id="startChart">
		<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 60px;">{{ $first->body_fat }}%</span><br>{{ $first->weight }} lbs</div>
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
	<div class="col-lg-4" id="currentChart">
		<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 60px;">{{ $current->body_fat }}%</span><br>{{ $current->weight }} lbs</div>
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
	<div class="col-lg-4" id="goalChart">
		<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
			<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
				<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="totalcal" style="font-size: 60px;">{{ $client->target_bf }}%</span><br>{{ $goalweight }} lbs</div>
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
<div class="col-lg-12 panel" id="overview">
	<h3 class="panel-title">OVERVIEW</h3>
	<table class="table table-bordered">
		<thead>
			<tr style="background-color: #3c3f48;">
				<th width="550">Stats</th>
				<th>Scale Weight</th>
				<th>Body Fat %</th>
				<th>Fat Loss</th>
				<th>Muscle Gain</th>
				<th>Pounds of Change</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Current Week</td>
				<td>{{ $current->weight }} lbs</td>
				<td>{{ $current->body_fat }}%</td>
				<td>{{ $currentFat - $lastFat }} lbs</td>
				<td>{{ $currentLean - $lastLean }} lbs</td>
				<td>{{ $current->weight - $lastweek->weight }} lbs</td>
			</tr>
			<tr>
				<td>Total Change</td>
				<td>{{ $current->weight - $first->weight  }} lbs</td>
				<td>{{ $current->body_fat - $first->body_fat  }}%</td>
				<td>{{ round($current->body_fat - $first->body_fat, 2)  }} lbs</td>
				<td>{{ $currentLean - $startLean  }} lbs</td>
				<td>{{ $current->weight - $first->weight }} lbs</td>
			</tr>
			<tr>
				<td>Goal</td>
				<td>{{ $goalweight }} lbs</td>
				<td>{{ $client->target_bf  }}%</td>
				<td>{{ ($goalweight - $goalLean) - $startFat  }} lbs</td>
				<td>{{ $client->target_mg  }} lbs</td>
				<td>{{ ($goalweight - $first->weight) + $client->target_mg }} lbs</td>
			</tr>
			<tr>
				<td>Remaining</td>
				<td>{{ $goalweight - $current->weight  }} lbs</td>
				<td>{{ $current->body_fat - $client->target_bf  }}%</td>
				<td>{{ (($goalweight - $goalLean) - $startFat) - ($current->body_fat - $first->body_fat) }} lbs</td>
				<td>{{ $client->target_mg - ($currentLean - $startLean)  }} lbs</td>
				<td>{{ (($goalweight - $first->weight) + $client->target_mg) - ($current->weight - $first->weight) }} lbs</td>
			</tr>
		</tbody>
	</table>
	<div class="col-lg-4 highlightbox hb-blue">
		<div class="panel">
			<h3>{{ abs($current->weight - $first->weight) + abs($currentLean - $startLean) }} lbs</h3>
			<h5> Total LBS of Change </h5>
		</div>
	</div>
	<div class="clearfix visible-md-block visible-lg-block hidden-xlg"></div>
	<div class="col-lg-4 highlightbox hb-purple">
		<div class="panel">
			<h3>{{ round(abs($current->weight - $first->weight) / count($trainingsessions), 2) }} %</h3>
			<h5> Average % Change Per Week </h5>
		</div>
	</div>
	<div class="col-lg-4 highlightbox hb-blue last">
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
</div>
<?php
}
?>
<div class="col-lg-12 panel" id="results">
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