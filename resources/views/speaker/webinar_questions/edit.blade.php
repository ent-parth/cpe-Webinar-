@extends('speaker.layouts.speaker_app')
@section('content')
<section class="content-header">
  <h1> Edit Webinar Question <span class="pull-right"><a href="/webinar-questions">List view</a></span></h1>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!} 

<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        <form id="updateWebinarQuestion" name="updateWebinarQuestion" action="{{route('speaker.webinar-questions.update')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Webinar<span aria-required="true" class="required"> * </span></label>
                    <select name="webinar_id" id="webinar_id" class="form-control" required>
                      <option value="">Select Webinar</option>
                      
                      
                       @foreach($webinars as $wb)
                      	
                      
                      <option value="{{$wb->id}}" @if($wb->id == $WebinarQuestionsEdit->webinar_id) selected='selected' @endif>{{$wb->title}}</option>
                      
                      
                        @endforeach
                    
                    
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Type<span aria-required="true" class="required"> * </span></label>
                    <select name="type" id="type" class="form-control" required>
                      <option value="">Select Type</option>
                      <option value="review" @if(isset($WebinarQuestionsEdit->type) && $WebinarQuestionsEdit->type == 'review') selected="selected" @endif>Review</option>
                      <option value="final" @if(isset($WebinarQuestionsEdit->type) && $WebinarQuestionsEdit->type == 'final') selected="selected" @endif>Final</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Time<span aria-required="true" class="required"> * </span></label>
                    <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" placeholder="Select Time" required="required" value="{{$WebinarQuestionsEdit->time}}"  id="time" name="time" />
                      <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question <span aria-required="true" class="required"> * </span></label>
                    <textarea  placeholder="Write Question Here" required="required" name="question" id="question" value="{{$WebinarQuestionsEdit->question}}" class="form-control">{{$WebinarQuestionsEdit->question}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Option A <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_a" id="option_a" value="{{$WebinarQuestionsEdit->option_a}}" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Option B <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_b" id="option_b" value="{{$WebinarQuestionsEdit->option_b}}" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Option C <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_c" id="option_c" value="{{$WebinarQuestionsEdit->option_c}}" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Option D <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_d" id="option_d" value="{{$WebinarQuestionsEdit->option_d}}" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Answer <span aria-required="true" class="required"> * </span></label>
                    <select name="answer" id="answer" class="form-control" required>
                      <option value="">Select </option>
                      <option value="a" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'a') selected="selected" @endif>A</option>
                      <option value="b" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'b') selected="selected" @endif>B</option>
                      <option value="c" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'c') selected="selected" @endif>C</option>
                      <option value="d" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'd') selected="selected" @endif>D</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ route('speaker.webinar-questions') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
              <button type="submit" class="btn btn-primary ml-3">Save</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$WebinarQuestionsEdit->id}}">
              <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
            </div>
          </div>
        </form>
      </div>
      <!-- /.box --> 
    </div>
  </div>
</section>
<!-- /.content --> 
@endsection
@section('js') 
<script language="javascript" src="https://momentjs.com/downloads/moment.js"></script> 
<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
{{ HTML::script('https://momentjs.com/downloads/moment.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }} 
<script language="javascript" type="application/javascript">
	$('#datetimepicker1').datetimepicker({
		format: 'hh:mm:ss'
	});
	
	$(function() {
		$('#updateWebinarQuestion').validate();
	});
	$('#webinar_id').select2({placeholder: "Select Webinar"});
</script> 
@endSection 