@extends('backEnd.layouts.admin_login')
@section('content')



<div class="login-box-body">
  <p class="login-box-msg">Change Password</p>
  <form class="" action="{{route('company-update-password')}}" method="post"  id="change_password_form">
  <div class="form-group has-feedback"> 
	<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
  </div>
  
  <div class="form-group has-feedback"> 
  	<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Con Password" required>
  </div>
  
  
  <div class="row"> 
    <!--.col -->
    <div class="col-xs-4 pull-right">
      <input type="submit" class="btn btn-primary btn-block" value="Update">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="data" value="{{ $encEmail }}">
    </div>
    <!--.col --> 
  </div>
  </form> </div>
@endsection
@section('js') 
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
@endsection 
