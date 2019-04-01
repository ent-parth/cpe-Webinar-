@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1>
    Edit Company
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
            {!! Form::model($company, ['name' => 'edit-company-form', 'id' => 'edit-company-form', 'files' => true]) !!}
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

                            @if ($errors->has('contact_number'))
                            <label class="validation-invalid-label">{{ $errors->first('contact_number') }}</label>                
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Website <span aria-required="true" class="required"> * </span></label>
                            {{ Form::text('website', null, array('id' => 'website', 'class' => 'form-control', 'placeholder' => __('Website'))) }}

                            @if ($errors->has('last_name'))
                            <label class="validation-invalid-label">{{ $errors->first('last_name') }}</label>
                            @endif
                            <label class="note-label">Ex: http://example.com or https://example.com</label>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Country <span aria-required="true" class="required"> * </span></label>
                            {{ Form::select('country_id', $countries, null, ["id" => "country_id", "placeholder" => "Select Country", 'class' => 'form-control select2 select-/search']) }}

                            @if ($errors->has('country_id'))
                                <label class="validation-invalid-label">{{ $errors->first('country_id') }}</label>
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
                           {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label"> State <span aria-required="true" class="required"> * </span></label>
                            {{ Form::select('state_id', [], null, ["id" => "state_id", "placeholder" => "Select State", 'class' => 'form-control select2 select-search']) }}

                            @if ($errors->has('state_id'))
                                <label class="validation-invalid-label">{{ $errors->first('state_id') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Description </label>
                            <textarea id="description" name="description" class="col-md-12">{{ $company->description }}</textarea>
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
            $('#edit-company-form').validate({
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
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                id: "<?= $company->id ?>"
                            }
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "/companies/check-email",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                id: "<?= $company->id ?>"
                            }
                        }
                    },
                    contact_number: {
                        required: true,
                        noSpace: true,
                        minlength: 7,
                        maxlength: 14,
                        number: true
                    },
                    website: {
                        required: true,
                        url: true
                    },
                    status: {
                        required: true
                    },
                    logo: {
                        fileExtension:"jpg,png,jpeg,gif"
                    },
                    country_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    city_id: {
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
                        minlength: "Please enter minimum 7 digits.",
                        maxlength: "Please enter maximum 14 digits.",
                        number: "Only number are allowed.",
                    },
                    website: {
                        required: "Please enter website.",
                        url: "Please enter valid url."
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
        jQuery.validator.addMethod("fileExtension", function (value, element) {
            var name = $("#logo").val();
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
                var selectedId = "<?= $company->state_id?>";
            } else if (id == 'state_id') {
                var url = '/cities/get-city';
                var selectedId = "<?= $company->city_id?>";
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
        $("#country_id").change();
    });
</script>
@endSection
