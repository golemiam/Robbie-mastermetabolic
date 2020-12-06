@extends('layouts.dashboard')

@section('pagetitle')
New Exercise Program - {{ $client->name }}
@endsection

@section('titleaction')
{!! Form::select('session_id', $sessions, $session->id, ['class' => 'form-control', 'onChange' => 'changeSession('.$client->id.', "exerciseprogram", this.options[this.selectedIndex].value);', 'style' => 'width: 5%; float: left; margin-left: 15px;']) !!}
@endsection

@section('formaction')
/user/{{ $client->id }}/exerciseprogram/{{ $session->id }}
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
.panel-heading a{
	color: #3c3f48;
	font-weight: bold;
	font-size: 18px;
	font-family: "Open Sans";
}
.totals span{
	font-weight: bold;
}
#circuits .table > tbody > tr > td span.label{
	text-transform: uppercase;
	margin-right: 20px;
}
.removecircuit{
	margin-top: 50px;
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

<script>

var single = false;

var exe1 = {
	circuitnum: 1,
	name: 'Cardio',
	linecount: 0,
	items: [],
	time: '',
	notes: '',
};

addCircuit(exe1);

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