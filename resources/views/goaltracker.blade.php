@extends('layouts.dashboard')

@section('pagetitle')
Goal Tracker
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
		float: right;
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
	.calc{
		margin-right: 10px;
	}
</style>
<form action="#">
	<div class="col-sm-12">
		<div class="panel">
			<h4 class="example-title">Client Info</h4>
			<div class="panel-body form-horizontal">
				<div class="form-group">
					<label class="col-sm-1 control-label">Client Name: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Client Name" name="name" class="form-control" >
					</div>
					<label class="col-sm-1 control-label">Date: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" data-plugin="datepicker" placeholder="Current Date" name="date" class="form-control" value="{{date('m/d/Y')}}" >
					</div>

					<label class="col-sm-1 control-label">Weight: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Starting Weight" name="weight" id="weight" class="form-control" >
					</div>
					<label class="col-sm-1 control-label">Body Fat %: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Starting Body Fat %" name="body_fat" id="body_fat" class="form-control" >
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="panel">
			<h4 class="example-title">Goals</h4>
			<div class="panel-body form-horizontal">
				<div class="form-group">
					<label class="col-sm-1 control-label">Body Fat %: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Goal Body Fat %" id="gbody_fat" name="water_intake" class="form-control" >
					</div>
					<label class="col-sm-1 control-label">Muscle Gain: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Goal Muscle Gain" name="water_intake" id="ggain" class="form-control" >
					</div>

					<label class="col-sm-1 control-label">Weeks: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Weeks Committed" name="water_intake" id="weeks" class="form-control" disabled>
					</div>
					<label class="col-sm-1 control-label">% Change: </label>
					<div class="col-sm-2">
						<input type="text" autocomplete="off" placeholder="Average Weekly % Changed" name="water_intake" id="avechange" class="form-control" value=".8">
					</div>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary calc" style="float: right;" onclick="showTotals()" type="button">Calculate Totals</button>
	<div class="clearfix visible-md-block visible-lg-block"></div>
	<div class="col-lg-12" id="dashboard" style="display: none;">
		<div class="panel">
			<div class="panel-body form-horizontal">
				<div class="col-lg-4" id="startChart">
					<h3 class="chartTitle"> Starting </h3>
					<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
						<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
							<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="bodyper" style="font-size: 60px;">30%</span><br><span id="pounds">200 lbs</span></div>
						</div>
					</div>
				</div>
				<div class="col-lg-4" id="currentChart">
					<h3 class="chartTitle"> Goal </h3>
					<div class="ct-chart chart-pie-right width-350 height-350" style="position: relative;">
						<div class="vertical-align text-center" style="height:100%; width:100%; position:absolute; left:0; top:0;">
							<div class="font-size-20  vertical-align-middle" style="line-height:1.1 "><span id="gbodyper" style="font-size: 60px;">30%</span><br><span id="gpounds">200 lbs</span></div>
						</div>
					</div>
				</div>
				<br>
				<div class="col-lg-3 highlightbox hb-purple">
					<div class="panel">
						<h3 id="aveper">.5%</h3>
						<h5> Average % Change Per Week </h5>
					</div>
				</div>	
				<div class="col-lg-3 highlightbox hb-blue">
					<div class="panel">
						<h3 id="totalpoc">30 lbs</h3>
						<h5> Total Pounds of Change </h5>
					</div>
				</div>	
			</div>
		</div>
	</div>
	<div class="col-sm-12" id="pricing" style="display: none;">
		<div class="panel">
			<h4 class="example-title">Results</h4>
			<div class="panel-body form-horizontal">
				<div class="form-group">
					<label class="col-sm-1 control-label">Session Price: </label>
					<div class="col-sm-3">
						<div class="input-group"><span class="input-group-addon">$</span><input type="text" autocomplete="off" id="sessionprice" placeholder="Session Price" name="water_intake" class="form-control" value="{{ isset(Auth::user()->session_price) ? Auth::user()->session_price : '' }}"></div>
					</div>
					<label class="col-sm-1 control-label">Sessions: </label>
					<div class="col-sm-3">
						<input type="text" autocomplete="off" placeholder="Total Sessions" id="totalsessions" name="water_intake" class="form-control" >
					</div>
					<label class="col-sm-1 control-label">Total Price: </label>
					<div class="col-sm-3">
						<div class="input-group"><span class="input-group-addon">$</span><input type="text" autocomplete="off" placeholder="Total Price" name="water_intake" id="totalcost" class="form-control" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script src="/vendor/sparkline/jquery.sparkline.min.js"></script>
<script src="/vendor/chartist-js/chartist.js"></script>
<script src="/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script>

$('form').change(function() {
	updateTotals();	
});

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

function showTotals(){
	$('.calc').fadeOut( "fast", function() {
    	$('#dashboard').fadeIn("fast", function() {updateTotals();});
		$('#pricing').fadeIn("fast");
  	});
}

function updateTotals(){
	
	var currentLean = roundToTwo(parseInt($('#weight').val())*(100-parseInt($('#body_fat').val()))/100);
	var goalLean = currentLean + parseInt($('#ggain').val());
	var goalWeight = roundToTwo(goalLean / ((100 - parseInt($('#gbody_fat').val()))/100));
	
	totalchart.data.series = [100-parseInt($('#body_fat').val()), parseInt($('#body_fat').val())];
	totalchart1.data.series = [100-parseInt($('#gbody_fat').val()), parseInt($('#gbody_fat').val())];
	$('#gpounds').html(goalWeight+' lbs');
	$('#gbodyper').html($('#gbody_fat').val()+'%');
	
	$('#pounds').html($('#weight').val()+' lbs');
	$('#bodyper').html($('#body_fat').val()+'%');
	
	var poc = parseInt($('#weight').val())-goalWeight;
	if(poc > 1){
		$('#totalpoc').html(roundToTwo(roundToTwo(poc * -1) + parseInt($('#ggain').val())) + ' lbs');
	}
	else{
		$('#totalpoc').html(roundToTwo(roundToTwo(Math.abs(poc)) + parseInt($('#ggain').val())) +' lbs');
	}
	
	//$('#totalpoc').html();
	$('#aveper').html($('#avechange').val()+' %');
	
	
	var weekcount = parseInt((parseFloat($('#body_fat').val()) - parseFloat($('#gbody_fat').val())) / parseFloat($('#avechange').val()));
	if($.isNumeric(weekcount)){
		$('#weeks').val(weekcount);
		$('#totalsessions').val(weekcount);
	}
	
	var totalcost = roundToTwo(parseFloat($('#sessionprice').val()) * parseFloat($('#totalsessions').val()));
	$('#totalcost').val(totalcost);
	
	totalchart.update();
	totalchart1.update();
	
}

var totalchart = new Chartist.Pie('#startChart .chart-pie-right', {
	series: [80, 20]
	}, {
	donut: true,
	donutWidth: 10,
	startAngle: 0,
	showLabel: false
});
var totalchart1 = new Chartist.Pie('#currentChart .chart-pie-right', {
	series: [80, 20]
	}, {
	donut: true,
	donutWidth: 10,
	startAngle: 0,
	showLabel: false
});

</script>

@endsection