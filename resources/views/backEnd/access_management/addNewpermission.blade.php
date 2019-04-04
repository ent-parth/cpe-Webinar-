@extends('backEnd.layouts.admin_app')
@section('content') 
{!!
    // If For Edit Permission. 
    $name = $display_name = $status = $description = $sort =  "";
    $title = "Add Permission";
    if($act == "edit_permission"){   
        $name = $permission[0]->name; 
        $display_name = $permission[0]->display_name;
        $status = $permission[0]->status;
        $description = $permission[0]->description;
        $sort = $permission[0]->sort;
        $title = "Edit Permission";
    } 
!!}
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box ">
        <div class="box-header">
          <h3 class="box-title">Permission Management</h3>
        </div>
        <div class="box-body">
            <div class="action pull-right"> 
                <a href="permission_management" class="btn btn-primary" title="Add Permission"> 
                    <b><i class="fa fa-list"></i></b> Permission List 
                </a>
            </div>
            <div class="form">  
                <form method="post" id="add_permission">  
                    <h4>{!! $title !!}</h4> 
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right"><label class="control-label">Name :</label></div>
                        <div class="col-md-7"><input type="text" name="name" class="form-control" value="{!! $name; !!}" placeholder="Name" ></div> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right"><label class="control-label">Display Name :</label></div>
                        <div class="col-md-7"><input type="text" name="display_name" class="form-control" value="{!! $display_name; !!}" placeholder="Display name"  ></div> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right"><label class="control-label">Status :</label></div>
                            <div class="col-md-7">
                            <input type="radio" name="status" value="active" selected {!! $status=="active"?"checked": ""; !!} />  Active<br/>
                                <input type="radio" name="status" value="inactive" {!! $status=="inactive"?"checked": ""; !!} />  In Active 
                            </div> 
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right"><label class="control-label">Sort :</label></div>
                        <div class="col-md-7"><input type="text" name="sort" class="form-control" value="{!! $sort; !!}" ></div> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-10 text-center">
                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"> 	
                            @if($act == "edit_permission")    
                                <input type="hidden" name="id" value="{!! $permission[0]->id; !!}" >
                            @endif 
                            <button type="reset" class="btn btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-default">Create</button> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div> 
</section>
<!-- /content area -->
@endsection
@section('js')

{!! HTML::script('js/jquery.min.js') !!}    
{!! HTML::script('js/plugins/validation/validate.min.js') !!} 

<script type="text/javascript">
    jQuery(document).ready(function () {

         // Initialize
         $('#add_permission').validate({ 
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
                },
                sort: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: '<?= __('Please enter name.') ?>',
                },
                display_name: {
                    required: '<?= __('Please enter display name.') ?>',
                },
                status: {
                    required: '<?= __('Please enter status.') ?>',
                },
                sort: {
                    required: '<?= __('Please enter sort.'); ?>',
                }
            }
        });

        /*$('input[name=display_name]').blur(function(){
            if($('input[name=display_name]').val() != ""){
                var str = ($('input[name=display_name]').val()).split(' ');
                var i = 0;
                var newstr = "";
                $.each(str,function(key,value){
                    if(i == 0){
                        newstr += value;
                        i = 1;
                    }else{
                        newstr += "-"+value;
                    }
                });
                $('input[name=name]').val(newstr);
            }
        });*/ 
    });
</script>

@endsection 