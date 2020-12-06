@extends('layouts.dashboard')

@section('pagetitle')
New Nutrition Program Template
@endsection

@section('titleaction')
@endsection

@section('formaction')
/settings/nutritiontemplates
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
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
.panel-heading a{
	color: #3c3f48;
	font-weight: bold;
	font-size: 18px;
	font-family: "Open Sans";
}
.totals span{
	font-weight: bold;
}
#meals .table > tbody > tr > td span.label{
	text-transform: uppercase;
	margin-right: 20px;
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

<div class="col-sm-12">
	<div class="panel">
		<div class="panel-body program-header">
			<h1>New Nutrition Program Template</h1>
		</div>
	</div>
</div>

@include('nutritionprogramform')

<script>

var meal1 = {
	mealnum: 1,
	name: '',
	linecount: 0,
	items: [],
	time: '6:00am',
	notes: '',
};

addMeal(meal1);

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

<script language="JavaScript">
  var needToConfirm = true;
  
  window.onbeforeunload = confirmExit;
  function confirmExit()
  {
    if (needToConfirm)
      return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>



@endsection