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
        <form class="" action="{{route('update-password')}}" method="post"  id="change_password_form">
          <div class="col-md-12 text-center">
            <h4>Change Password</h4>
            <div class="form-group"></div>
          </div>
          <div class="col-md-12"> </br>
            </br>
            </br>
            <div class="form-group">
              <label for="">Password*</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label for="">Con Password*</label>
              <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Password" required>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group"> </div>
            <div class="btn-group-md text-center">
              <input type="submit" class="btn btn-primary" value="Update Password">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="data" value="{{ $encEmail }}">
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

    jQuery.validator.addMethod("pwcheck", function(value, element) {
      return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
  }, "Ingrese una contraseña válida con mayúsculas y minúsculas"); 




    $("#change_password_form").validate({
        rules: {
      password: {
        required: true,
        pwcheck: true,
        minlength: 8,

      },
      password_confirm: {
        required: true,
        equalTo: "#password"
      }
        },
        messages:{
          password:{
            pwcheck: "a password must be eight characters including  one special character and alphanumeric characters",
            minlength: "a password must be eight characters including  one special character and alphanumeric characters"
          }
        }
  });
    
	}); 
</script> 
@stop