@extends('layouts_comingsoon.master' )
@section( 'content' )
<div id="content-area">
  <section class="inner-banner-row" style="background-image:url(images/banner-bg.png);">
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
        <div class="col-lg-6">
          <form action="{{route('comingsoon-client-store')}}" class="row"  name="registerForm" id="registerForm" method="post">
            <div class="col-md-12 text-center">
              <h4>Register</h4>
              <div class="form-group"></div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Company Name*</label>
                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Email Id*</label>
                <input type="email" name="email" id="email" class="form-control email" placeholder="Email Address" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for=""> PassWord*</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> </div>
              <div class="btn-group-md text-center">
                <input type="submit" class="btn btn-primary" value="Register">
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

jQuery.validator.addMethod("pwcheck", function(value, element) {
      return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
  }, "Ingrese una contraseña válida con mayúsculas y minúsculas"); 

 	$("#registerForm").validate({
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