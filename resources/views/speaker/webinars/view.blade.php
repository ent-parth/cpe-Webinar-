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
        <h3 class="box-title">Live Webinars </h3>
      </div>
      @if($LiveWebinarsView->status !=1)
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6" style="padding-top:15px;">
            <div class="form-group">
              <label class="control-label"> Title : </label>
              {{$LiveWebinarsView->title}} </div>
          </div>
          <div class="col-md-6"  style="padding-top:15px;">
            <div class="form-group">
              <label class="control-label">Webinar Type : </label>
              {{$LiveWebinarsView->webinar_type }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Course Description  : </label>
              @php echo $LiveWebinarsView->description; @endphp </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Learning Objectives : </label>
              @php echo $LiveWebinarsView->learning_objectives; @endphp </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fee ($) :</label>
              @if($LiveWebinarsView->fee != ''){{ number_format($LiveWebinarsView->fee,2) }} @else Free @endif</div>
          </div>
            <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">CPE Credits :</label>
              {{$LiveWebinarsView->cpa_credit }} </div>
          </div>
          <!--<div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Webinar Transcription : </label>
              {{$LiveWebinarsView->webinar_transcription }} </div>
          </div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Instructional Method : </label>
              {{str_replace('_',' ',$LiveWebinarsView->Instructional_method)}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Time Zone : </label>
             {{ $LiveWebinarsView->time_zone != '' ? config('constants.TIME_ZONE')[$LiveWebinarsView->time_zone] : '' }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Date :</label>
              {{ CommonHelper::convertTime($LiveWebinarsView->start_time,$LiveWebinarsView->time_zone,'F j Y') }}</div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Start Time:</label>
              {{ CommonHelper::convertTime($LiveWebinarsView->start_time,$LiveWebinarsView->time_zone,'g:i A')}}</div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">End Time:</label>
              {{ CommonHelper::convertTime($LiveWebinarsView->end_time,$LiveWebinarsView->time_zone,'g:i A')}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fields of study : </label>
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
              {{  CommonHelper::getWhoShouldAttendName($LiveWebinarsView->who_should_attend) }}  </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Topic of interest : </label>
              {{  CommonHelper::getTagName($LiveWebinarsView->tag) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ : </label>
              @php echo $LiveWebinarsView->faq_1; @endphp </div>
          </div>
          <!--<div class="col-md-6">
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
          </div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created At : </label>
              {{ date("F j Y",strtotime($LiveWebinarsView->created_at))  }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created By : </label>
              {{$LiveWebinarsView->first_name }} {{$LiveWebinarsView->last_name }} </div>
          </div>
          <?php /*?><div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Video : </label>
              <p>Click <a href="/uploads/webinar_video/{{$LiveWebinarsView->video}}" target="_blank">Here</a> to see uploaded video.</p>
            </div>
          </div><?php */?>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Presentation Material  : </label>
              @if($LiveWebinarsView->documents != '')
              <p>Click <a href="/uploads/webinar_doc/{{$LiveWebinarsView->documents}}" target="_blank">Here</a> to see uploaded Presentation Material.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Image : </label>
              @if($LiveWebinarsView->image != '')
              <p>Click <a href="/uploads/webinar_image/{{$LiveWebinarsView->image}}" target="_blank">Here</a> to see uploaded image.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Status : </label>
              {{$LiveWebinarsView->status}} </div>
          </div>
          @if($LiveWebinarsView->reason != "" && $LiveWebinarsView->status != 'active')
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Reason : </label>
              {{$LiveWebinarsView->reason}} </div>
          </div>
          @endif
          

               <div class="box-footer">
              <div class="col-md-12 text-right"> <a href="{{ URL::previous() }}" class="btn btn-danger" title="Cancel"> Cancel </a>
             
              </div>
            </div>
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