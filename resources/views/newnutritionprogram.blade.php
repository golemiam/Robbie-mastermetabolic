@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} - New Nutrition Program - Session
@endsection

@section('titleaction')
{!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
@endsection

@section('formaction')
/user/{{ $client->id }}/nutritionprogram/{{ $session->id }}
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

</style>

<div class="col-sm-12">
	<div class="panel">
		<div class="panel-body program-header">
			<h1>{{ $client->name }} - New Nutrition Program</h1>
			<div class="titleright" style="float: right;">
				<h1 class="helpertext">Session</h1> 
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
				{!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'float: right; width: 100px; margin-left: 15px; margin-right: 15px;']) !!}
			</div> 
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