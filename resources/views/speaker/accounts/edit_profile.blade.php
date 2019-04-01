@extends('speaker.layouts.speaker_app')

@section('content')
<section class="content-header">
  <h1>
    User Profile
  </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{asset( Auth::guard('speaker')->user()->avatar_url )}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{ Auth::guard('speaker')->user()->full_name ?: ''}}</h3>

              <p class="text-muted text-center">{{Auth::guard('speaker')->user()->company->name}}</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Personal Info</a></li>
              <li><a href="#company-detail" data-toggle="tab">Company Detail</a></li>
              <li><a href="#change-password" data-toggle="tab">Change Password</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="profile">
                    {!! Form::model(Auth::guard('speaker')->user(), ['name' => 'speaker-edit-profile', 'id' => 'speaker-edit-profile', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="form-group">
                            <label class="col-md-2 control-label"> First Name <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('first_name', Auth::guard('speaker')->user()->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => __('Enter first name'))) }}

                                @if ($errors->has('first_name'))
                                <label class="validation-invalid-label">{{ $errors->first('first_name') }}</label>                
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"> Last Name <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('last_name', Auth::guard('speaker')->user()->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => __('Enter last name'))) }}

                                @if ($errors->has('last_name'))
                                <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                                @endif
                            </div>
                        </div>                                               
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Email Address <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('email', Auth::guard('speaker')->user()->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Enter email address'), 'disabled')) }}

                                @if ($errors->has('email'))
                                <label class="validation-invalid-label">{{ $errors->first('email') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Contact No <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('contact_no', Auth::guard('speaker')->user()->contact_no, array('id' => 'contact_no', 'class' => 'form-control', 'placeholder' => __('Enter contact number'))) }}

                                @if ($errors->has('contact_no'))
                                <label class="validation-invalid-label">{{ $errors->first('contact_no') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Country <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::select('country_id', $countries, null, ["id" => "country_id", "placeholder" => "Select Country", 'class' => 'form-control select2 select-/search']) }}

                                @if ($errors->has('country_id'))
                                <label class="validation-invalid-label">{{ $errors->first('country_id') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> State <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::select('state_id', [], null, ["id" => "state_id", "placeholder" => "Select State", 'class' => 'form-control select2 select-search']) }}

                                @if ($errors->has('state_id'))
                                <label class="validation-invalid-label">{{ $errors->first('state_id') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> City <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::select('city_id', [], null, ["id" => "city_id", "placeholder" => "Select City", 'class' => 'form-control select2 select-search']) }}

                                @if ($errors->has('city_id'))
                                <label class="validation-invalid-label">{{ $errors->first('city_id') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Zip Code <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('zipcode', null, array('id' => 'zipcode', 'class' => 'form-control', 'placeholder' => __('Enter zip code'))) }}
                                @if ($errors->has('zipcode'))
                                <label class="validation-invalid-label">{{ $errors->first('zipcode') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="avatar">Avatar</label>
                            <div class="col-md-10">
                                  <input type="file" name="avatar" id="avatar" class='form-control'>

                                @if ($errors->has('avatar'))
                                    <label class="validation-invalid-label">{{ $errors->first('avatar') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Expertise </label>
                            <div class="col-md-10">
                                <textarea id="expertise" name="expertise" class="col-md-12">{{Auth::guard('speaker')->user()->expertise ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> About Speaker </label>
                            <div class="col-md-10">
                                <textarea id="about_speaker" name="about_speaker" class="col-md-12">{{Auth::guard('speaker')->user()->about_speaker ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> About Company </label>
                            <div class="col-md-10">
                                <textarea id="about_company" name="about_company" class="col-md-12">{{Auth::guard('speaker')->user()->about_company ?? ''}}</textarea>
                            </div>
                        </div>
                        {!! Form::hidden('form_type', 'edit-profile' ) !!}
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                            <a href="{{ route('speaker.dashboard') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                            {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                            </div>
                        </div>
                        {!! Form::close() !!}  
                </div>
                <div class="tab-pane" id="company-detail">
                    {!! Form::model(Auth::guard('speaker')->user()->company, ['name' => 'company-edit-profile', 'id' => 'company-edit-profile', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Name <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('Enter company name'))) }}

                                @if ($errors->has('name'))
                                <label class="validation-invalid-label">{{ $errors->first('name') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Contact No <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('contact_number', null, array('id' => 'contact_number', 'class' => 'form-control', 'placeholder' => __('Enter contact number'))) }}

                                @if ($errors->has('contact_number'))
                                <label class="validation-invalid-label">{{ $errors->first('contact_number') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="logo" class="col-md-2 control-label">Logo</label>
                          <div class="col-md-10">
                            <input type="file" name="logo" id="logo" class='form-control'>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Website <span aria-required="true" class="required"> * </span></label>
                            <div class="col-md-10">
                                {{ Form::text('website', null, array('id' => 'website', 'class' => 'form-control', 'placeholder' => __('Enter website'))) }}

                                @if ($errors->has('website'))
                                <label class="validation-invalid-label">{{ $errors->first('website') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> Description </label>
                            <div class="col-md-10">
                                <textarea id="description" name="description" class="col-md-12">{{Auth::guard('speaker')->user()->company->description ?? ''}}</textarea>
                            </div>
                        </div>
                        {!! Form::hidden('form_type', 'edit-company' ) !!}
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                            <a href="{{ route('speaker.dashboard') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                            {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                            </div>
                        </div>
                    {!! Form::close() !!}  
                </div>
                <div class="tab-pane" id="change-password">
                    {!! Form::open(['name' => 'speaker-edit-profile', 'id' => 'speaker-edit-change-password', 'class' => 'form-horizontal', 'files' => true]) !!}
                        {{ Form::hidden('id', Auth::guard('speaker')->user()->id, array('id' => 'id')) }}
                        <div class="form-group">
                            {{ Form::label('current_password', 'Current Password', ["class" =>"col-sm-3 control-label"]) }}
                            <div class="col-md-9">
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password">

                                @if ($errors->has('current_password'))
                                <label class="validation-invalid-label">{{ $errors->first('current_password') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('new_password', 'New Password', ["class" =>"col-sm-3 control-label"]) }}                                
                            <div class="col-md-9">
                                {{ Form::password('new_password', array('id' => 'new_password', 'class' => 'col-md-8 form-control', 'placeholder' => __('Enter new password'))) }}
                                <!-- <span class="input-group-btn col-md-2 generate-password-block">
                                    <button id="genpassword" class="btn bg-teal generate_password" type="button" title="Generate password">
                                        <i class="fa fa-arrow-left fa-fw"></i> Generate Password
                                    </button>
                                </span> -->
                                @if ($errors->has('new_password'))
                                <label class="validation-invalid-label">{{ $errors->first('new_password') }}</label>          
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('confirm_password', 'Confirm Password', ["class" =>"col-sm-3  control-label"]) }}
                            <div class="col-md-9">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter confirm password">

                                @if ($errors->has('confirm_password'))
                                <label class="validation-invalid-label">{{ $errors->first('confirm_password') }}</label>        
                                @endif                           
                            </div>                                                 
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label col-md-3 generated-password">{{ __('messages.generated_password')}}</label>
                            <div class="col-md-9 password-value help-block" style="margin-top: 8px"></div>
                        </div> -->
                        <div class="text-right">
                            <a href="{{ route('speaker.dashboard') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                            {{ Form::button('Save <i class="icon-paperplane ml-2"></i>',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                        </div>
                        {!! Form::hidden('form_type', 'edit-change-password' ) !!}
                    {!! Form::close() !!}
                </div>
            </div>
    </div>
</section>
@endsection
@section('js')
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}

<script type="text/javascript">

    var FormValidation = function () {
        // Validation config
        var _editProfileValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#speaker-edit-profile').validate({
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
                    }
                    // Other elements
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/speakers/check_email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                id: "<?= Auth::guard('speaker')->user()->id?>"
                            }
                        }
                    },
                    contact_no: {
                        required: true,
                        minlength: 7,
                        maxlength: 14,
                        number: true
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
                    },
                    avatar: {
                        avatarExtension:"jpg,png,jpeg,gif",
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    }
                },
                messages: {
                    first_name: {
                        required: '<?= __('Please enter first name.') ?>',
                    },
                    last_name: {
                        required: '<?= __('Please enter last name.') ?>',
                    },
                    /*email: {
                        required: "Please enter email address.",
                        email: "Please enter valid email.",
                        remote: "Email already exists.",
                    },*/
                    contact_no: {
                        required: "Please enter contact no.",
                        noSpace: "Contact no can not be empty.",
                        minlength: "Please enter minimum 7 digits.",
                        maxlength: "Please enter maximum 14 digits.",
                        number: "Only number are allowed.",
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
                }
            });
        };
        var _changePasswordValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#speaker-edit-change-password').validate({
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
                    }
                    // Other elements
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    current_password: {
                        remote: {
                            url: "/account/check-password",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                id: function () {
                                    return $("#id").val();
                                }
                            },
                            complete: function (data) {
                                var result = data.responseText;
                                if (result === 'false') {
                                    $('#genpassword').attr('disabled', 'disabled');
                                    $('#new_password').attr('disabled', 'disabled');
                                    $('#confirm_password').attr('disabled', 'disabled');
                                } else {
                                    $('#genpassword').removeAttr('disabled');
                                    $('#new_password').removeAttr('disabled');
                                    $('#confirm_password').removeAttr('disabled');
                                }
                            }
                        }
                    },
                    new_password: {
                        required: true,
                        customPassword: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    current_password: {
                        required: "<?= __('Please enter current password.'); ?>",
                        remote: "<?= __('Your current password is wrong. Please enter correct password.'); ?>"
                    },
                    new_password: {
                        required: "<?= __('Please enter new password.'); ?>",
                        customPassword: "<?= __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'); ?>"
                    },
                    confirm_password: {
                        required: "<?= __('Please enter confirm password.'); ?>",
                        equalTo: "<?= __('Password does not match.'); ?>"
                    },
                },
                submitHandler: function (form) {
                    $('.bong-loader').css('display', 'block');
                    success.show();
                    error.hide();
                    form.submit();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "new_password") {
                        error.insertAfter(element.parent("div"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        };
        var _editAvtarValidation = function () {
            // Initialize
            $('#speaker-edit-avatar').validate({
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
                rules: {
                    avatar: {
                        fileExtension:"jpg,png,jpeg,gif"
                    }
                },
                messages: {
                    avatar: {
                    },
                },
                errorPlacement: function (error, element) {
                    if (element.parents().hasClass('form-check')) {
                        console.log(1);
                        error.appendTo(element.parents('.form-check').parent());
                    } else if (element.attr("name") == "avatar") {
                        console.log(3);
                        error.insertAfter(element.parent("div").parent().parent().parent());
                    } else {
                        console.log(4);
                        error.insertAfter(element);
                    }
                },
            });
        };
        var _editCompanyProfileValidation = function () {
            // Initialize
            $('#company-edit-profile').validate({
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
                rules: {
                    logo: {
                        fileExtension:"jpg,png,jpeg,gif"
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.parents().hasClass('form-check')) {
                        console.log(1);
                        error.appendTo(element.parents('.form-check').parent());
                    } else if (element.attr("name") == "avatar") {
                        console.log(3);
                        error.insertAfter(element.parent("div").parent().parent().parent());
                    } else {
                        console.log(4);
                        error.insertAfter(element);
                    }
                },
            });
        };
        //
        // Return objects assigned to module
        //
        return {
            init: function () {
                _editProfileValidation();
                _changePasswordValidation();
                _editAvtarValidation();
                _editCompanyProfileValidation();
            }
        }
    }();
    jQuery(document).ready(function () {
        FormValidation.init();
        CKEDITOR.replace('expertise');
        CKEDITOR.replace('about_speaker');
        CKEDITOR.replace('about_company');
        CKEDITOR.replace('description');
        $('.select2').select2();
        jQuery.validator.addMethod("avatarSize", function (value, element) {
            var avatarName = $("#avatar").val();
            if (avatarName != '') {
                var size = ($("#avatar")[0].files[0].size / 1024 / 1024).toFixed(2);
                if (size > 2) {
                    return false;
                }
                return true;
            }
        }, 'Avatar size must 2mb or below.');
        jQuery.validator.addMethod("avatarExtension", function (value, element) {
            var name = $("#avatar").val();
            if (name.trim() !== '') {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                return (!allowedExtensions.exec(name)) ? false : true;
            } else {
                return true;
            }
        }, 'Image must be in jpg, jpeg, png or gif format.');
        jQuery.validator.addMethod("fileExtension", function (value, element) {
            var name = $("#logo").val();
            if (name.trim() !== '') {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                return (!allowedExtensions.exec(name)) ? false : true;
            } else {
                return true;
            }
        }, 'Image must be in jpg, jpeg, png or gif format.');

        $('.generated-password').hide();
        function passwordGenerator(no)
        {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-";
            for (var i = 0; i < no; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }
        $('.generate_password').on('click', function () {
            $('#new_password-error').hide();
            $('#confirm_password-error').hide();
            var text = passwordGenerator(10);
            $('.password-value').text(text);
            $('.generated-password').removeClass('hidden').show();
            $('#new_password').val(text);
            $('#confirm_password').val(text);
        });
        $('#new_password').keyup(function () {
            $('.generated-password').addClass('hidden').hide();
            $('.password-value').text('');
        });

        $('#country_id, #state_id').on('change', function (e) {
            e.preventDefault();
            var id = $(this).attr('id')
            if (id == 'country_id') {
                var url = '/states/get-state';
                $('#city_id').html("<option value=''>Select City</option>");
                var selectedId = "<?= Auth::guard('speaker')->user()->state_id?>";
            } else if (id == 'state_id') {
                var url = '/cities/get-city';
                var selectedId = "<?= Auth::guard('speaker')->user()->city_id?>";
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
                        $('#state_id [value=' + selectedId + ']').prop('selected', true);
                        if (edit) {
                            edit = false;
                            $("#state_id").change();
                        }
                    } else if (id == 'state_id') {
                        $('#city_id').html("<option value=''>Select City</option>");
                        $.each(resp, function (key, element) {
                            $('#city_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                        $('#city_id [value=' + selectedId + ']').prop('selected', true);
                    }
                }
            });
        });
        var edit = true;
        $("#country_id").change()
    });
</script>
@endsection