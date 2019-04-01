@extends('backEnd.layouts.admin_app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">

        {!! Breadcrumbs::render('PermissionAdd') !!}


    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">


        <!-- Centered forms -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">


                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="justified-right-icon-tab1">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="profile">
                                        {!! Form::open(['name' => 'add-permission-form', 'id' => 'add-permission-form', 'class' => 'form-horizontal']) !!}
                                        {{ Form::hidden('form_type', 'add') }}
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="first_name">Title<span
                                                                class="text-danger"> * </span></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{ Form::text('title', old('title') ? old('title') :  '', ['id' => 'title', 'placeholder' => 'Title', 'class' => 'form-control']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="first_name">Parent Id<span
                                                                class="text-danger"> * </span></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{ Form::select('parent_id', $permissions, null, ['id' => 'parent_id', 'class' => 'form-control select-search']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="first_name">Permission Key<span
                                                                class="text-danger"> * </span></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{ Form::text('permission_key', old('permission_key') ? old('permission_key') :  '', ['id' => 'permission_key', 'placeholder' => 'Permission Key', 'class' => 'form-control']) }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('permissions') }}" class="btn btn-secondary ml-3"><i
                                                        class="icon-reply"></i> Cancel</a>
                                            <button type="submit" class="btn btn-primary ml-3">Save<i
                                                        class="icon-paperplane ml-2"></i></button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /form centered -->


    </div>
    <!-- /content area -->



@endsection
@section('js')
    {{ HTML::script('js/plugins/uploaders/fileinput/fileinput.min.js') }}
    {{ HTML::script('js/plugins/demo_pages/uploader_bootstrap.js') }}
    {{ HTML::script('js/plugins/validation/validate.min.js') }}
    {{ HTML::script('js/plugins/forms/selects/select2.min.js') }}
    {{ Html::script('/js/form_select2.js') }}

    <script type="text/javascript">
        //    $('.generated-password').hide();
        //== Class definition
        var FormValidation = function () {
            // Validation config
            var __addValidation = function () {
                if (!$().validate) {
                    console.warn('Warning - validate.min.js is not loaded.');
                    return;
                }
                // Initialize
                $('#add-permission-form').validate({
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
                        title: {
                            required: true,
                            // noSpaceAllow: true
                        },
                        parent_id: {
                            // required: true,
                            // noSpaceAllow: true,
                        },
                        permission_key: {
                            required: true,
                            // email: true,
                            // remote: {
                            //     url: "/account/check_email",
                            //     type: "post",
                            //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                            // }
                        },
                    },
                    messages: {
                        title: {
                            required: "<?= __('Please enter title.'); ?>",
                        },
                        permission_key: {
                            required: "<?= __('Please enter permission key'); ?>",
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
        });
    </script>
@endSection

