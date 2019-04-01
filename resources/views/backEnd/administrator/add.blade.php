@extends('backEnd.layouts.admin_app')

@section('content')
<section class="content-header">
  <h1> Add Administrator </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start --> 
        {!! Form::open(['name' => 'add-admin-form', 'id' => 'add-admin-form', 'files' => true]) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"> First Name <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('first_name', null, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => __('First name'))) }}
                
                @if ($errors->has('first_name'))
                <label class="validation-invalid-label">{{ $errors->first('first_name') }}</label>
                @endif </div>
              <div class="form-group">
                <label class="control-label"> Email Address <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Email address'), 'autocomplete' => 'off')) }}
                
                @if ($errors->has('email'))
                <label class="validation-invalid-label">{{ $errors->first('email') }}</label>
                @endif </div>
              <!--<div class="form-group">
                        <label class="control-label"> Role <span aria-required="true" class="required"> * </span></label>
                       {{ Form::select('role_id', $roleList, null, ["id" => "role_id", "placeholder" => "Select Role", 'class' => 'form-control select2 select-search']) }}
                    </div>-->
              <div class="form-group">
                <label class="control-label"> Password <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('password', null, array('id' => 'password', 'class' => 'form-control', 'placeholder' => __('Password'))) }}
                
                @if ($errors->has('password'))
                <label class="validation-invalid-label">{{ $errors->first('password') }}</label>
                @endif </div>
              <div class="form-group">
                <label class="control-label"> Confirm Password <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('confirm_password', null, array('id' => 'confirm_password', 'class' => 'form-control', 'placeholder' => __('Confirm password'))) }}
                
                @if ($errors->has('confirm_password'))
                <label class="validation-invalid-label">{{ $errors->first('confirm_password') }}</label>
                @endif </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label"> Last Name <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('last_name', null, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => __('Last name'))) }}
                
                @if ($errors->has('last_name'))
                <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                @endif </div>
              <div class="form-group">
                <label class="control-label"> Contact No <span aria-required="true" class="required"> * </span></label>
                {{ Form::text('contact_no', null, array('id' => 'contact_no', 'class' => 'form-control', 'placeholder' => __('Contact number'))) }}
                
                @if ($errors->has('contact_no'))
                <label class="validation-invalid-label">{{ $errors->first('contact_no') }}</label>
                @endif </div>
              <div class="form-group">
                <label class="control-label"> Status <span aria-required="true" class="required"> * </span></label>
                {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }} </div>
            </div>
          </div>
          @if(CommonHelper::checkLoginUserPermission('permission_add', Auth::guard('administrator')->user()->id))
          <div class="form-group form-md-checkboxes">
            <label class="col-md-3 control-label" for="form_control_1">Permission</label>
            <div class="col-md-9">
              <div>
                <input type="checkbox" id="select_all_permissions" />
                Select All</div>
              <div class="md-checkbox-list"> 
              @php $permission_title_old = '';@endphp
                @forelse ($permissions as $permission)
                @php
                $permission_arr = explode('_', $permission->name);
                if(count($permission_arr) > 2) { 
                $permission_title = $permission_arr[0].' '.$permission_arr[1];
                } else {
                $permission_title = $permission_arr[0]; 	 
                }
                $permision_name = $permission_arr[1];
                if($permission_title_old != $permission_title) { @endphp
                <h3> {{ $permission_title }}</h3>
                @php } @endphp
                <div class="md-checkbox">
                  <input type="checkbox" name="permission[]" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" data-parsley-mincheck="2"  class="md-check" />
                  <label for="permission_{{ $permission->id }}"> <span></span> <span class="check"></span> <span class="box"></span> {{ $permission->display_name }} </label>
                </div>
                @php
                if(count($permission_arr) > 2) { 
                $permission_title_old = $permission_arr[0].' '.$permission_arr[1];
                } else {
                $permission_title_old = $permission_arr[0]; 	 
                } 
                @endphp
                @empty
                <p style="padding: 5px;">No Permission Available.</p>
                @endforelse 
               </div>
            </div>
          </div>
          @endif </div>
        <!-- /.box-body -->
        
        <div class="box-footer">
          <div class="col-md-12 text-right"> <a href="{{ route('administrators') }}" class="btn btn-danger" title="Cancel"> Cancel </a> {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }} </div>
        </div>
        {!! Form::close() !!} </div>
      <!-- /.box --> 
    </div>
  </div>
  <!-- /.row --> 
