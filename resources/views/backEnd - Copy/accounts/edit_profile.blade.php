@extends('backEnd.layouts.admin_app')

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
              <img class="profile-user-img img-responsive img-circle" src="{{asset( Auth::guard('administrator')->user()->avatar_url )}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{ Auth::guard('administrator')->user()->full_name ?: ''}}</h3>

              <p class="text-muted text-center">{{Auth::guard('administrator')->user()->role->name}}</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Personal Info</a></li>
              <!-- <li><a href="#change-avatar" data-toggle="tab">Change Avatar</a></li> -->
              <li><a href="#change-password" data-toggle="tab">Change Password</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="profile">
                    {!! Form::open(['name' => 'admin-edit-profile', 'id' => 'admin-edit-profile', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="form-group">
                            {{ Form::label('first_name', 'First Name', ["class" =>"col-sm-2 control-label"]) }}
                            <div class="col-sm-10">
                                {{ Form::text('first_name', old('first_name') ? old('first_name') :  Auth::guard('administrator')->user()->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => __('Enter first name'))) }}

                                @if ($errors->has('first_name'))
                                <label class="validation-invalid-label">{{ $errors->first('first_name') }}</label>                
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('last_name', 'Last Name', ["class" => "col-sm-2 control-label"]) }}
                            <div class="col-sm-10">
                                {{ Form::text('last_name', old('last_name') ? old('last_name') :  Auth::guard('administrator')->user()->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => __('Enter last name'))) }}

                                @if ($errors->has('last_name'))
                                <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                                @endif
                            </div>
                        </div>                                               
                        <div class="form-group">
                            {{ Form::label('email', 'Email Address', ["class" => "col-sm-2 control-label"]) }}
                            <div class="col-md-10">
                                {{ Form::text('email', old('email') ? old('email') :  Auth::guard('administrator')->user()->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Enter email address'))) }}

                                @if ($errors->has('email'))
                                <label class="validation-invalid-label">{{ $errors->first('email') }}</label>                
                                @endif
                            </div>
                        </div>
                        {!! Form::hidden('form_type', 'edit-profile' ) !!}
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                            <a href="{{ route('administrator.dashboard') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                            {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                            </div>
                        </div>
                        {!! Form::close() !!}  
                </div>
                <div class="tab-pane" id="change-avatar">
                    {!! Form::open(['name' => 'admin-edit-profile', 'id' => 'admin-edit-avatar', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="form-group">
                            {{ Form::label('avarat', 'Avatar',['class' => 'col-lg-2 col-form-label font-weight-semibold']) }}                                                    
                            {{ Form::file('avatar',['id' => 'avatar','class' => 'file-input','data-fouc'=>'data-fouc'])}}
                            @if ($errors->has('avatar'))
                            <label class="validation-invalid-label">{{ $errors->first('avatar') }}</label>                
                            @endif
                        </div>
                        <div class="text-right">
                            <a href="{{ route('administrator.dashboard') }}" class="btn btn-secondary ml-3" title="Cancel"><i class="icon-reply"></i> Cancel</a>
                            {{ Form::button('Save <i class="icon-paperplane ml-2"></i>',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                        </div>
                        {!! Form::hidden('form_type', 'edit-avatar' ) !!}
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane" id="change-password">
                    {!! Form::open(['name' => 'admin-edit-profile', 'id' => 'admin-edit-change-password', 'class' => 'form-horizontal', 'files' => true]) !!}
                        {{ Form::hidden('id', Auth::guard('administrator')->user()->id, array('id' => 'id')) }}
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
                            <a href="{{ route('administrator.dashboard') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
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
{!! HTML::script('js/plugins/uploaders/fileinput/plugins/purify.min.js') !!}
{!! HTML::script('js/plugins/uploaders/fileinput/plugins/sortable.min.js') !!}
{!! HTML::script('js/plugins/uploaders/fileinput/fileinput.min.js') !!}
{!! HTML::script('js/plugins/demo_pages/uploader_bootstrap.js') !!}
{!! HTML::script('js/plugins/validation/validate.min.js') !!}

<script type="text/javascript">

    var FormValidation = function () {
        // Validation config
        var _editProfileValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#admin-edit-profile').validate({
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
                        email: true
                    },
//                    email: {
//                        required: true,
//                        email: true,
//                        remote: {
//                            url: "/users/check-email/",
//                            type: "post",
//                            beforeSend: function (xhr) {
//                                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
//                            },
//                            data: {
//                                id: function () {
//                                    return $("#id").val();
//                                }
//                            }
//                        }
//                    },
                },
                messages: {
                    first_name: {
                        required: '<?= __('Please enter first name.') ?>',
                    },
                    last_name: {
                        required: '<?= __('Please enter last name.') ?>',
                    },
                    email: {
                        required: "<?= __('Please enter email address.'); ?>",
                        email: "<?= __('Please enter valid email address.'); ?>"
//                        remote: "<?= __('This email address already exists.'); ?>"
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
            $('#admin-edit-change-password').validate({
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
            $('#admin-edit-avatar').validate({
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
                        avatarSize: true,
                        avatarExtension: true,
                    },
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
        //
        // Return objects assigned to module
        //
        return {
            init: function () {
                _editProfileValidation();
                _changePasswordValidation();
                _editAvtarValidation();
            }
        }
    }();
    jQuery(document).ready(function () {
        FormValidation.init();
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
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            return (!allowedExtensions.exec(name)) ? false : true;
        }, 'Image must be in jpg, jpeg, bmp, gif or png format.');

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
    });
</script>
@endsection