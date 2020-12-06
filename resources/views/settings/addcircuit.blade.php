<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Add New Circuit
@endsection

@section('content')
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
	.removecircuit, .ui-timepicker-input{
		display: none;
	}

	.modal .modal-body .tab-content {
		max-height: 620px;
		overflow-y: auto;
	}

</style>

<form method="POST" action="/settings/circuits" autocomplete="off" onsubmit="return validate(this);" id="nutritionform">
	<div class="col-lg-12">
		<div id="circuits" class="">
			<!-- <div class="panel" id="circuit1">
				<div role="tab" id="circuit1label" class="panel-heading panel-title">
					<h4 style="float: left; margin-top: 8px;">Circuit 1</h4>
					<input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="circuit1name" placeholder="Circuit Name" autocomplete="off">
				</div>
				<div role="tabpanel" id="circuit1panel">
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr style="background-color: #3c3f48;">
									<th width="550">Exercise Name</th>
									<th>Sets</th>
									<th>Reps</th>
									<th>Speed</th>
									<th>Weights</th>
									<th width="41"></th>
								</tr>
							</thead>
							<tbody>
								<tr class="totals">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<button style="float: right;" onclick="openModal(1)" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addline" type="button">
											<i aria-hidden="true" class="icon wb-plus"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="col-lg-6" style="padding-left: 0px;">
							<textarea rows="3" id="circuit1notes" class="form-control" placeholder="Notes"></textarea>
						</div>
						<div class="col-lg-6" style="padding-right: 0px;">
							<button onclick="removecircuit(1);" style="float: right;" data-original-title="Delete exe" data-toggle="tooltip" class="removecircuit btn btn-sm btn-icon btn-flat btn-default" type="button">
								<i aria-hidden="true" class="icon wb-trash"></i>
							</button>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<input type="hidden" name="circuit" id="circuitsinput" value="">
			<input type="hidden" name="name" id="nameinput" value="">
			<button class="btn btn-primary save" style="float: right;" type="submit">Save Circuit</button>
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
<link rel="stylesheet" href="/vendor/typeahead-js/typeahead.css">
<script src="/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="/vendor/typeahead-js/typeahead.jquery.min.js"></script>
<script src="/vendor/typeahead-js/bloodhound.min.js"></script>
<script src="/js/circuits.js"></script>

<script>

var single = true;

var exe1 = {
	circuitnum: 1,
	name: '',
	linecount: 0,
	items: [],
	time: '',
	notes: '',
};

addCircuit(exe1);

</script>

@endsection