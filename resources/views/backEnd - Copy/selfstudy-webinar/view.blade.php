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
        <h3 class="box-title">Self Study Webinars</h3>
      </div>
      @if($SelfStudyWebinarsView->status !=1)
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Title : </label>
              {{$SelfStudyWebinarsView->title}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Type : </label>
              {{$SelfStudyWebinarsView->webinar_type }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Description : </label>
              {{$SelfStudyWebinarsView->description }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fee :</label>
              {{$SelfStudyWebinarsView->fee }} </div>
          </div>
          <?php /*?><div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Webinar Transcription : </label>
              {{$SelfStudyWebinarsView->webinar_transcription }} </div>
          </div><?php */?>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Time Zone : </label>
              {{$SelfStudyWebinarsView->time_zone }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Date :</label>
              {{ $SelfStudyWebinarsView->recorded_date }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Presentation Length:</label>
              {{ $SelfStudyWebinarsView->presentation_length }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Subject Area : </label>
              {{  CommonHelper::getSubjectAreaName($SelfStudyWebinarsView->subject_area) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Course Level : </label>
              {{  CommonHelper::getCourseLevelName($SelfStudyWebinarsView->course_level) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Pre Requirement : </label>
              {{$SelfStudyWebinarsView->pre_requirement }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Advance Preparation : </label>
              {{$SelfStudyWebinarsView->advance_preparation }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Who should attend : </label>
              {{  $SelfStudyWebinarsView->who_should_attend }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Tag : </label>
              {{  CommonHelper::getTagName($SelfStudyWebinarsView->tag) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 1 : </label>
              {{$SelfStudyWebinarsView->faq_1 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 2 : </label>
              {{$SelfStudyWebinarsView->faq_2 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 3 : </label>
              {{$SelfStudyWebinarsView->faq_3 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 4 : </label>
              {{$SelfStudyWebinarsView->faq_4 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ 5 : </label>
              {{$SelfStudyWebinarsView->faq_5 }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created At : </label>
              {{ date("j F, Y",strtotime($SelfStudyWebinarsView->created_at))  }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created By : </label>
              {{$SelfStudyWebinarsView->first_name }}{{$SelfStudyWebinarsView->last_name }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Video : </label>
              <p>Click <a href="/uploads/webinar_video/{{$SelfStudyWebinarsView->video}}" target="_blank">Here</a> to see uploaded video.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Document : </label>
              <p>Click <a href="/uploads/webinar_doc/{{$SelfStudyWebinarsView->documents}}" target="_blank">Here</a> to see uploaded documents.</p>
            </div>
          </div>
          
          <form id="self_study_status" name="self_study_status" data-parsley-validate class="form-horizontal form-label-left" action="{{route('selfstudy-webinar.updateStatus')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
             
             
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="control-label">Status :</label>
                    <select name="status" id="status" class="form-control" required  onchange="statusCheck(this.value);">
                      <option  value="" >Select Status</option>
                      <option  value="active"  @if($SelfStudyWebinarsView->status == "active") selected= selected @endif>Active</option>
                      <option  value="inactive"  @if($SelfStudyWebinarsView->status == "inactive") selected= selected @endif>Inactive</option>
                      <option  value="delete"  @if($SelfStudyWebinarsView->status == "delete") selected= selected @endif>Delete</option>
                    </select>
                  </div>
                </div>
            
             	<div class="row">
                    <div class="col-md-6" @if($SelfStudyWebinarsView->reason == "" ) style="display:none;" @endif id="reason_div">
                        <div class="form-group">
                              <label class="control-label"> Reason <span aria-required="true" class="required"> * </span> </label>
                              <textarea id="reason" name="reason" class="form-control required" ><?php echo $SelfStudyWebinarsView->reason; ?></textarea>
                        </div>
                    </div>
                </div>    
             
             
             
           		 <div class="box-footer">
              <div class="col-md-12 text-right"> <a href="{{ route('selfstudy-webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                <button type="submit" class="btn btn-primary ml-3">Save</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="{{$SelfStudyWebinarsView->id}}">
                <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
              </div>
            </div>
          </form>
          
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

<script type="text/javascript">
  $('#live_webinar_status').validate();
function statusCheck($val){
 
    if($val == 'inactive' || $val == 'delete'){
      $('#reason_div').show();
      $("#reason").prop('required',true);
    } else {
      $('#reason_div').hide();
      $('#reason').val('');
      $("#reason").prop('required',false);
    }
  }
  
</script>
@endSection 