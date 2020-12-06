<!-- -->

<?php 
$meals = json_decode($session->ExerciseProgram['circuits']);
?>

<title>{{ $client->name }} Exercise Program</title>

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
		<p style="font-size: 20px; margin-top: 30px;">Exercise Program</p> 
		<p style="margin-bottom: -15px;">{{ $client->name }} - <span style="color: #F1C326;">{{ isset($session->ExerciseProgram['date']) ? $session->ExerciseProgram['date'] : date('m/d/Y') }}</span></p>
	</div>
</div>
<br>
<div id="meals" class="">
	@foreach($meals->circuit as $meal)
	<div class="meal">
		<div role="tab" id="meal1label" class="panel-heading panel-title">
			<p class="headlable mealname">Circuit {{ $meal->circuitnum }}: {{ $meal->name }}</p>
			<p class="headlable time">{{ $meal->time }} {{ $meal->time == 1 ? 'Time' : 'Times' }} Per Week</p>
		</div>
		<div role="tabpanel" id="meal1panel">
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr style="background-color: #3c3f48;">
							<th width="41">Type</th>
							<th class="aleft" width="200">Exercise Name</th>
							<th>Sets</th>
							<th>Reps</th>
							<th>Speed</th>
							<th>Weight</th>
						</tr>
					</thead>
					<tbody>
						@foreach($meal->items as $item)
						<tr>
							<td ><span class="cat">{{ $item->category }}</span></td>
							<td class="aleft" >{{ $item->name }}</td>
							<td>{{ $item->sets }}</td>
							<td>{{ $item->reps }}</td>
							<td>{{ $item->speed }}</td>
							<td>{{ $item->weight }}</td>
						</tr>
						@endforeach
						<tr class="totals">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<div class="col-lg-6" style="padding-left: 0px;">
					<?php if(!empty($meal->notes)){ echo "<textarea rows='3'>".$meal->notes."</textarea>"; } ?>
				</div>
			</div>
		</div>
	</div> 
	@endforeach
</div>
<div class="clearfix visible-md-block visible-lg-block"></div>
<hr>
<textarea rows="3" id="programnotes" name="program_notes" class="form-control" placeholder="Program Notes:">{{ isset($session->NutritionProgram['program_notes']) ? $session->NutritionProgram['program_notes'] : '' }}</textarea>