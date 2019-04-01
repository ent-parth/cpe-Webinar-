@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1>
    Edit Self Study Webinar
  </h1>
</section>

{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}




<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->

            @if($webinar->admin_status == config('constants.WEBINAR_ADMIN_STATUS.NONE'))
                <div class="box-footer">
                 <div class="col-md-12 text-right">
                    <a href="{{ route('update.webinar_status',['webinar_id'=>$webinar->id,'status'=>'Reject']) }}" class="btn btn-danger" title="Cancel"> Reject </a>

                    <a href="{{ route('update.webinar_status',['webinar_id'=>$webinar->id,'status'=>'Approved']) }}"  class="btn btn-success ml-3" title="Cancel"> Approve </a>
                </div>
               </div>
            @endif 
              <div class="box-body">

                <div class="container-fluid">                 
                      <div class="steps-content">    
                            <div>
                                <!-- form start -->                                
                                {!! Form::model($webinar, ['name' => 'edit-self-study-webinar-form', 'id' => 'edit-self-study-webinar-form', 'files' => true]) !!}
                                    <h4>Basic Details</h4>
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
                                                <label class="control-label">Recorded Date<span aria-required="true" class="required"> * </span></label>
                                                
                                                <input value="{{date('m/d/Y',strtotime($webinar->recorded_date))}}" name="recorded_date" id="recorded_date" readonly type="text" class="form-control" placeholder="recorded date">

                                                @if ($errors->has('recorded_date'))
                                                    <label class="validation-invalid-label">{{ $errors->first('recorded_date') }}</label>                
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
                                                <label class="control-label">Offered Date<span aria-required="true" class="required"> * </span></label>
                                                
                                                <input value="{{date('m/d/Y',strtotime($webinar->offered_date))}}" name="offered_date" id="offered_date" readonly type="text" class="form-control" placeholder="offered date">
                                                
                                                @if ($errors->has('offered_date'))
                                                    <label class="validation-invalid-label">{{ $errors->first('offered_date') }}</label>                
                                                @endif
                                            </div>                        
                                        </div>

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="control-label"> Time In Hour/Minute <span aria-required="true" class="required"> * </span></label>
                                                
                                                <div class="hr-time-picker">
                                                    <div class="picked-time-wrapper">
                                                        <input name="time" readonly type="text" class="form-control picked-time" placeholder="time">
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
                                                <label class="control-label"> CPE Credit <span aria-required="true" class="required"> * </span></label>
                                                {{ Form::number('cpe_credit', null, array('id' => 'cpe_credit', 'class' => 'form-control', 'placeholder' => __('CPE Credit'))) }}
                                                @if ($errors->has('cpe_credit'))
                                                    <label class="validation-invalid-label">{{ $errors->first('cpe_credit') }}</label>                
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="control-label"> Government Approved Course ID </label>
                                                {{ Form::text('gov_course_approved_id', null, array('id' => 'gov_course_approved_id', 'class' => 'form-control', 'placeholder' => __('Government Course Approved ID'))) }}
                                                @if ($errors->has('gov_course_approved_id'))
                                                    <label class="validation-invalid-label">{{ $errors->first('gov_course_approved_id') }}</label>                
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
                                                <label class="control-label"> Testimonial </label>
                                                <textarea id="testimonial" name="testimonial" class="col-md-12">{{$webinar->testimonial}}</textarea>
                                                @if ($errors->has('testimonial'))
                                                    <label class="validation-invalid-label">{{ $errors->first('testimonial') }}</label>                
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"> Learning Objectives </label>
                                                <textarea id="learning_objectives" name="learning_objectives" class="col-md-12">{{$webinar->learning_objectives}}</textarea>
                                                @if ($errors->has('learning_objectives'))
                                                    <label class="validation-invalid-label">{{ $errors->first('learning_objectives') }}</label>                
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"> Refund And Cancellations Policy <span aria-required="true" class="required"> * </span> </label>
                                                <textarea id="refund_and_cancellations_policy" name="refund_and_cancellations_policy" class="col-md-12">{{$webinar->refund_and_cancellations_policy}}</textarea>
                                                @if ($errors->has('refund_and_cancellations_policy'))
                                                    <label class="validation-invalid-label">{{ $errors->first('refund_and_cancellations_policy') }}</label>                
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
                                    
                                {!! Form::close() !!}
                            </div>
                      </div>
                    </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('js')

{{ HTML::script('https://momentjs.com/downloads/moment.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}

{{ HTML::script('/js/plugins/timepicker/timepicker.min.js') }}


<script>
        $(function()
        {    
            $(".time-picker").hrTimePicker();
            $("#recorded_date").datepicker();
            $("#offered_date").datepicker(); 
        });
</script>


@if(isset($webinar_id))
    <script>      
    $(function()
    {
      $('.btn-prev').addClass('disabled hidden');
      $('.completed').css({"pointer-events": "none", "opacity": "0.7"});
    });
    </script>
@else
    <script>      
    $(function()
    {
        $(".picked-time").val("<?php echo date('H:i',strtotime($webinar->time)); ?>");
    });
    </script>
@endif


<script type="text/javascript">
    jQuery(document).ready(function () {
        if ($('#description').length)
        {
            CKEDITOR.replace('description');
            CKEDITOR.replace('faq');
            CKEDITOR.replace('learning_objectives');
            CKEDITOR.replace('refund_and_cancellations_policy');
            CKEDITOR.replace('testimonial');
        }
        $('.select2').select2();  
    });
</script>
@endSection
