@extends('layouts.dashboard')

@section('pagetitle')
Welcome {{ $client->name }}
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

	<style type="text/css">
	body .hamburger{
		display: block;
	}
	</style>
	
	<div style="text-align: center;">
     @if($client->has_dashboard)<a href="/user/{{ $client->id }}/dashboard/pdf"> Download Dashboard </a><br><br>@endif
     @if($client->has_nutrition)<a href="/user/{{ $client->id }}/nutritionprogram/pdf/"> Download Latest Nutrition Program </a><br><br>@endif
     @if($client->has_exercise)<a href="/user/{{ $client->id }}/exerciseprogram/pdf/"> Download Latest Exercise Program </a>@endif
    </div>
	
@endsection