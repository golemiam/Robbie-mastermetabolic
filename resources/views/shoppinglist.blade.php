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
<?php
$uitems = array();
$cats = array();
foreach($meals->meal as $meal){
	foreach($meal->items as $item){
		if(!in_array($item->category, $cats)){
			array_push($cats, $item->category);
		}
		$it = array($item->category, $item->name, $item->mulipiler, $item->portion_name);
		$found = 0;
		$i = 0;
		foreach($uitems as $ui){
			if($ui[1] == $item->name){
				$uitems[$i][2] += $item->mulipiler;
				$found = 1;
			}
			$i++;
		}
		if($found == 0){
			array_push($uitems, $it);
		}
	}
}
?>
<div id="header">
	<img style="margin-top: 10px;" src="http://dev.mastermetabolic.com/images/mm_logo.png">
	<div id="hcont">
		<p style="font-size: 20px;">Shopping List</p> 
		<p style="margin-bottom: -15px;">{{ $client->name }} - <span style="color: #F1C326;">{{ isset($session->NutritionProgram['date']) ? $session->NutritionProgram['date'] : date('m/d/Y') }}</span></p>
	</div>
</div>
<br>
<div id="meals" class="">
	@foreach($cats as $cat)
	<div class="meal">
		<div role="tab" id="meal1label" class="panel-heading panel-title">
			<p class="headlable mealname">{{ $cat }}</p>
			<p class="headlable time">&nbsp;</p>
		</div>
		<div role="tabpanel" id="meal1panel">
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr style="background-color: #3c3f48;">
							<th width="250">Food Name</th>
							<th width="100">Portion</th>
						</tr>
					</thead>
					<tbody>
					
						@foreach($uitems as $item)
							@if($item[0] == $cat)
								<tr><td>{{ $item[1] }}</td><td> {{ $item[2]*7 }} {{ $item[3] }}</td></tr>
							@endif
						@endforeach
					
					</tbody>
				</table>
			</div>
		</div>
	@endforeach
	</div>
</div>
<div class="clearfix visible-md-block visible-lg-block"></div>