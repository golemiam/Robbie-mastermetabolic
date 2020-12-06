<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Send Session Results - Session {{ $session->session_number }}
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-12 col-md-6">
    <div class="example">
		<div class="checkbox-custom checkbox-primary">
			<input type="checkbox" checked="" id="inputChecked">
			<label for="inputChecked">Results Dashboard</label>
		</div>
		<div class="checkbox-custom checkbox-primary">
			<input type="checkbox" <?php if(!empty($session->nutritionProgram['id'])){echo 'checked';} ?> id="inputChecked">
			<label for="inputChecked">Nutrition Program</label>
		</div>
		<div class="checkbox-custom checkbox-primary">
			<input type="checkbox" <?php if(!empty($session->exerciseProgram['id'])){echo 'checked';} ?> id="inputChecked">
			<label for="inputChecked">Exercise Program</label>
		</div>
		<br>
    	<p> Alert the client that this session is completed, and prompt them to login and view the session information </p>
        <form class="form-horizontal" method="POST" class="form-control" action="/user/{{ $client->id }}/sendresults/{{ $session->id }}" autocomplete="off">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button class="btn btn-primary" type="submit">Send Email</button>
        </form>
    </div>
</div>

@endsection