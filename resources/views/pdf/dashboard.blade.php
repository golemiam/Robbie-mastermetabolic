<?php 

	$startLean = round($first->weight*(100-$first->body_fat)/100, 2);
	$startFat = round($first->weight*$first->body_fat/100, 2);
	
	$currentLean = round($current->weight*(100-$current->body_fat)/100, 2);
	$currentFat = round($current->weight*$current->body_fat/100, 2);
	
	$goalLean = $currentLean + $client->target_mg;
	$goalweight = round($goalLean / ((100 - $client->target_bf)/100), 2);
		
?>

<style>
@page { margin: 25px; }
body { margin: 0px; }

*{
	font-family: 'Roboto', sans-serif;
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
	padding: 4px;
	text-transform: uppercase;
	font-size: 9px;
}
hr{
	height: 1px;
	background-color: #A2A1A2;
	border: none;
	margin-top: -10px;
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
#hcont{
	margin-top: -50px;
	text-align: right;
	color: white;
	font-size: 9px;
}
.headlable, h3{
	font-weight: bold;
	margin-left: 5px;
	font-size: 12px;
}
#totalcal{
	font-weight: normal;
	font-size: 42px;
}
.titleg{
	padding: 10px;
	background-color: #EFEFEF;
	text-align: center;
}
.val{
	padding: 0px;
	text-align: left;
}
.tableh th{
	padding: 4px;
}
.tablem td{
	width: 100px;
}
.tableh{
	text-align: right;
}
</style>
<div id="header">
	<img style="margin-top: -15px;" src="{{ url('/images/mm_logo.png') }}">
	<div id="hcont">
		<p style="font-size: 20px; margin-bottom: -20px;">Result Dashboard</p>
		<p style="margin-bottom: -15px;">{{$client->name}} - <span style="color: #F1C326;">{{ date('m/d/Y') }}</span></p>
	</div>
</div>
<br>
<div class="col-lg-12 panel" id="dashboard">
	<h3 class="panel-title">DASHBOARD</h3>
	<table class="table table-bordered tablem" cellpadding="10">
		<tr>
			<td>
				<table class="table table-bordered tableh" cellpadding="">
					<tbody>
						<tr style="background-color: #3c3f48;">
							<th colspan="2">Start Of Program</th>
						</tr>
						<tr>
							<td colspan="2" class="titleg"><span id="totalcal">{{ $first->body_fat }}%</span></td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td><strong>Starting Weight:&nbsp;&nbsp;&nbsp;</strong></td>
							<td class="val"><strong>{{ $first->weight }}</strong></td>
						</tr>
						<tr>
							<td>Lean Tissue Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $startLean }} lbs</td>
						</tr>
						<tr>
							<td>Fat Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $startFat }} lbs</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table class="table table-bordered tableh" cellpadding="">
					<tbody>
						<tr style="background-color: #3c3f48;">
							<th colspan="2">Current</th>
						</tr>
						<tr>
							<td colspan="2" class="titleg"><span id="totalcal">{{ $current->body_fat }}%</span></td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td><strong>Current Weight:&nbsp;&nbsp;&nbsp;</strong></td>
							<td class="val"><strong>{{ $current->weight }}</strong></td>
						</tr>
						<tr>
							<td>Lean Tissue Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $currentLean }} lbs</td>
						</tr>
						<tr>
							<td>Fat Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $currentFat }} lbs</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table class="table table-bordered tableh" cellpadding="">
					<tbody>
						<tr style="background-color: #3c3f48;">
							<th colspan="2">Goal</th>
						</tr>
						<tr>
							<td colspan="2" class="titleg"><span id="totalcal">{{ $client->target_bf }}%</span></td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td><strong>Goal Weight:&nbsp;&nbsp;&nbsp;</strong></td>
							<td class="val"><strong>{{ $goalweight }}</strong></td>
						</tr>
						<tr>
							<td>Lean Tissue Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $goalLean }} lbs</td>
						</tr>
						<tr>
							<td>Fat Mass:&nbsp;&nbsp;&nbsp;</td>
							<td class="val">{{ $goalweight - $goalLean }} lbs</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
</div>
<?php
// If first week, skip section
if(count($trainingsessions) >= 2){
	$lastweek = $trainingsessions[count($trainingsessions)-2];
	$lastLean = round($lastweek->weight*(100-$lastweek->body_fat)/100, 2);
	$lastFat = round($lastweek->weight*$lastweek->body_fat/100, 2);

?>
<div class="col-lg-12 panel" id="overview">
	<h3 class="panel-title">CURRENT STATUS & GOAL</h3>
	<table class="table table-bordered" cellpadding="4">
		<thead>
			<tr style="background-color: #3c3f48;">
				<th width="">Stats</th>
				<th>Scale Weight</th>
				<th>Body Fat %</th>
				<th>Fat Loss</th>
				<th>Muscle Gain</th>
				<th>Pounds of Change</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><strong>Current Week</strong></td>
				<td>{{ $current->weight }} lbs</td>
				<td>{{ $current->body_fat }}%</td>
				<td>{{ $currentFat - $lastFat }} lbs</td>
				<td>{{ $currentLean - $lastLean }} lbs</td>
				<td>{{ $current->weight - $lastweek->weight }} lbs</td>
			</tr>
			<tr>
				<td><strong>Total Change</strong></td>
				<td>{{ $current->weight - $first->weight  }} lbs</td>
				<td>{{ $current->body_fat - $first->body_fat  }}%</td>
				<td>{{ round($current->body_fat - $first->body_fat, 2)  }} lbs</td>
				<td>{{ $currentLean - $startLean  }} lbs</td>
				<td>{{ $current->weight - $first->weight }} lbs</td>
			</tr>
			<tr>
				<td><strong>Goal</strong></td>
				<td>{{ $goalweight }} lbs</td>
				<td>{{ $client->target_bf  }}%</td>
				<td>{{ ($goalweight - $goalLean) - $startFat  }} lbs</td>
				<td>{{ $client->target_mg  }} lbs</td>
				<td>{{ ($goalweight - $first->weight) + $client->target_mg }} lbs</td>
			</tr>
			<tr>
				<td><strong>Remaining</strong></td>
				<td>{{ $goalweight - $current->weight  }} lbs</td>
				<td>{{ $current->body_fat - $client->target_bf  }}%</td>
				<td>{{ (($goalweight - $goalLean) - $startFat) - ($current->body_fat - $first->body_fat) }} lbs</td>
				<td>{{ $client->target_mg - ($currentLean - $startLean)  }} lbs</td>
				<td>{{ (($goalweight - $first->weight) + $client->target_mg) - ($current->weight - $first->weight) }} lbs</td>
			</tr>
		</tbody>
	</table>
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
