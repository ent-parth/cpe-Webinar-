@extends('speaker.layouts.speaker_app')
@section('content')
<section class="content-header">
  <h1> Add Webinar Question<span class="pull-right"><a href="/webinar-questions">List view</a></span></h1>
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
        <form id="addWebinarQuestions" name="addWebinarQuestions" action="{{route('speaker.webinar-questions.store')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Webinar<span aria-required="true" class="required"> * </span></label>
                    <select name="webinar_id" id="webinar_id" class="form-control" required>
                      <option value="">Select </option>
                       @foreach($webinars as $wb)
                      	<option value="{{$wb->id}}">{{$wb->title}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Type<span aria-required="true" class="required"> * </span></label>
                    <select name="type" id="type" class="form-control" required>
                      <option value="">Select </option>
                      	<option value="review">Review</option>
                        <option value="final">Final</option>
                    </select>
                  </div>
               </div> </div>
               
               <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Time<span aria-required="true" class="required"> * </span></label>
                    <input type="text"  placeholder="Select Time" required="time" name="time" id="question" class="form-control">
                  </div>
               </div> 
              </div>
               
              <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question <span aria-required="true" class="required"> * </span></label>
                    <textarea  placeholder="Write Question Here" required="required" name="question" id="question" class="form-control"></textarea>
                  </div>
               </div> </div>
               
               <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question A <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_a" id="option_a" class="form-control">
                  </div>
               </div> </div>
               <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question B <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_b" id="option_b" class="form-control">
                  </div>
               </div> </div>
               <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question C <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_c" id="option_c" class="form-control">
                  </div>
               </div> </div>
               <div class="col-md-12">
              <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question D <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_d" id="option_d" class="form-control">
                  </div>
               </div> </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Answer <span aria-required="true" class="required"> * </span></label>
                    <select name="answer" id="answer" class="form-control" required>
                      <option value="">Select </option>
                      	<option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
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
{{ HTML::script('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js?t=20130302') }}

{{ HTML::script('https://momentjs.com/downloads/moment.js') }}


{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }} 

@endSection 