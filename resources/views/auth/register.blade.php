<!-- resources/views/auth/register.blade.php -->

@extends('layouts.app')

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

	<form method="POST" action="/register">
		{!! csrf_field() !!}

		<div>
			Name
			<input type="text" name="name" value="{{ old('name') }}">
		</div>

		<div>
			Email
			<input type="email" name="email" value="{{ old('email') }}">
		</div>

		<div>
			Password
			<input type="password" name="password">
		</div>

		<div>
			Confirm Password
			<input type="password" name="password_confirmation">
		</div>
	
		<div>
			Owner Id
			<input type="text" name="owner_id" value="{{ old('owner_id') }}">
		</div>
		
		<div>
			Role
			<select name="role">
				<option value="trainer">Trainer</option>
				<option value="client">Client</option>
			</select>
		</div>

		<div>
			<button type="submit">Register</button>
		</div>
	</form>

@endsection