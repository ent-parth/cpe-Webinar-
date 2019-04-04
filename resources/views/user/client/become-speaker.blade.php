@extends( 'layouts_front.master' )
@section( 'content' )
<div id="content-area">
  <section class="inner-banner-row" style="background-image:url(images/sign-up.jpg);">
    <div class="container-fluid">
      <div class="inner-banner-caption">
        <h1>Become a Thought Leader, Subject Matter Expert Today!</h1>
        <p>Exposure, Reach, Credibility, Loyal Followership through Education.</p>
      </div>
    </div>
  </section>
  <div class="container-fluid">
    <div class="login-area">
      <div class="row">
        <div class="col-lg-6">
          <form action="" class="row" class="" name="registerForm" id="registerForm" method="post" enctype="multipart/form-data">
            <div class="col-md-12 text-center">
              <h4>Create an account</h4>
              <div class="form-group"></div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{old('first_name') ? old('first_name') : ''}}" placeholder="First Name" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{old('last_name') ? old('last_name') : ''}}" placeholder="Last Name" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Email Id*</label>
                <input type="email" name="email" class="form-control email" value="{{old('email') ? old('email') : ''}}" placeholder="Email Address" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""> PassWord*</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Create PassWord" required >
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"></div>
              <div class="btn-group-md text-center">
                <input type="submit" class="btn btn-primary  " value="Register">
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