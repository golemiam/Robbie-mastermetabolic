@extends('layouts.dashboard')

@section('pagetitle')
New Session For {{ $client->name }}
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')

<div class="col-sm-12 col-md-6">
    <div class="example">
        <form class="form-horizontal" method="POST" class="form-control" action="/user/{{ $client->id }}/{{ isset($session->id) ? 'updateSession' : 'sessions' }}" autocomplete="off">
            <div class="form-group">
                <label class="col-sm-3 control-label">Date: </label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Date" name="date" data-plugin="datepicker" class="form-control" value="{{ isset($session->date) ? $session->date : date('m/d/Y') }}">
                </div>
                <label class="col-sm-1 control-label">Time: </label>
                <div class="col-sm-4">
                    <input type="text" placeholder="" name="time" data-plugin="timepicker" class="form-control" value="{{ isset($session->time) ? $session->time : date('g:ia') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Location: </label>
                <div class="col-sm-9">
                    <input type="text" placeholder="Location" name="location" class="form-control" value="{{ isset($session->location) ? $session->location : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Weight: </label>
                <div class="col-sm-9">
                    <input type="text" placeholder="Weight" name="weight" class="form-control" value="<?php if(isset($session->weight)){ echo $session->weight; }else{ if(isset($last->weight)){ echo $last->weight; }} ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Height: </label>
                <div class="col-sm-9">
                    <input type="text" placeholder="Height" name="height" id="height" class="form-control" value="<?php if(isset($client->height)){ echo $client->height; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Skyndex Setting: </label>
                <div class="col-sm-9">
                    <input type="text" placeholder="Skyndex Setting" name="skyndex_setting" class="form-control" value="{{ isset($session->skyndex_setting) ? $session->skyndex_setting : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Body Info: </label>
                <div class="col-sm-9">
				   <div class="col-sm-3">
						<input type="text" placeholder="Neck" name="neck" id="neck" class="form-control" autocomplete="off" value="{{ isset($session->neck) ? $session->neck : '' }}">
					</div>
				   <div class="col-sm-3">
						<input type="text" placeholder="Arm" name="arm" id="arm" class="form-control" autocomplete="off" value="{{ isset($session->thigh) ? $session->arm : '' }}">
					</div>
					<div class="col-sm-3">
						<input type="text" placeholder="Chest" name="chest" id="chest" class="form-control" autocomplete="off" value="{{ isset($session->chest) ? $session->chest : '' }}">
					</div>
					<div class="col-sm-3">
						<input type="text" placeholder="Waist" name="waist" id="waist" class="form-control" autocomplete="off" value="{{ isset($session->waist) ? $session->waist : '' }}">
					</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"> </label>
                <div class="col-sm-9">
				   <div class="col-sm-3">
						<input type="text" placeholder="Hips" name="hips" id="hips" class="form-control" autocomplete="off" value="{{ isset($session->hips) ? $session->hips : '' }}">
					</div>
				   <div class="col-sm-3">
						<input type="text" placeholder="Thigh" name="thigh" id="thigh" class="form-control" autocomplete="off" value="{{ isset($session->thigh) ? $session->thigh : '' }}">
					</div>
					<div class="col-sm-3">
						<input type="text" placeholder="Calf" name="calf" id="calf" class="form-control" autocomplete="off" value="{{ isset($session->calf) ? $session->calf : '' }}">
					</div>
					<div class="col-sm-3">
						<input type="text" placeholder="Forearm" name="forearm" id="forearm" class="form-control" autocomplete="off" value="{{ isset($session->forearm) ? $session->forearm : '' }}">
					</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Body Fat %: </label>
                <div class="col-sm-6">
                    <input type="text" placeholder="Body Fat %" name="body_fat" id="bodyfat" class="form-control" value="<?php if(isset($session->body_fat)){ echo $session->body_fat; }else{ if(isset($last->body_fat)){ echo $last->body_fat; }} ?>">
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-primary" type="button" onclick="calc()">Calculate</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	@if(isset($session->id))
                		<input type="hidden" name="id" value="{{ $session->id }}">
                	@endif
                	<input type="hidden" name="owner_id" value="{{ $client->id }}">
                    <button class="btn btn-primary" type="submit">Submit </button>
                </div>
            </div>
        </form>
        <script>
            var gender = '<?php if(!empty($client->gender)){echo $client->gender;}else{echo '';} ?>';
            function calc(){
                if(gender == 'male') {
                    if (
                            $('#neck').val() == '' ||
                            $('#chest').val() == '' ||
                            $('#waist').val() == ''
                    ) {
                        alert('Please fill in all required fields');
                    } else {
                        var bodyfat = 86.010 * Math.log10($('#waist').val() - $('#neck').val()) - 70.041 * Math.log10($('#height').val()) + 36.76;
                        $('#bodyfat').val(Math.round(bodyfat * 100) / 100);
                    }
                } if(gender == 'male') {
                    if (gender == 'female') {
                        if (
                                $('#neck').val() == '' ||
                                $('#hips').val() == '' ||
                                $('#waist').val() == ''
                        ) {
                            alert('Please fill in all required fields');
                        } else {
                            var bodyfat = 163.205 * Math.log10($('#waist').val() + $('#hips').val() - $('#neck').val()) - 97.684 * Math.log10($('#height').val()) - 78.387
                            $('#bodyfat').val(Math.round(bodyfat * 100) / 100);
                        }
                    }
                }
                else{
                    alert('Please assign gender in profile');
                }
            }
        </script>
    </div>
</div>

@endsection