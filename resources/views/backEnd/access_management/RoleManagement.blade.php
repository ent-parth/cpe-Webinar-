@extends('backEnd.layouts.admin_app')
@section('content') 
{!!
    // If For Edit Role.
    $name = $display_name = $status = $description = $sort = "";
    if($data_for == "edit_role"){
        $name = $res[0]->name;
        $display_name = $res[0]->display_name;
        $status = $res[0]->status;
        $description = $res[0]->description;
        $sort = $res[0]->sort;
    } 
!!}
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Role Management</h3>
        </div>
        <div class="box-body">
            <div class="action pull-right">
                <a href="role_list" class="btn btn-primary" title="Add Company"> 
                    <b><i class="fa fa-list"></i></b> Role List 
                </a>
            </div>
                <div class="form">  
                    <form method="post" id="add_role"> 
                        <h4>Add new role</h4>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 text-right"><label class="control-label">Name :</label></div>
                            <div class="col-md-7"><input type="text" name="display_name" class="form-control" value="{!! $display_name; !!}" ></div> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 text-right"><label class="control-label">Associated Permission :</label></div>
                                <div class="col-md-7">
                                    {!! 
                                        $selected = "";
                                        $list_style = "display:none;";
                                         if($data_for == "edit_role"){
                                             if(!empty($permissions_id)){
                                                 $selected = "selected";
                                                 $list_style = "display:auto; overflow: auto; max-height: 100px;  overflow-y: auto; overflow-x: hidden;"; 
                                             }
                                         }
                                    !!}
                                    <select name="associated_permission" class="form-control">
                                        <option value="all">All</option>
                                        <option value="custom" {!! $selected; !!}>Custom</option>
                                    </select>
                                </div> 
                            </div>
                        </div>

                        <div class="form-group permission_list" style="{!! $list_style; !!} height:200px;">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-7"> 
                                    @foreach($permission_list as $pl)
                                        <div class="form-group">
                                            {!!
                                           $checked = "";
                                            if($data_for == "edit_role"){
                                                if(in_array($pl->id,$permissions_id)){
                                                    $checked .= "checked";
                                                } 
                                            }
                                            !!}
                                            <input type="checkbox" name="permission[]" value="{!! $pl->id !!}" {!! $checked; !!} />
                                            <?php echo $pl->display_name; ?> 
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 text-right"><label class="control-label">sort :</label></div>
                                <div class="col-md-7">
                                    <input type="text" name="sort" class="form-control" placeholder="Sort" value="{!! $sort !!}">
                                </div> 
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 text-right"><label class="control-label">Active :</label></div>
                                <div class="col-md-7">
                                    <input type="checkbox" name="status" value="active" checked>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-10 text-center">
                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"> 	
                                <input type="hidden" name="name" id="role_name" value="{!! $name; !!}" >
                                <button type="reset" class="btn btn-danger">Cancel</button>
                                @if($data_for == "edit_role")
                                    <input type="hidden" name="id" value="{!! $res[0]->id; !!}" >
                                    <button type="submit" class="btn btn-default">update</button>  
                                @else
                                    <button type="submit" class="btn btn-default">Create</button> 
                                @endif 
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
          $('#add_role').validate({ 
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
                    display_name: {
                        required: '<?= __('Please enter name.') ?>',
                    },
                    status: {
                        required: '<?= __('Please enter status.') ?>',
                    },
                    sort: {
                        required: '<?= __('Please enter sort.'); ?>',
                    }
                }
            });

            $('input[name=display_name]').blur(function(){
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
            });

            $("#add_role input[name='status']").on('change',function(){
                if(this.checked) {
                    $(this).val('active'); 
                }else{
                    $(this).val('inactive'); 
                }
            }); 

            $("#add_role select[name=associated_permission]").on('change',function(){
                $('.permission_list input[type=checkbox]').prop('checked', false); 
                if($(this).val() == "custom"){    
                    $('.permission_list').attr('style','display:auto; overflow: auto; max-height: 100px;  overflow-y: auto; overflow-x: hidden;');
                }else{ 
                    $('.permission_list').attr('style','display:none;'); 
                }                
            });
    });
</script>

@endsection 