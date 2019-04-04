@extends('backEnd.layouts.admin_app')

@section('content')
<section class="content-header"> 
  <h1> User Management </h1>
</section>

<!-- If Edit Admin Then -->
{!!
    $first_name = $last_name = $email = $contact_no = $active = $act = "";
    if($data_for == "edit_admin"){ 
        $first_name = $info[0]->first_name;
        $last_name = $info[0]->last_name;
        $email = $info[0]->email;
        $contact_no = $info[0]->contact_no;
        if($info[0]->status == "active"){
            $active = "checked";
        }else{ 
            $active = "";
        }  
        $act = "Edit";
    }else{
        $act = "Add";
    }
!!}
<!--   End Edit Admin   -->

<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->  
        {!! Form::open(['name' => 'add-admin-form', 'id' => 'add_admin_form', 'files' => true]) !!}
        <div class="box-body">
            <h4>{!! $act; !!} Administrator</h4> 
            <div class="action pull-right">
                <a href="user_management" class="btn btn-primary" title="Add New"> 
                    <b><i class="fa fa-list"></i></b> List 
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">First Name :</label>
                        <input type="text" class="form-control" name="first_name" placeholoder="First Name" value="{!! $first_name; !!}" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Last Name :</label>
                        <input type="text" class="form-control" name="last_name" placeholoder="Last Name" value="{!! $last_name; !!}" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Email :</label>
                        <input type="text" class="form-control" name="email" placeholoder="Email" value="{!! $email; !!}" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Contact No :</label>
                        <input type="text" class="form-control" name="contact_no" placeholoder="Contact No" value="{!! $contact_no; !!}" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Password :</label>
                        <input type="password" class="form-control" name="password" placeholoder="Password" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Confirm-Password :</label>
                        <input type="password" class="form-control"  placeholoder="Confirm Password" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Role :</label>
                        @foreach($roles as $role)
                            <?php 
                                $selected = "";
                                if($data_for == "edit_admin"){ 
                                    if(!empty($selected_role)){ 
                                        if($role->id == $selected_role[0]->role_id){ 
                                            $selected .= "checked"; 
                                        }
                                    }
                                }
                            ?>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-11"><input type='radio' name='role_id' value='{!! $role->id !!}' {!! $selected !!} > {!! $role->display_name !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Active :</label>
                        <input type="checkbox" name="status" value="active" {!! $active; !!} />
                    </div>
                </div> 

                <div class="col-md-12"> 
                    <div class="form-group">
                        <label class="control-label">Confirmed :</label>
                        <input type="checkbox" name="Confirmed" value="1" checked />
                    </div>
                </div>
            </div>
        <!-- /.box-body -->
        
        <div class="box-footer">
            <?php 
                if($data_for == "edit_admin"){  
                    echo "<input type='hidden' name='id' value='".$info[0]->id."' >"; 
                } 
            ?>
          <div class="col-md-12 text-right"> <a href="{{ route('administrators') }}" class="btn btn-danger" title="Cancel"> Cancel </a> {{ Form::button('Save',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }} </div>
        </div>
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
/*
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
    }); */
</script> 
<script language="javascript" type="text/javascript"> 
    $(document).ready(function(){
	     $("#add-admin-form input[name='status']").on('change',function(){
            if(this.checked) {
                $(this).val('active'); 
            }else{
                $(this).val('inactive'); 
            }
        }); 
 
        $('#add_admin_form').validate({ 
            ignore: 'input[type=hidden]', // ignore hidden fields
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
                }else { 
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
                },
                password: {
                    required: true,
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
                },
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

            }
        });
    });
</script> 
@endSection 