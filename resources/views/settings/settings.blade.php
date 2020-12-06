@extends('layouts.dashboard')

@section('pagetitle')
Settings
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
     <a href="/settings/nutritions"> View Nutritions </a><br>
     <a href="/settings/meals"> View Meals </a><br>
     <a href="/settings/nutritiontemplates"> View Nutrition Program Templates </a><br>
      <a href="/settings/exercisetemplates"> View Exercise Program Templates </a><br>
     <a href="/settings/exercises"> View Exercises </a><br>
     <a href="/settings/circuits"> View Circuits </a><br>
     <a href="/users"> Manage Users </a><br>
     <a href="/settings/groups"> Manage User Groups </a>
	
@endsection