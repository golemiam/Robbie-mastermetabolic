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
	<link rel="stylesheet" href="/vendor/filament-tablesaw/tablesaw.min.css?v2.2.0">
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

	/* Mobile */

	.panel-body{
		padding: 0px;
	}
	.panel-body .panel-body{
		padding: 30px;
	}

	.page-content {
	    padding: 15px 15px;
	}

	body .hamburger{
		display: block;
	}
	

	</style>
	
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-body program-header">
				<h1>{{ $client->name }} - Exercise Program - Session {{$sessions[$session->id]}}</h1>
				<div class="titleright" style="float: right;">
					<h1 class="helpertext"></h1> 
					<!--  Determine if Latest session already has program --> 
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
				</div> 
			</div>
		</div>
	</div>

	<style>
	.modal .modal-body .tab-content {
	    max-height: 620px;
	    overflow-y: auto;
	}
	.reps{
		min-width: 200px;
	}
	.speed, .sets{
		min-width: 80px;
	}
	#weight{
		min-width: 100px;
	}
	</style>
	<form method="POST" action="@yield('formaction')" autocomplete="off" onsubmit="return validate(this);" id="exerciseform">
		<div class="col-sm-12">
			<div class="panel templatedata" style="display: none;">
				<div class="panel-body form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">Template Name: </label>
						<div class="col-sm-4">
							<input type="text" autocomplete="off" placeholder="Template Name" name="templatename" class="form-control" value="{{ isset($template['name']) ? $template['name'] : '' }}">
						</div>
					</div>
				</div>
			</div>
			<div class="panel">
				<div class="panel-body form-horizontal">
					<div class="form-group">
						<label class="col-sm-1 control-label topdata">Date: </label>
						<div class="col-sm-3 topdata">
							<input type="text" autocomplete="off" data-plugin="datepicker" placeholder="Current Date" name="date" class="form-control" value="{{ isset($session->ExerciseProgram['date']) ? $session->ExerciseProgram['date'] : date('m/d/Y') }}">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix visible-md-block visible-lg-block"></div>
		
		<div class="col-lg-12">
			<div id="circuits" class="">
				<!-- Circuits Section -->
			</div>
		</div>
		<div class="right" style="width: 270px; float: right; margin-right: 15px;">
			<div class="panel" style="float: left; margin-right: 15px;">
				<button style="text-align: center; padding: 15px;" onclick="templateModal()" data-original-title="Replace From Template" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addcircuit" type="button">
					<i aria-hidden="true" class="icon wb-library"></i>
				</button>
			</div>
			<div class="panel" style="float: left; margin-right: 15px;">
				<button style="text-align: center; padding: 15px;" onclick="circuitModal()" data-original-title="Add Built Circuit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addcircuit" type="button">
					<i aria-hidden="true" class="icon wb-layout"></i>
				</button>
			</div>
			<div class="panel" style="float: left;">
				<button style="text-align: center; padding: 15px;" onclick="addCircuit()" data-original-title="Add Circuit" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addcircuit" type="button">
					<i aria-hidden="true" class="icon wb-plus"></i>
				</button>
			</div>
			<button class="btn btn-primary save" onclick="needToConfirm = false;" style="float: right; height: 44px;" type="submit">Save Plan</button>
		</div>
		<div class="clearfix visible-md-block visible-lg-block"></div>
		
		<div class="col-lg-12">
			<div class="panel">
				<div class="panel-body">
					<textarea rows="3" id="programnotes" name="program_notes" class="form-control" placeholder="Program Notes:" style="height: 250px;">{{ isset($session->ExerciseProgram['program_notes']) ? $session->ExerciseProgram['program_notes'] : '' }}</textarea>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="hidden" name="session_id" value="<?php if(isset($newsession)){ echo $newsession; }elseif(isset($session->id)){ echo $session->id;} ?>">
				<input type="hidden" name="program_id" value="<?php if(isset($session->ExerciseProgram['id'])){ echo $session->ExerciseProgram['id'];}elseif(isset($template['id'])){ echo $template['id']; } ?>" >
				<input type="hidden" name="circuits" id="circuitsinput" value="">
				<button class="btn btn-primary save" onclick="needToConfirm = false;" style="float: right;" type="submit">Save Plan</button>
			</div>
		</div>
	</form>
	<?php $mc = 0; ?>
	<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="addExercise" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg modal-center">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-label="Close" data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="exampleModalTabs" class="modal-title">Add Exercise</h4>
					<div class="col-lg-3" style="margin-top: 20px;">
						<input type="text" placeholder="Search" id="search" class="form-control"/>
					</div>
					<div class="col-lg-1" style="margin-top: 20px;">
						<button class="btn btn-primary" onclick="searchcircuit('{{ csrf_token() }}')">Submit</button>
					</div>
				</div>
				<div class="modal-body">
					<div class="nav-tabs-horizontal">
						<ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs">
							<li role="presentation" class="active"><a role="tab" aria-controls="Tabs0" href="#Tabs0" data-toggle="tab" aria-expanded="true">Favorites</a></li> 
							@for ($i = 1; $i < (count($categories)+1); $i++)
								<li role="presentation" {{ $i == 0 ? 'class=active' : '' }}><a role="tab" aria-controls="Tabs{{ $i }}" href="#Tabs{{ $i }}" data-toggle="tab" aria-expanded="true">{{ $categories[$i-1]['category'] }}</a></li> 
							@endfor
						</ul>
						<div class="tab-content">
							<div role="tabpanel" id="Tabs0" class="tab-pane active">
								<div class="col-md-12">
								<div class="example-wrap">
									<div class="example table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Exercise Name</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($exercises as $exe)
												@if ($exe['favorite'] == 1)
												<tr>
													<td>{{ $exe['name'] }}</td>
													<td>
														<button data-original-title="Add" onclick="addExercise(['{{ $exe['name'] }}', '{{ $exe['portion_name'] }}', '{{ $exe['calories'] }}', '{{ $exe['fats'] }}', '{{ $exe['carbs'] }}', '{{ $exe['proteins'] }}', '{{ $exe['category'] }}'], {{ $mc }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
															<i aria-hidden="true" class="icon wb-plus"></i>
														</button>
													</td>
												</tr>
												<?php $mc++; ?>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
							@for ($i = 1; $i < (count($categories)+1); $i++)
							<div role="tabpanel" id="Tabs{{ $i }}" class="tab-pane {{ $i == 0 ? 'active' : '' }}">
								<div class="col-md-12">
								<div class="example-wrap">
									<div class="example table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Exercise Name</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($exercises as $exe)
												@if ($exe['category'] == $categories[$i-1]['category'])
												<tr>
													<td>{{ $exe['name'] }}</td>
													<td>
														<button data-original-title="Add" onclick="addExercise(['{{ $exe['name'] }}', '{{ $exe['portion_name'] }}', '{{ $exe['calories'] }}', '{{ $exe['fats'] }}', '{{ $exe['carbs'] }}', '{{ $exe['proteins'] }}', '{{ $categories[$i-1]['category'] }}'], {{ $mc }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
															<i aria-hidden="true" class="icon wb-plus"></i>
														</button>
													</td>
												</tr>
												<?php $mc++; ?>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						@endfor
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div tabindex="-1" role="dialog" aria-labelledby="exampleModalTabs" aria-hidden="true" id="addCircuit" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg modal-center">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-label="Close" data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="exampleModalTabs" class="modal-title">Add Exercise Source</h4>
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
							@foreach ($circuits as $c)
							<tr>
								<td>{{ $c['name'] }}</td>
								<td>
									<button data-original-title="Add Circuit" onclick="addNewCircuit({{ $c['circuit'] }})" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button">
											<i aria-hidden="true" class="icon wb-plus"></i>
									</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@if(isset($templates))
	<script>
	<?php
	$i = 0;
	foreach($templates as $template){
		echo "var temp".$i."='".$template['circuittemplate']."';\n";
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
	<link rel="stylesheet" href="/vendor/typeahead-js/typeahead.css">
	<script src="/vendor/sparkline/jquery.sparkline.min.js"></script>
	<script src="/vendor/chartist-js/chartist.js"></script>
	<script src="/vendor/matchheight/jquery.matchHeight-min.js"></script>
	<script src="/vendor/typeahead-js/typeahead.jquery.min.js"></script>
	<script src="/vendor/typeahead-js/bloodhound.min.js"></script>
	<script src="/js/circuits.js"></script>
	<script src="/vendor/filament-tablesaw/tablesaw.js"></script>
  	<script src="/vendor/filament-tablesaw/tablesaw-init.js"></script>
	
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
			addMobileCircuit(newcircuit);
			$.each(circuit.items, function(i, item) {
				console.log(item);
				if(item != null){
					addMobileExercise([item.name, item.sets, item.reps, item.speed, item.weight, item.proteins, item.category], item.lcount, circuit.circuitnum, item.mulipiler);
				}
			});
		});
	});
	
	$("#exerciseform :input").prop("disabled", true);

	</script>

@else
	<p> There is no Exsercise Program for this session.
	@if(Auth::user()->role == 'trainer')
	<a href="/user/{{ $client->id }}/newexerciseprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Add New</button></a><a href="/user/{{ $client->id }}/copyexerciseprogram/{{ $session->id }}"><button class="btn btn-raised btn-primary btn-default btn-sm" style="margin-left: 10px;" type="button">Copy From Last Session</button></a>
	@endif
@endif


@endsection