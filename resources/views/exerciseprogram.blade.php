<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
{{ $client->name }} Exercise Program
@endsection

@section('titleaction')
<h1 class="page-title" style="float: left;">&nbsp;- Session</h1> {!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "exerciseprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
<!--  Determine if Latest session already has program --> 
@if(empty($latestsession->exerciseProgram['id']))
<a href="/user/{{ $client->id }}/copyexerciseprogram/{{ $latestsession->id }}/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy To New Session</button></a>
@endif
@endsection

@section('formaction')
#
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

@if(!empty($session->exerciseProgram['id']))
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
	.removecircuit, .removeline, .addline, .addcircuit, .save{
		display: none;
	}
	.counter-cal{
		display: none;
	}
	

	</style>
	
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body program-header">
				<h1>{{ $client->name }} - Exercise Program</h1>
				<div class="titleright" style="float: right;">
					<h1 class="helpertext">Session</h1> 
					<!--  Determine if Latest session already has program --> 
					@if(empty($latestsession->exerciseProgram['id']))
					<a href="/user/{{ $client->id }}/copyexerciseprogram/{{ $latestsession->id }}/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px; float: right;" type="button">Copy To New Session</button></a>
					@endif
					<div class="links">
						@foreach($sessions as $key => $val)
							@if($val == ($sessions[$session->id]-1))
								<a href="/user/{{$client->id}}/exerciseprogram/{{$key}}">
									<i class="icon wb-arrow-left" aria-hidden="true"></i>
								</a>
							@endif
							@if($val == ($sessions[$session->id]+1))
								<a href="/user/{{$client->id}}/exerciseprogram/{{$key}}">
									<i class="icon wb-arrow-right" aria-hidden="true"></i>
								</a>
							@endif
						@endforeach
					</div>
					{!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "exerciseprogram", this.options[this.selectedIndex].value);', 'style' => 'float: right; width: 100px; margin-left: 15px; margin-right: 15px;']) !!}
				</div> 
			</div>
		</div>
	</div>

	@include('exerciseprogramform')

	@if(Auth::user()->role == 'trainer')
	<a href="/user/{{ $client->id }}/editexerciseprogram/{{ $session->id }}"><button type="button" style="float: right;" class="btn btn-primary">Edit Program</button></a>
	@endif
	
	<a href="/user/{{ $client->id }}/exerciseprogram/pdf/{{ $session->id }}" target="_blank"><button type="button" style="float: right; margin-right: 20px;" class="btn btn-primary">Download PDF</button></a>
	
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
	
	$("#exerciseform :input").prop("disabled", true);
	$("td:last-child").css({display:"none"});
	$("th:last-child").css({display:"none"});

	</script>

@else
	<p> There is no Exsercise Program for this session.
	@if(Auth::user()->role == 'trainer')
	<a href="/user/{{ $client->id }}/newexerciseprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a><a href="/user/{{ $client->id }}/copyexerciseprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy From Last Session</button></a>
	@endif
@endif


@endsection