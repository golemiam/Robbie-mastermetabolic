<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Nutrition Program
@endsection

@section('titleaction')
<h1 class="page-title" style="float: left;">&nbsp;- Session</h1> {!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
<!--  Determine if Latest session already has program --> 
@if(empty($latestsession->nutritionProgram['id']))
<a href="/user/{{ $client->id }}/copynutritionprogram/{{ $latestsession->id }}/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy To New Session</button></a>
@endif
@endsection

@section('formaction')
#
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

@if(!empty($session->nutritionProgram['id']))
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
	#meals .table > tbody > tr > td span.label{
		text-transform: uppercase;
		margin-right: 20px;
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
	.removemeal, .removeline, .addline, .addmeal, .save{
		display: none;
	}
	.counter-cal{
		display: none;
	}
	

	</style>

	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body program-header">
				<h1>{{ $client->name }} - Nutrition Program</h1>
				<div class="titleright" style="float: right;">
					<h1 class="helpertext">Session</h1> 
					<!--  Determine if Latest session already has program --> 
					@if(empty($latestsession->nutritionProgram['id']))
					<a href="/user/{{ $client->id }}/copynutritionprogram/{{ $latestsession->id }}/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px; float: right;" type="button">Copy To New Session</button></a>
					@endif
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

	@if(Auth::user()->role == 'trainer')
	<a href="/user/{{ $client->id }}/editnutritionprogram/{{ $session->id }}"><button type="button" style="float: right;" class="btn btn-primary">Edit Program</button></a>
	@endif
	
	<a href="/user/{{ $client->id }}/nutritionprogram/pdf/{{ $session->id }}" target="_blank"><button type="button" style="float: right; margin-right: 20px;" class="btn btn-primary">Download PDF</button></a>
	
	<script>

	var oldmeals = '{!! addslashes($session->NutritionProgram['meals']) !!}';
	mealcount = 0;
	$.each($.parseJSON(oldmeals), function(i, omeals) {
		$.each(omeals, function(i, meal) {
			var newmeal = {
				mealnum: meal.mealnum,
				name: meal.name,
				linecount: 0,
				items: [],
				notes: meal.notes,
				time: meal.time
			};
			addMeal(newmeal);
			$.each(meal.items, function(i, item) {
				console.log(item);
				if(item != null){
					addNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, meal.mealnum, item.mulipiler);
				}
			});
		});
	});
	
	$("#nutritionform :input").prop("disabled", true);
	$("td:last-child").css({display:"none"});
	$("th:last-child").css({display:"none"});

	</script>

@else
	<p> There is no Nutrition Program for this session.
	@if(Auth::user()->role == 'trainer')
	<!-- <a href="/user/{{ $client->id }}/newnutritionprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a><a href="/user/{{ $client->id }}/copynutritionprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy From Last Session</button></a> -->
	@endif
@endif

@endsection