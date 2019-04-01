@extends('layouts_front.master')
@section('content')
<div id="content-area">
<section class="inner-banner-row" style="background-image:url({{env('APP_URL')}}/images/banner-bg.png);">
    <div class="container-fluid">
      <div class="inner-banner-caption">
        <h1>Join For Free</h1>
        <p>Please enter your information to create a free account. With your account you will be able to register for our live webinars, </p>
      </div>
    </div>
  </section>
<div class="container-fluid">
  <div class="login-area">
    <div class="row">
      <div class="col-lg-4 offset-lg-1 login-form">
        <form class="" action="{{route('client.resetpassword')}}" method="post"  id="forgot_form">
          <div class="col-md-12 text-center">
            <h4>Reset Password</h4>
            <div class="form-group"></div>
          </div>
          <div class="col-md-12"> </br>
            </br>
            </br>
            <div class="form-group">
              <label for="">Email Id*</label>
              <input type="email" name="email" class="form-control email" placeholder="Email Address" required>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group"> </div>
            <div class="btn-group-md text-center">
              <input type="submit" class="btn btn-primary" value="Reset Password">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<script language="javascript" type="text/javascript">
	$(document).ready(function (){
		$("#forgot_form").validate();
	}); 
</script> 
@stop