<!-- resources/views/auth/register.blade.php -->

@extends('layouts.dashboard')

@section('pagetitle')
Update User Profile
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-6">
    <!-- Example Basic Form -->
    <div class="example-wrap">
        <h4 class="example-title">Main Information</h4>
        <div class="example">
            <form method="POST" action="/users/update/{{ $user->id }}" autocomplete="off">
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Full Name</label>
                    <input type="text" autocomplete="off" placeholder="Full Name" name="name" id="inputBasicEmail" class="form-control" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Email Address</label>
                    <input type="email" autocomplete="off" placeholder="Email Address" name="email" id="inputBasicEmail" class="form-control" value="{{$user->email}}">
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="inputBasicFirstName" class="control-label">Password (Leave empty to not change)</label>
                        <input type="password" autocomplete="off" placeholder="Password" name="password" id="inputBasicPassword" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                    <label for="inputBasicFirstName" class="control-label">&nbsp;</label>
                        <input type="password" autocomplete="off" placeholder="Confirm" name="password_confirmation" id="inputBasicPassword" class="form-control">
                    </div>
                </div>
                @if(Auth::user()->role == 'trainer')
                <div class="form-group">
                    <label for="inputBasicPassword" class="control-label">Trainer</label>
                    {!! Form::select('owner_id', $trainers, $user->owner_id, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="inputBasicPassword" class="control-label">Role</label>
                    {!! Form::select('role', ['client' => 'Client', 'trainer' => 'Trainer'], $user->role, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="inputBasicPassword" class="control-label">Status</label>
                    {!! Form::select('status', ['active' => 'Active', 'archived' => 'Archived'], $user->status, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Session Price</label>
                    <div class="input-group">
                    	<span class="input-group-addon">$</span>
                    	<input type="text" autocomplete="off" placeholder="Session Price" name="session_price" id="inputBasicEmail" class="form-control" value="{{$user->session_price}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Google Calendar Id</label>
                    <input type="text" autocomplete="off" placeholder="Google Calendar Id" name="calendar" id="inputBasicEmail" class="form-control" value="{{$user->calendar}}">
                </div>
                @endif
                <h4 class="example-title">Contact Information</h4>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Phone Number</label>
                    <input type="text" autocomplete="off" placeholder="Phone Number" name="phone" id="inputBasicEmail" class="form-control" value="{{$user->phone}}">
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="inputBasicFirstName" class="control-label">Address</label>
                        <input type="text" autocomplete="off" placeholder="Address Line 1" name="addr_line_1" id="inputBasicFirstName" class="form-control" value="{{$user->addr_line_1}}">
                    </div>
                    <div class="form-group col-sm-6">
                    <label for="inputBasicFirstName" class="control-label">&nbsp;</label>
                        <input type="text" autocomplete="off" placeholder="Address Line 2" name="addr_line_2" id="inputBasicLastName" class="form-control" value="{{$user->addr_line_2}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <input type="text" autocomplete="off" placeholder="City" name="city" id="inputBasicFirstName" class="form-control" value="{{$user->city}}">
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="text" autocomplete="off" placeholder="State" name="state" id="inputBasicLastName" class="form-control" value="{{$user->state}}">
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="text" autocomplete="off" placeholder="Zip" name="zip" id="inputBasicLastName" class="form-control" value="{{$user->zip}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="inputBasicFirstName" class="control-label">Emergency Contact</label>
                        <input type="text" autocomplete="off" placeholder="Full Name" name="ec_name" id="inputBasicFirstName" class="form-control" value="{{$user->ec_name}}">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputBasicFirstName" class="control-label">&nbsp;</label>
                        <input type="text" autocomplete="off" placeholder="Phone Number" name="ec_phone" id="inputBasicLastName" class="form-control" value="{{$user->ec_phone}}">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputBasicFirstName" class="control-label">&nbsp;</label>
                        <input type="text" autocomplete="off" placeholder="Relationship" name="ec_relationship" id="inputBasicLastName" class="form-control" value="{{$user->ec_relationship}}">
                    </div>
                </div>
                <h4 class="example-title">Goals</h4>
                <div class="row">
                    <div class="form-group col-sm-6">
                    	<label for="inputBasicEmail" class="control-label">Target Body Fat</label>
                    	<div class="input-group">
                        	<input type="text" autocomplete="off" placeholder="Target Percentage" name="target_bf" id="inputBasicFirstName" class="form-control" value="{{$user->target_bf}}" {{{ Auth::user()->role == 'trainer' ? '' : 'disabled' }}}>
                        	<span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                    	<label for="inputBasicEmail" class="control-label">Target Muscle Gain</label>
                        <input type="text" autocomplete="off" placeholder="Target Muscle Gain" name="target_mg" id="inputBasicLastName" class="form-control" value="{{$user->target_mg}}" {{{ Auth::user()->role == 'trainer' ? '' : 'disabled' }}}>
                    </div>
                </div>
                <h4 class="example-title">Features</h4>
                <div class="row">
                	<div class="form-group col-sm-3">
						<div class="checkbox-custom checkbox-primary">
							{!! Form::checkbox('has_dashboard', '1', $user->has_dashboard) !!}
							<label for="inputChecked">Dashboard</label>
						</div>
					</div>
                	<div class="form-group col-sm-3">
						<div class="checkbox-custom checkbox-primary">
							{!! Form::checkbox('has_nutrition', '1', $user->has_nutrition) !!}
							<label for="inputChecked">Nutrition</label>
						</div>
					</div>
                	<div class="form-group col-sm-3">
						<div class="checkbox-custom checkbox-primary">
							{!! Form::checkbox('has_exercise', '1', $user->has_exercise) !!}
							<label for="inputChecked">Exercise</label>
						</div>
					</div>
                	<div class="form-group col-sm-3">
						<div class="checkbox-custom checkbox-primary">
							{!! Form::checkbox('can_edit', '1', $user->can_edit) !!}
							<label for="inputChecked">Can Edit</label>
						</div>
					</div>
				</div>
                <h4 class="example-title">Preferences</h4>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Gender</label>
                    {!!  Form::select('gender', array('male' => 'Male', 'female' => 'Female'),$user->gender, array('class' => 'form-control')) !!}
                </div>
				<div class="form-group">
					<label for="inputBasicEmail" class="control-label">Height</label>
					<input type="text" autocomplete="off" placeholder="Height" name="height" id="inputBasicLastName" class="form-control" value="{{$user->height}}">
				</div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Medical Conditions</label>
                    <textarea placeholder="List any and all conditions" class="form-control" name="med_cond">{{$user->med_cond}}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Exercise Restrictions</label>
                    <textarea placeholder="List any and all restrictions" class="form-control" name="exer_cond">{{$user->exer_cond}}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Food Allergies</label>
                    <textarea placeholder="List any and all allergies" class="form-control" name="food_cond">{{$user->food_cond}}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Dietary Preferences</label>
                    <textarea placeholder="List any and all preferences" class="form-control" name="diet_cond">{{$user->diet_cond}}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputBasicEmail" class="control-label">Client Notes</label>
                    <textarea placeholder="List any and all notes" class="form-control" name="notes">{{$user->notes}}</textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="id" value="{{ $user->id }}">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Example Basic Form -->
</div>


@endsection