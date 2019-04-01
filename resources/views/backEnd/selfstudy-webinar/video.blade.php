@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1> Add Self Study Video (Step 2) <span class="pull-right"><a href="/selfstudy-webinars">List view</a></span></h1>
</section>
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        <form id="addWebinar" name="addWebinar" action="{{route('selfystudy-webinar.store_video')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Document <span aria-required="true" class="required"> * </span></label>
                    <input type="file" required="required" name="video" id="video" class="form-control" extension = "mp4|3gp|webm|wmv|flv">
                    <span>Allowed file type are : mp4,3gp,webm,wmv,flv</span> </div>
                </div>
                <!--<div class="col-md-6">
                <div class="form-group">
                <label class="control-label"> Webinar Type <span aria-required="true" class="required"> * </span></label>
                  <select name="webinar_type" id="webinar_type" class="form-control" required>
                      <option value="">Select Type</option>
                      @foreach(config('constants.WEBINAR_TYPE') as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>
                </div>
              </div>--> 
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ route('selfstudy-webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a> 
              
              <!--    <button type="button" class="btn btn-primary ml-3" >Save</button> -->
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="webinar_id" value="{{$id}}">
              <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
              <input type="submit" class = "btn btn-primary ml-3" value="Save">
            </div>
          </div>
        </form>
      </div>
      <!-- /.box --> 
    </div>
  </div>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!} 

<!-- /.content --> 
@endsection
@section('js')
{{ HTML::script('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js?t=20130302') }}

{{ HTML::script('https://momentjs.com/downloads/moment.js') }}


{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}
{{ HTML::script('js/plugins/validation/additional_methods.min.js') }}



@endSection 