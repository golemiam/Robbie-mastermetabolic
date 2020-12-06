<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} - New Exercise Program - Session {{ $newsession }}
@endsection

@section('titleaction')
{!! Form::select('session_id', $sessions, $newsession, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "exerciseprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
@endsection

@section('formaction')
/user/{{ $client->id }}/exerciseprogram/{{ $newsession }}
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
	#circuits .table > thead > tr > th, #totals .table > thead > tr > th{
		color: white;
	}
	#circuits .table > tbody > tr > td span.label{
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
	.removecircuit{
		margin-top: 50px;
	}
	.counter-cal{
		display: none;
	}
	

	</style>
	
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body program-header">
				<h1>{{ $client->name }} - New Exercise Program</h1>
				<div class="titleright" style="float: right;">
					<h1 class="helpertext">Session</h1> 
					<div class="links">
						@foreach($sessions as $key => $val)
							@if($val == ($sessions[$newsession]-1))
								<a href="/user/{{$client->id}}/exerciseprogram/{{$key}}">
									<i class="icon wb-arrow-left" aria-hidden="true"></i>
								</a>
							@endif
							@if($val == ($sessions[$newsession]+1))
								<a href="/user/{{$client->id}}/exerciseprogram/{{$key}}">
									<i class="icon wb-arrow-right" aria-hidden="true"></i>
								</a>
							@endif
						@endforeach
					</div>
					{!! Form::select('session_id', $sessions, $newsession, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "exerciseprogram", this.options[this.selectedIndex].value);', 'style' => 'float: right; width: 100px; margin-left: 15px; margin-right: 15px;']) !!}
				</div> 
			</div>
		</div>
	</div>

	@include('exerciseprogramform')
	
	<script>

	var single = false;

	var oldcircuits = '{!! addslashes($session->ExerciseProgram['circuits']) !!}';
	circuitcount = 0;
	$.each($.parseJSON(oldcircuits), function(i, ocircuits) {
		$.each(ocircuits, function(i, circuit) {
			var newcircuit = {
				circuitnum: circuit.circuitnum,
				name: circuit.name,
				linecount: 0,
				items: [],
				notes: circuit.notes,
				time: circuit.time
			};
			addCircuit(newcircuit);
			$.each(circuit.items, function(i, item) {
				console.log(item);
				if(item != null){
					addExercise([item.name, item.sets, item.reps, item.speed, item.weight, item.proteins, item.category], item.lcount, circuit.circuitnum, item.mulipiler);
				}
			});
		});
	});

	</script>


@endsection