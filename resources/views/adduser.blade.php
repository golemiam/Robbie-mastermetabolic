<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Add New User
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-12 col-md-6">
    <div class="example">
        <form class="form-horizontal" method="POST" class="form-control" action="/register" autocomplete="off">
            <div class="form-group">
                <label class="col-sm-3 control-label">Client Name: </label>
                <div class="col-sm-9">
                    <input type="text" autocomplete="off" placeholder="Full Name" name="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Client Gender: </label>
                <div class="col-sm-9">
                    {!!  Form::select('gender', array('male' => 'Male', 'female' => 'Female'),null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Client Email: </label>
                <div class="col-sm-9">
                    <input type="email" autocomplete="off" placeholder="@email.com" name="email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Password: </label>
                <div class="col-sm-9">
                    <input type="password" autocomplete="off" placeholder="******" name="password" class="form-control">
                </div>
            </div>            
            <div class="form-group">
                <label class="col-sm-3 control-label">Confirm Password: </label>
                <div class="col-sm-9">
                    <input type="password" autocomplete="off" placeholder="******" name="password_confirmation" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Trainer: </label>
                <div class="col-sm-9">
                    <select class="form-control" name="owner_id">
                    	<option value=""></option>
						@foreach ($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Role: </label>
                <div class="col-sm-9">
                    <select class="form-control" name="role">
						<option value="client">Client</option>
						<option value="trainer">Trainer</option>
					</select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-primary" type="submit">Submit </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection