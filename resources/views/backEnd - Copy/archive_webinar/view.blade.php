@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content">
  <div class="row">
  <div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary"> 
    <!-- /.box-header --> 
    <!-- form start -->
    
    <div class="box-body">
      <div class="box-header">
        <h3 class="box-title">Arvhice Webinars </h3>
      </div>
      @if($LiveWebinarsView->status !=1)
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Title : </label>
              {{$LiveWebinarsView->title}} </div>
          </div>
         <!--  <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Type : </label>
              {{$LiveWebinarsView->webinar_type }} </div>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Description : </label>
              {{$LiveWebinarsView->description }} </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fee :</label>
              {{$LiveWebinarsView->fee }} </div>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Webinar Transcription : </label>
              {{$LiveWebinarsView->webinar_transcription }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Time Zone : </label>
              {{$LiveWebinarsView->time_zone }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Recorded Date :</label>
              {{ $LiveWebinarsView->recorded_date }} </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Start Time:</label>
              {{ $LiveWebinarsView->start_time }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">End Time:</label>
              {{ $LiveWebinarsView->end_time }} </div>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Subject Area : </label>
              {{  CommonHelper::getSubjectAreaName($LiveWebinarsView->subject_area) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Course Level : </label>
              {{  CommonHelper::getCourseLevelName($LiveWebinarsView->course_level) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Pre Requirement : </label>
              {{$LiveWebinarsView->pre_requirement }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Advance Preparation : </label>
              {{$LiveWebinarsView->advance_preparation }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Who should attend : </label>
              {{  $LiveWebinarsView->who_should_attend }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Tag : </label>
              {{  CommonHelper::getTagName($LiveWebinarsView->tag) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 1 : </label>
              {{$LiveWebinarsView->faq_1 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 2 : </label>
              {{$LiveWebinarsView->faq_2 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 3 : </label>
              {{$LiveWebinarsView->faq_3 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 4 : </label>
              {{$LiveWebinarsView->faq_4 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 5 : </label>
              {{$LiveWebinarsView->faq_5 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created At : </label>
              {{ date("j F, Y",strtotime($LiveWebinarsView->created_at))  }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created By : </label>
              {{$LiveWebinarsView->first_name }}{{$LiveWebinarsView->last_name }} </div>
          </div>
          <?php /*?><div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Video : </label>
              <p>Click <a href="/uploads/webinar_video/{{$LiveWebinarsView->video}}" target="_blank">Here</a> to see uploaded video.</p>
            </div>
          </div><?php */?>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Document : </label>
              <p>Click <a href="/uploads/webinar_doc/{{$LiveWebinarsView->documents}}" target="_blank">Here</a> to see uploaded documents.</p>
            </div>
          </div>
         <!--  <form id="live_webinar_status" name="live_webinar_status" data-parsley-validate class="form-horizontal form-label-left" action="{{route('live-webinar.updateStatus')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Status :</label>
                <select name="status" id="status" class="form-control" required>
                  <option  value="" >Select Status</option>
                  <option  value="active"  @if($LiveWebinarsView->status == "active") selected= selected @endif>Active</option>
                  <option  value="inactive"  @if($LiveWebinarsView->status == "inactive") selected= selected @endif>Inactive</option>
                  </select>
              </div>
            </div>
            <div class="box-footer">
              <div class="col-md-12 text-right"> <a href="{{ route('live-webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                <button type="submit" class="btn btn-primary ml-3">Save</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="{{$LiveWebinarsView->id}}">
                <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
              </div>
            </div>
          </form> -->
        </div>
      </div>
      <!-- /.box-body --> 
      
      @endif </div>
    <!-- /.box --> 
  </div>
</section>
<style>
    .datatable-highlight tfoot {
        display: table-header-group;
    }
</style>
@endsection
@section('css')
{{ HTML::style('/css/custom.css') }}
@endSection

@section('js')

{{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection 