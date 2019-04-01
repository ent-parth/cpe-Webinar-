<div class="modal-dialog modal-md">
    <div class="modal-content">
        {!! Form::model($state, ['name' => 'edit-state', 'id' => 'edit-state-form', 'class' => 'form-horizontal']) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit State</h4>
        </div>
        <div class="modal-body">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"> Country <span aria-required="true" class="required"> * </span></label>
                   {{ Form::select('country_id', $countries, null, ["id" => "country_id", "placeholder" => "Select Country", 'class' => 'form-control select2 select-search']) }}
                </div>
                <div class="form-group">
                    <label class="control-label"> Name <span aria-required="true" class="required"> * </span></label>
                    {{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('State name'))) }}
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
            $('#edit-state-form').validate({
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
                    } else if (element.attr("name") == "status" || element.attr("name") == "country_id") {
                        error.appendTo(element.parent("div"));
                    }
                    // Other elements
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    country_id: {
                        required: true,
                    },
                    name: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        },
                        remote: {
                            url: "/states/check-state",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {id: "<?= $state->id ?>"}
                        }
                    },
                    status: {
                        required: true,
                    }
                },
                messages: {
                    country_id: {
                        required: '<?= __('Please select country.') ?>',
                    },
                    name: {
                        required: '<?= __('Enter state name.') ?>',
                        remote: "State name already exists."
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