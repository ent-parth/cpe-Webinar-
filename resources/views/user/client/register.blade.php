@extends( 'layouts_front.master' )
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
          <form action="{{route('client.store')}}" class="row"  name="registerForm" id="registerForm" method="post">
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
                <label for="">Mobile Number*</label>
                <input type="text" name="contact_no" class="form-control number" maxlength="14" minlength="7" value="{{old('contact_no') ? old('contact_no') : ''}}" placeholder="Mobile Number" required>
              </div>
            </div>
             <div class="col-lg-6">
              <div class="form-group">
                <label for="">Time Zone*</label>
                 <select name="time_zone" id="time_zone" class="form-control" required>
                      <option value="">Select time zone</option>
                      @foreach(config('constants.TIME_ZONE') as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Country*</label>
                 <select name="country_id" id="country_id" class="form-control" required>
                          <option value="">Select Country</option>
                          @foreach($Countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                          @endforeach
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">States*</label>
                 <select name="state_id" id="state_id" class="form-control" required>
                          <option value="">Select State</option>
                          @foreach($States as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                          @endforeach
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Cities*</label>
                 <select name="city_id" id="city_id" class="form-control" required>
                          <option value="">Select City</option>
                          @foreach($Cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                          @endforeach
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Create PassWord*</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Create PassWord" required >
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Confirm Password*</label>
                <input type="password" id="password_confirm" name="password_confirm"  class="form-control" placeholder="Confirm PassWord" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Firm Name</label>
                <input type="text" name="firm_name" value="{{old('firm_name') ? old('firm_name') : ''}}" class="form-control" placeholder="Company Name">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Topic of interest*</label>
                <select name="tag[]" id="tag" class="form-control selecttwo"  multiple="multiple" required="required">
                  @foreach($tag as $tg)
                  <option value="{{$tg->id}}">{{$tg->tag}} </option>
                  @endforeach 
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Who Are You*</label>
                <select name="user_type_id" name="user_type_id" id="user_type_id" class="selecttwo form-control" required="required">
                    @foreach($user_type as $ut)
                    	<option value="{{$ut->id}}">{{$ut->name}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            
            
            <div class="col-md-12">
              <div class="form-group">
                <label for="">I have read and agree to the <a href="javacript:void(0)" target="_blank">Terms and condition</a> by clicking Create Account button.</label>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group"></div>
              <div class="btn-group-md text-center">
                <input type="submit" class="btn btn-primary  " value="Create Account">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 offset-lg-1 login-form">
          <form class="" action="{{route('client.check')}}" method="post"  id="login_form">
            <div class="col-md-12 text-center">
              <h4>Sign In</h4>
              <div class="form-group"></div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Email Id*</label>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for=""> PassWord*</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> </div>
              <a href="{{route('client.forgotpassword')}}"> Forgot Password ? </a>
              <div class="btn-group-md text-center">
                <input type="submit" class="btn btn-primary" value="Login">
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

		$('#tag').select2({placeholder: "Select Topic of interest"});
		$('#user_type_id').select2({placeholder: "Select Who Are You"});
		$('#time_zone').select2({placeholder: "Select Time Zone"});
		$('#country_id').select2({placeholder: "Select Country"});
		$('#state_id').select2({placeholder: "Select State"});
		$('#city_id').select2({placeholder: "Select City"});


  

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
	
	$("#login_form").validate();

});	
	</script> 
@stop