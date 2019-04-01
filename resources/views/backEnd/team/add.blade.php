@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1>
    Add Team Member
  </h1>
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
            {!! Form::open(['name' => 'add-team-form', 'id' => 'add-team-form', 'files' => true]) !!}
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
                            <label class="control-label"> Designation <span aria-required="true" class="required"> * </span></label>
                            {{ Form::text('designation', null, array('id' => 'designation', 'class' => 'form-control', 'placeholder' => __('Designation'))) }}

                            @if ($errors->has('Designation'))
                            <label class="validation-invalid-label">{{ $errors->first('designation') }}</label>                
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
                          <label for="avatar">Avatar</label>
                          <input type="file" name="avatar" id="avatar" class='form-control'>

                        @if ($errors->has('avatar'))
                            <label class="validation-invalid-label">{{ $errors->first('avatar') }}</label>                
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Status <span aria-required="true" class="required"> * </span></label>
                           {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Description </label>
                            <textarea id="description" name="description" class="col-md-12">
                                
                            </textarea>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 <div class="col-md-12 text-right">
                    <a href="{{ route('team') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                    {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                </div>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('js')
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
<script type="text/javascript">
    var FormValidation = function () {
        // Validation config
        var __addValidation = function () {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }
            // Initialize
            $('#add-team-form').validate({
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
                            url: "/team/check-email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    },
                    designation: {
                        required: true,
                        // noSpaceAllow: true,
                        onlyCharLetter: true,
                    },
                    status: {
                        required: true
                    },
                    avatar: {
                        fileExtension:"jpg,png,jpeg,gif"
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
                    status: {
                        required: "Please select status."
                    },
                    designation: {
                        required: "Please enter designation.",
                    }

                },
                submitHandler: function (form) {
                    // do other things for a valid form
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
        jQuery.validator.addMethod("fileExtension", function (value, element) {
            var name = $("#avatar").val();
            if (name.trim() !== '') {
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                return (!allowedExtensions.exec(name)) ? false : true;
            } else {
                return true;
            }
        }, 'Image must be in jpg, jpeg, png or gif format.');
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
