@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1>
    Edit Live Webinar Member
  </h1>
</section>

{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!}


<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->

            @if($webinar->admin_status == config('constants.WEBINAR_ADMIN_STATUS.NONE'))
            <div class="box-footer">
                 <div class="col-md-12 text-right">
                    <a href="{{ route('update.webinar_status',['webinar_id'=>$webinar->id,'status'=>'Reject']) }}" class="btn btn-danger" title="Cancel"> Reject </a>

                    <a href="{{ route('update.webinar_status',['webinar_id'=>$webinar->id,'status'=>'Approved']) }}"  class="btn btn-success ml-3" title="Cancel"> Approve </a>
                </div>
            </div> 
            @endif

            {!! Form::model($webinar, ['name' => 'edit-webinar-form', 'id' => 'edit-webnar-form', 'files' => true]) !!}

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Name <span aria-required="true" class="required"> * </span></label>
                                {{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => __('Enter Name'))) }}

                                @if ($errors->has('name'))
                                <label class="validation-invalid-label">{{ $errors->first('name') }}</label>                
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="control-label"> Date <span aria-required="true" class="required"> * </span></label>
                                
                                <input value="{{$webinar->date}}" name="date" id="date" readonly type="text" class="form-control" placeholder="date">

                                @if ($errors->has('date'))
                                    <label class="validation-invalid-label">{{ $errors->first('date') }}</label>                
                                @endif
                            </div>
                        </div>


                        <div class="col-md-6">


                            <div class="form-group">
                                <label class="control-label"> Type <span aria-required="true" class="required"> * </span></label>
                               {{ Form::select('webinar_type',[
                                        config('constants.WEBINAR_TYPE.LIVE')=>config('constants.WEBINAR_TYPE.LIVE'),
                                        config('constants.WEBINAR_TYPE.SELF_STUDY')=>config('constants.WEBINAR_TYPE.SELF_STUDY')], null, ["id" => "webinar_type", "placeholder" => "Select Webinar Type", 'class' => 'form-control select2 select-search']) }}

                                @if ($errors->has('webinar_type'))
                                    <label class="validation-invalid-label">{{ $errors->first('webinar_type') }}</label>                
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="control-label"> CPE Credit <span aria-required="true" class="required"> * </span></label>
                                {{ Form::number('cpe_credit', null, array('id' => 'cpe_credit', 'class' => 'form-control', 'placeholder' => __('CPE Credit'))) }}
                                @if ($errors->has('cpe_credit'))
                                    <label class="validation-invalid-label">{{ $errors->first('cpe_credit') }}</label>                
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            
                           
                            <div class="form-group">
                                <label class="control-label"> Time In Hour/Minute <span aria-required="true" class="required"> * </span></label>
                                
                                <div class="hr-time-picker">
                                    <div class="picked-time-wrapper">
                                        <input value="{{$webinar->time}}" name="time" readonly type="text" class="form-control picked-time" placeholder="time">
                                    </div>
                                    <div class="pick-time-now">
                                        <div class="hours hr-timer">
                                            <div class="movable-area">
                                                <ul></ul>
                                            </div>
                                        </div>
                                        <div class="minutes hr-timer">
                                            <ul></ul>
                                        </div>
                                    </div>
                                </div>                        
                                @if ($errors->has('time'))
                                    <label class="validation-invalid-label">{{ $errors->first('time') }}</label>                
                                @endif
                                
                            </div>

                            <div class="form-group">
                                <label class="control-label"> Status <span aria-required="true" class="required"> * </span></label>
                               {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
                                
                                @if ($errors->has('status'))
                                    <label class="validation-invalid-label">{{ $errors->first('status') }}</label>                
                                @endif
                            </div>


                            
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Description </label>
                                <textarea id="description" name="description" class="col-md-12">{{$webinar->description}}</textarea>

                                @if ($errors->has('description'))
                                    <label class="validation-invalid-label">{{ $errors->first('description') }}</label>                
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Faq </label>
                                <textarea id="faq" name="faq" class="col-md-12">{{$webinar->faq}}</textarea>
                                @if ($errors->has('faq'))
                                    <label class="validation-invalid-label">{{ $errors->first('faq') }}</label>                
                                @endif
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- /.box-body -->

                 
            {!! Form::close() !!}
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('js')

{{ HTML::script('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js?t=20130302') }}
{{ HTML::script('https://momentjs.com/downloads/moment.js') }}


{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}
{{ HTML::script('/js/plugins/timepicker/timepicker.min.js') }}

<script>
$(function() 
{
    $('#date').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss'
    });
    $(".time-picker").hrTimePicker();
    $(".picked-time").val("<?php echo date('H:i',strtotime($webinar->time)); ?>");

});
</script>

<script type="text/javascript">
    
    jQuery(document).ready(function () {
        CKEDITOR.replace('description');
        CKEDITOR.replace('faq');
        $('.select2').select2(); 
    });
</script>
@endSection