</section>
<!-- /.content --> 
@endsection
@section('js')
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }} 
<script type="text/javascript">
    var FormValidation = function () {
        // Validation config
        var __addValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#add-admin-form').validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                // Different components require proper error label placement
                errorPlacement: function (error, element) {
                    // Unstyled checkboxes, radios
                    if (element.parents().hasClass('form-check')) {
                        error.appendTo(element.parents('.form-check').parent());
                    } else if (element.attr("name") == "role_id") {
                        error.insertAfter(element.parent("div"));
                    } else if (element.attr("name") == "password" || element.attr("name") == "confirm_password") {
                        error.insertAfter(element.parent("div"));
                    } else if (element.attr("name") == "status") {
                        error.insertAfter(element.parent("div"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    first_name: {
                        required: true,
                        // noSpaceAllow: true
                        onlyCharLetter: true,
                    },
                    last_name: {
                        required: true,
                        // noSpaceAllow: true,
                        onlyCharLetter: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/account/check_email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    },
                    password: {
                        required: true,
                        customPassword: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    },
                    role_id: {
                        required: true,
                    },
                    contact_no: {
                        required: true,
                        noSpace: true,
                        minlength: 7,
                        maxlength: 14,
                        number: true
                    },
                    status: {
                        required: true
                    }

                },
                messages: {
                    first_name: {
                        required: "Please enter first name.",
                    },
                    last_name: {
                        required: "Please enter last name.",
                    },
                    email: {
                        required: "Please enter email address.",
                        email: "Please enter valid email.",
                        remote: "Email already exists.",
                    },
                    password: {
                        required: "Please enter password",
                        customPassword: "Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter."
                    },
                    confirm_password: {
                        equalTo: "Password and confirm password do not match.",
                        required: "Please enter confirm password.   "
                    },
                    role_id: {
                        required: "Please select role."
                    },
                    contact_no: {
                        required: "Please enter contact no.",
                        noSpace: "Contact no can not be empty.",
                        minlength: "Please enter minimum 7 digits.",
                        maxlength: "Please enter maximum 14 digits.",
                        number: "Only number are allowed.",
                    },
                    status: {
                        required: "Please select status."
                    }


                },
                submitHandler: function (form) {
                    // do other things for a valid form
                    $('.custom-loader').css('display', 'block');
                    form.submit();
                }
            });
        };

        return {
            init: function () {
                __addValidation();
            }
        }
    }();
    jQuery(document).ready(function () {
        FormValidation.init();
        $('.select2').select2();
        jQuery.validator.addMethod("customPassword", function (value, element) {
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(value);
        }, 'messages.custom_password_validation');

        jQuery.validator.addMethod("onlyCharLetter", function (value, element) {
            return this.optional(element) || /^[0-9A-Za-z\s\-\_\.]+$/.test(value);
        });
        jQuery.validator.addMethod("noSpace", function (value) {
            return value.trim() != "";
        });
        $('.generated-password-main-div').hide();
        function passwordGenerator(no) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-";
            for (var i = 0; i < no; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }

        $('.generate_password').on('click', function () {
            $('#password-error').hide();
            $('#confirm_password-error').hide();
            var text = passwordGenerator(10);
            $('.password-value').text(text);
            $('.generated-password-main-div').show();
            $('#password').val(text);
            $('#confirm_password').val(text);
        });

        $('#password').keyup(function () {
            $('.generated-password-main-div').hide();
            $('.password-value').text('');
        });
        $("#role_id").on('change', function () {
            if ($(this).val() == "<?= config("constants.ROLE.SUB_ADMIN_ROLE") ?>") {
                $(".permissions-div").show();
            } else {
                $(".permissions-div").hide();
            }
        });
    });
</script> 
<script language="javascript" type="text/javascript">
	$("#select_all_permissions").on('click',function() {   
		if($(this).prop("checked")){
			$("input[type=checkbox].md-check").prop("checked",true);
		}else{
			$("input[type=checkbox].md-check").prop("checked",false);
		}
	});
</script> 
@endSection 