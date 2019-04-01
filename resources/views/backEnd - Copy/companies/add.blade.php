@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1>
    Add Company
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
            {!! Form::open(['name' => 'add-company-form', 'id' => 'add-company-form', 'files' => true]) !!}
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Company Name <span aria-required="true" class="required"> * </span></label>
                            {{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('Company name'))) }}

                            @if ($errors->has('name'))
                            <label class="validation-invalid-label">{{ $errors->first('name') }}</label>                
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Contact Number <span aria-required="true" class="required"> * </span></label>
                           {{ Form::text('contact_number', null, ["id" => "contact_number", "placeholder" => "Contact name", 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Website <span aria-required="true" class="required"> * </span></label>
                            {{ Form::text('website', null, array('id' => 'website', 'class' => 'form-control', 'placeholder' => __('Website'))) }}

                            @if ($errors->has('last_name'))
                            <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Email Address <span aria-required="true" class="required"> * </span></label>
                            {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => __('Email address'), 'autocomplete' => 'off')) }}

                            @if ($errors->has('email'))
                            <label class="validation-invalid-label">{{ $errors->first('email') }}</label>                
                            @endif
                        </div>
                       
                        <div class="form-group">
                          <label for="logo">Logo</label>
                          <input type="file" name="logo" id="logo" class='form-control'>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Status <span aria-required="true" class="required"> * </span></label>
                           {{ Form::select('status', $statusList, config('constants.STATUS.STATUS_ACTIVE'), ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Description </label>
                            <textarea id="description" name="description" class="col-md-12"></textarea>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 <div class="col-md-12 text-right">
                    <a href="{{ route('companies') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
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
                        remote: {
                            url: "/companies/check-company-name",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/companies/check-email",
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
                    website: {
                        required: true,
                        url: true
                    },
                    status: {
                        required: true
                    }

                },
                messages: {
                    name: {
                        required: "Please enter company name.",
                        remote: "Company name already exists.",
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
                    website: {
                        required: "Please enter website.",
                        url: "Please enter valid url."
                    },
                    status: {
                        required: "Please select status."
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
        jQuery.validator.addMethod("onlyCharLetter", function (value, element) {
            return this.optional(element) || /^[0-9A-Za-z\s\-\_\.]+$/.test(value);
        });
        jQuery.validator.addMethod("noSpace", function (value) {
            return value.trim() != "";
        });
    });
</script>
@endSection
