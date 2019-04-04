@extends('backEnd.layouts.admin_app')

@section('content')
<div class="page-header page-header-light">
    {!! Breadcrumbs::render('ManageRolePermission') !!}   
</div>

<div class="page-content">
    <!-- Main content -->
    <div class="content-wrapper">        
        <div class="content">            
            <div class="row">                
                <div class="col-lg-12">
                    {!! Form::open(['name' => 'add-permission', 'id' => 'add-permission']) !!}
                    <div class="mb-3 pt-2">
                        <h6 class="mb-0 font-weight-semibold">
                            Manage Permissions
                        </h6>                        
                    </div> 
                    @if($permission)
                    <div class="card-group-control card-group-control-left" id="accordion-control">
                        @foreach($permission as $key => $value)
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h6 class="card-title">
                                    <a data-toggle="collapse" class="text-white" href="#accordion-control-group{{$key}}">{{ $value['title'] ?? ''}}</a>
                                </h6>
                            </div>
                            <div id="accordion-control-group{{$key}}" class="collapse show" data-parent="#accordion-control">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">                                                        
                                                <div class="custom-control custom-checkbox">                                                    
                                                    <input type="checkbox" name="permission_key[]" value="{{$value['id']}}" class="custom-control-input" id="{{$value['permission_key'] ?? ''}}"  <?php echo array_key_exists($value['id'], $selectRolePermission) ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="{{$value['permission_key'] ?? ''}}">{{$value['title'] ?? ''}}</label>
                                                </div>
                                            </div>
                                        </div>                                               
                                    </div>
                                    @foreach($value['childrens'] as $childrenKey => $childrenValue)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">                                                        
                                                <div class="custom-control custom-checkbox">                                                    
                                                    <input type="checkbox" name="permission_key[]" value="{{$childrenValue['id']}}" class="custom-control-input" id="{{$childrenValue['permission_key'] ?? ''}}"  <?php echo array_key_exists($childrenValue['id'], $selectRolePermission) ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label" for="{{$childrenValue['permission_key'] ?? ''}}">{{$childrenValue['title'] ?? ''}}</label>
                                                </div>                                                
                                            </div>                                                    
                                        </div>                                               
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>                        
                        @endforeach
                    </div>
                    <div class="text-right">
                        <a href="{{ route('roles') }}" class="btn btn-secondary ml-3" title="Cancel"><i class="icon-reply"></i> Cancel</a>
                        {{ Form::button('Save <i class="icon-paperplane ml-2"></i>',array('class'=>'btn btn-primary ml-3', 'type'=>'submit', 'title' => 'Save')) }}
                    </div> 
                    @else
                    {{ 'Permission is empty'}}
                    @endif                    
                    {!! Form::close() !!}
                </div>
            </div>             
        </div>        
    </div>
</div>
@endsection

@section('js')
{!! HTML::script('js/plugins/validation/validate.min.js') !!}

<script type="text/javascript">
    jQuery(document).ready(function () {

    });
</script>
@endSection
