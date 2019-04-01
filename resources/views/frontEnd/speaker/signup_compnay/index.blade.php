@extends('frontEnd.speaker.layout.default')
@section('content')
    <div id="content-area">
        <section class="inner-banner-row" style="background-image:url({{config('constants.FRONT_END_SPEAKER.IMAGE_PATH')}}sign-up.jpg);">
            <div class="container-fluid">
                <div class="inner-banner-caption">
                    <h1>Education is priceless. Spread the Word Around. Connect with <strong>MyCPE</strong> today!</h1>
                    <p>Signing up At MyCPE unveils a plethora of opportunities for connecting with professionals from the Accounting Fraternity. As speakers for the webinars, you receive recognition and trust by professionals from your accounting industry. Furthermore, our mobile application ensures easy accessibility of your webinars from anywhere, anytime making it a preferred platform for Continuous Education On-The-Go! It promotes connecting you with all attendees and followers of your discourses, Building your credibility within your Community of Accounting & Tax Professionals. </p>
                    <ol>
                        <li> Recognition in Your Fraternity</li>
                        <li> Easy Accessibility through our Mobile App</li>
                        <li> Continuous Education On-The-Go</li>
                        <li> Detailed Information on Attendees</li>
                        <li> Get Leads to Prospects</li>
                    </ol>
                </div>
            </div>    
        </section>
        <div class="container-fluid">
            <div class="login-area">
                <div class="row">
                    <div class="col-md-12">
                        @if(Session::has('success'))
                            <div style="color:green" class="col-md-12 text-center">
                                <h5>{{Session::get('success')}}</h5>
                            </div>
                        @endif
                        {!! Form::open(['name' => 'add-company-form', 'id' => 'add-company-form','class'=>'row', 'files' => true]) !!}
                            <div class="col-md-12 text-center">
                                <h4>Create an account</h4><div class="form-group"></div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-5">
                                        
                                        <div class="form-group">
                                            <label class="control-label">Company Name <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('Enter company name'))) }}

                                            @if ($errors->has('name'))
                                            <label class="validation-invalid-label">{{ $errors->first('name') }}</label>                
                                            @endif
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label"> Contact No <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('contact_number', null, array('id' => 'contact_number', 'class' => 'form-control', 'placeholder' => __('Enter company contact number'))) }}

                                            @if ($errors->has('contact_number'))
                                            <label class="validation-invalid-label">{{ $errors->first('contact_number') }}</label>                
                                            @endif
                                        </div>

                                        <div class="form-group">
                                           <label for="avatar">Logo</label>
                                           <input type="file" name="logo" id="logo" class='form-control'>
                                            @if ($errors->has('logo'))
                                                <label class="validation-invalid-label">{{ $errors->first('logo') }}</label>      
                                            @endif
                                        </div>

                                        
                                        <div class="form-group">
                                            <label class="control-label"> Website <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('website', null, array('id' => 'website', 'class' => 'form-control', 'placeholder' => __('Enter company website'), 'autocomplete' => 'off')) }}

                                            @if ($errors->has('website'))
                                                <label class="validation-invalid-label">{{ $errors->first('website') }}</label>                
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label"> Email Address <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Enter company email address'), 'autocomplete' => 'off')) }}

                                            @if ($errors->has('email'))
                                                <label class="validation-invalid-label">{{ $errors->first('email') }}</label>                
                                            @endif
                                        </div>
    
                                        <div class="form-group">
                                            <label class="control-label">Name Of Person <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('person_name', null, array('id' => 'person_name','maxlength'=>'50', 'class' => 'form-control', 'placeholder' => __('Enter person name'))) }}

                                            @if ($errors->has('person_name'))
                                            <label class="validation-invalid-label">{{ $errors->first('person_name') }}</label>                
                                            @endif
                                        </div>

                                                                                <div class="form-group">
                                            <label class="control-label">Person Contact No <span aria-required="true" class="required"> * </span></label>
                                            {{ Form::text('person_contact_number', null, array('id' => 'person_contact_number', 'class' => 'form-control','maxlength'=>'25', 'placeholder' => __('Enter person contact number'))) }}

                                            @if ($errors->has('person_contact_number'))
                                                <label class="validation-invalid-label">{{ $errors->first('person_contact_number') }}</label>
                                            @endif
                                        </div>                                        


                                        
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                
                                    <div class="col-md-1">
                                    </div>  
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="control-label"> About Company </label>
                                            <textarea id="description" name="description" class="col-md-12">
                                                
                                            </textarea>
                                        </div>
                                       
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group"></div>
                                <div class="btn-group-md text-center">
                                    <input type="submit" class="btn btn-primary  " value="Create Account">
                                </div>
                            </div>                           
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

{{ HTML::script(config('constants.FRONT_END_SPEAKER.JS_PATH').'jquery.min.js')}}
{!! HTML::script('js/plugins/validation/validate.min.js') !!}
{!! HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') !!}
{!! HTML::script('/js/plugins/ckeditor/ckeditor.js') !!}

<script type="text/javascript">
    var FormValidation = function () {
        // Validation config
        var __addValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#add-company-form').validate({
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
                    name: {
                        required: true,
                        // noSpaceAllow: true
                        onlyCharLetter: true,
                    },
                    person_name: {
                        required: true,
                        // noSpaceAllow: true
                        onlyCharLetter: true,
                    },
                    website: {
                        required: true,
                        noSpaceAllow: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/company/check_email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    },
                    contact_number: {
                        required: true,
                        noSpace: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    person_contact_number: {
                        required: true,
                        noSpace: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter company name.",
                    },
                    person_name: {
                        required: "Please enter person name.",
                    },
                    person_contact_number: {
                        required: "Please enter person contact number.",
                        noSpace: "Contact no can not be empty.",
                        minlength: "Please enter 10 digits.",
                        maxlength: "Please enter 10 digits.",
                        number: "Only number are allowed.",
                    
                    },
                    website: {
                        required: "Please enter website.",
                    },
                    email: {
                        required: "Please enter email address.",
                        email: "Please enter valid email.",
                        remote: "Email already exists.",
                    },
                    contact_number: {
                        required: "Please enter contact no.",
                        noSpace: "Contact no can not be empty.",
                        minlength: "Please enter 10 digits.",
                        maxlength: "Please enter 10 digits.",
                        number: "Only number are allowed.",
                    },
                },
                submitHandler: function (form) {
                    // do other things for a valid form
                    if ($("#company_id").val().trim() == "" && $("#company_name").val().trim() == "") {
                        alert("Please select company or add your own company name")
                    } else {
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
        CKEDITOR.replace('description');
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
       
    });
</script>

@endSection
