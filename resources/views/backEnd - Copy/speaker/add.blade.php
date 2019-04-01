@extends('backEnd.layouts.speaker_register')
@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="javascript:void(0);">Speaker Sign Up</a>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['name' => 'add-speaker-form', 'id' => 'add-speaker-form', 'files' => true]) !!}
                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"> First Name <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('first_name', null, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => __('First name'))) }}

                                @if ($errors->has('first_name'))
                                <label class="validation-invalid-label">{{ $errors->first('first_name') }}</label>                
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Email Address <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Email address'), 'autocomplete' => 'off')) }}

                                @if ($errors->has('email'))
                                <label class="validation-invalid-label">{{ $errors->first('email') }}</label>                
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Select Company <span aria-required="true" class="required"> * </span></label>
                               {{ Form::select('company_id', $companyList, null, ["id" => "company_id", "placeholder" => "Select Company", 'class' => 'form-control select2 select-search']) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Password <span aria-required="true" class="required"> * </span></label>
                                {{ Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => __('Password'))) }}

                                @if ($errors->has('password'))
                                <label class="validation-invalid-label">{{ $errors->first('password') }}</label>                
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Country <span aria-required="true" class="required"> * </span></label>
                                {{ Form::select('country_id', $countries, null, ["id" => "country_id", "placeholder" => "Select Country", 'class' => 'form-control select2 select-/search']) }}

                                @if ($errors->has('country_id'))
                                    <label class="validation-invalid-label">{{ $errors->first('country_id') }}</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> State <span aria-required="true" class="required"> * </span></label>
                                {{ Form::select('state_id', [], null, ["id" => "state_id", "placeholder" => "Select State", 'class' => 'form-control select2 select-search']) }}

                                @if ($errors->has('state_id'))
                                    <label class="validation-invalid-label">{{ $errors->first('state_id') }}</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> City <span aria-required="true" class="required"> * </span></label>
                                {{ Form::select('city_id', [], null, ["id" => "city_id", "placeholder" => "Select City", 'class' => 'form-control select2 select-search']) }}

                                @if ($errors->has('city_id'))
                                    <label class="validation-invalid-label">{{ $errors->first('city_id') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Last Name <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('last_name', null, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => __('Last name'))) }}

                                @if ($errors->has('last_name'))
                                <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Contact No <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('contact_no', null, array('id' => 'contact_no', 'class' => 'form-control', 'placeholder' => __('Contact number'))) }}

                                @if ($errors->has('contact_no'))
                                <label class="validation-invalid-label">{{ $errors->first('contact_no') }}</label>                
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> OR </label>
                               {{ Form::Text('companies[name]', null, ["id" => "company_name", "placeholder" => "Company Name", 'class' => 'form-control select-search']) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Confirm Password <span aria-required="true" class="required"> * </span></label>
                                {{ Form::password('confirm_password', array('id' => 'confirm_password', 'class' => 'form-control', 'placeholder' => __('Confirm password'))) }}

                                @if ($errors->has('confirm_password'))
                                <label class="validation-invalid-label">{{ $errors->first('confirm_password') }}</label>                
                                @endif
                            </div>
                            <div class="form-group">
                              <label for="avatar">Avatar</label>
                              <input type="file" name="avatar" id="avatar" class='form-control'>

                            @if ($errors->has('avatar'))
                                <label class="validation-invalid-label">{{ $errors->first('avatar') }}</label>                
                            @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Zip Code <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('zipcode', null, array('id' => 'zipcode', 'class' => 'form-control', 'placeholder' => __('Zip code'))) }}

                                @if ($errors->has('zipcode'))
                                <label class="validation-invalid-label">{{ $errors->first('zipcode') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Expertise </label>
                                <textarea id="expertise" name="expertise" class="col-md-12">
                                    
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> About Speaker </label>
                                <textarea id="about_speaker" name="about_speaker" class="col-md-12">
                                    
                                </textarea>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label"> About Company </label>
                                <textarea id="about_company" name="about_company" class="col-md-12">
                                    
                                </textarea>
                            </div> -->
                        </div>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                     <div class="col-md-12 text-right">
                        <a href="{{ route('speakers') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                        {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                    </div>
                  </div>
                {!! Form::close() !!}
              </div>
              <!-- /.box -->
            </div>
        </div>
    </section>
</div>
@endSection

@section('js')
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
<script type="text/javascript">
    var FormValidation = function () {
        // Validation config
        var __addValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#add-speaker-form').validate({
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
                    } else if (element.attr("name") == "password" || element.attr("name") == "confirm_password") {
                        error.insertAfter(element.parent("div"));
                    } else if (element.attr("name") == "status" || element.attr("name") == "country_id" || element.attr("name") == "state_id" || element.attr("name") == "city_id") {
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
                            url: "/speakers/check_email",
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
                    contact_no: {
                        required: true,
                        noSpace: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    status: {
                        required: true
                    },
                    country_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    city_id: {
                        required: true
                    },
                    zipcode: {
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
                    contact_no: {
                        required: "Please enter contact no.",
                        noSpace: "Contact no can not be empty.",
                        minlength: "Please enter 10 digits.",
                        maxlength: "Please enter 10 digits.",
                        number: "Only number are allowed.",
                    },
                    status: {
                        required: "Please select status."
                    },
                    country_id: {
                        required: "Please select country."
                    },
                    state_id: {
                        required: "Please select state."
                    },
                    city_id: {
                        required: "Please select city."
                    },
                    zipcode: {
                        required: "Please enter zip code."
                    }

                },
                submitHandler: function (form) {
                    // do other things for a valid form
                    if ($("#company_id").val().trim() == "" && $("#company_name").val().trim() == "") {
                        alert("Please select company or add your own company name")
                    } else {
                        console.log(1)
                        form.submit();
                    }
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
        CKEDITOR.replace('expertise');
        CKEDITOR.replace('about_speaker');
        //CKEDITOR.replace('about_company');
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
        $('#country_id, #state_id').on('change', function (e) {
            e.preventDefault();
            var id = $(this).attr('id')
            if (id == 'country_id') {
                var url = '/states/get-state';
                $('#city_id').html("<option value=''>Select City</option>");
            } else if (id == 'state_id') {
                var url = '/cities/get-city';
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                data: {'id': $(this).val()},
                url: url,
                success: function (resp) {
                    if (id == 'country_id') {
                        $('#state_id').html("<option value=''>Select State</option>");
                        $.each(resp, function (key, element) {
                            $('#state_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    } else if (id == 'state_id') {
                        $('#city_id').html("<option value=''>Select City</option>");
                        $.each(resp, function (key, element) {
                            $('#city_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                }
            });
        });
    });
</script>
@endSection
