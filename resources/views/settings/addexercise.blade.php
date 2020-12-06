<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Add New Exercise
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-12 col-md-6">
    <div class="example">
        <form class="form-horizontal" method="POST" class="form-control" action="/settings/exercises" autocomplete="off">
            <div class="form-group">
                <label class="col-sm-3 control-label">Exercise Name: </label>
                <div class="col-sm-9">
                    <input type="text" autocomplete="off" placeholder="Exercise Name" name="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Category: </label>
                <div class="col-sm-9">
                    {!! Form::select('category', ['Chest' => 'Chest' ,'Biceps' => 'Biceps', 'Triceps' => 'Triceps', 'Shoulders' => 'Shoulders', 'Traps' => 'Traps', 'Back' => 'Back', 'Quadriceps' => 'Quadriceps', 'Hamstrings' => 'Hamstrings', 'Glutes' => 'Glutes', 'Calfs' => 'Calfs', 'Core' => 'Core', 'Combination' => 'Combination'], null,['class' => 'form-control']) !!}
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