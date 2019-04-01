<div class="modal-dialog modal-md">
    <div class="modal-content">
        {!! Form::open(['name' => 'add-role', 'id' => 'add-role-form', 'class' => 'form-horizontal', 'files' => false]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Role</h4>
        </div>
        <div class="modal-body">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"> Name <span aria-required="true" class="required"> * </span></label>
                    {{ Form::text('name', old('name') ? old('name') : '', array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('Name'))) }}
                </div>
                <div class="form-group">
                    <label class="control-label"> Display Name <span aria-required="true" class="required"> * </span></label>
                    {{ Form::text('display_name', old('display_name') ? old('display_name') : '', array('id' => 'display_name', 'class' => 'form-control', 'placeholder' =>'Display Name')) }}
                </div>
                <div class="form-group">
                    <label class="control-label"> Description <span aria-required="true" class="required"> * </span></label>
                    {{ Form::text('description', old('description') ? old('description') : '', array('id' => 'description', 'class' => 'form-control', 'placeholder' =>'Description')) }}
                </div>
                <div class="form-group">
                    <label class="control-label"> Status <span aria-required="true" class="required"> * </span></label>
                   {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
{!! HTML::script('js/plugins/validation/validate.min.js') !!}
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
            $('#add-role-form').validate({
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
                    } else if (element.attr("name") == "status") {
                        error.appendTo(element.parent("div"));
                    }
                    // Other elements
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    name: {
                        required: true,
                    },
					display_name: {
                        required: true,
                    },
                    status: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: '<?= __('Please enter role name.') ?>',
                    },
					 display_name: {
                        required: '<?= __('Please enter role Display name.') ?>',
                    },
                    status: {
                       required: '<?= __('Please select status.') ?>', 
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
        $('.select2').select2()

    });
</script>