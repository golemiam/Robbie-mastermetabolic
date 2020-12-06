<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Add New Nutrition
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-12 col-md-6">
    <div class="example">
        <form class="form-horizontal" method="POST" class="form-control" action="/settings/nutritions" autocomplete="off">
            <div class="form-group">
                <label class="col-sm-3 control-label">Food Name: </label>
                <div class="col-sm-9">
                    <input type="text" autocomplete="off" placeholder="Food Name" name="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Portion Name: </label>
                <div class="col-sm-9">
                    <input type="text" autocomplete="off" placeholder="Portion Name" name="portion_name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Category: </label>
                <div class="col-sm-9">
                    {!! Form::select('category', ['proteins' => 'proteins' ,'carbohydrates' => 'carbohydrates', 'fruits' => 'fruits', 'fats' => 'fats', 'Eating out' => 'Eating out', 'vegetables' => 'vegetables', 'Free' => 'Free'], null,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nutritional Info: </label>
                <div class="col-sm-9">
				   <div class="col-sm-3">
						<input type="text" name="calories" autocomplete="off" placeholder="Calories" class="form-control" autocomplete="off">
					</div>
				   <div class="col-sm-3">
						<input type="text" name="fats" autocomplete="off" placeholder="Fats" class="form-control" autocomplete="off">
					</div>
					<div class="col-sm-3">
						<input type="text" name="carbs" autocomplete="off" placeholder="Carbs" class="form-control" autocomplete="off">
					</div>
					<div class="col-sm-3">
						<input type="text" name="proteins" autocomplete="off" placeholder="Proteins" class="form-control" autocomplete="off">
					</div>
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