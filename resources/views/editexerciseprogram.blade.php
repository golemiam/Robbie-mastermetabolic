<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Edit Exercise Program
@endsection

@section('titleaction')
@endsection

@section('formaction')
/user/{{ $client->id }}/editexerciseprogram/{{ $session->id }}
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

	<style>
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