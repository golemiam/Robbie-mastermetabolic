@extends('layouts.loginform')

@section('pagetitle')
Login
@endsection

@section('content')

	<!-- Display Validation Errors -->
	@include('common.errors')
	
	    <p>Sign into your personalized fitness account</p>
      <form method="POST" action="/login">
        <div class="form-group">
          <label class="sr-only" for="inputEmail">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Password</label>
          <input type="password" class="form-control" id="inputPassword" name="password"
          placeholder="Password">
        </div>
        <div class="form-group clearfix">
          <div class="checkbox-custom checkbox-inline checkbox-primary pull-left">
            <input type="checkbox" id="inputCheckbox" name="remember">
            <label for="inputCheckbox">Remember me</label>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
      </form>
	
@endsection