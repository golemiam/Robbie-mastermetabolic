<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} - New Nutrition Program - Session
@endsection

@section('titleaction')
{!! Form::select('session_id', $sessions, $newsession, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
@endsection

@section('formaction')
/user/{{ $client->id }}/nutritionprogram/{{ $newsession }}
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
					<a href="/user/{{$client->id}}/newnutritionprogram/{{$newsession}}"><button style="float: right; height: 36px;" class="btn btn-primary save">New Plan</button></a>
					<div class="links">
						@foreach($sessions as $key => $val)
							@if($val == ($sessions[$newsession]-1))
								<a href="/user/{{$client->id}}/nutritionprogram/{{$key}}">
									<i class="icon wb-arrow-left" aria-hidden="true"></i>
								</a>
							@endif
							@if($val == ($sessions[$newsession]+1))
								<a href="/user/{{$client->id}}/nutritionprogram/{{$key}}">
									<i class="icon wb-arrow-right" aria-hidden="true"></i>
								</a>
							@endif
						@endforeach
					</div>
					{!! Form::select('session_id', $sessions, $newsession, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "nutritionprogram", this.options[this.selectedIndex].value);', 'style' => 'float: right; width: 100px; margin-left: 15px; margin-right: 15px;']) !!}
				</div> 
			</div>
		</div>
	</div>

	@include('nutritionprogramform')

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
	
	</script>


@endsection