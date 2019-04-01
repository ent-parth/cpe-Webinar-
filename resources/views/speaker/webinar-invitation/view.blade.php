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
        <h3 class="box-title">Webinars Invitation </h3>
      </div>
      @if($LiveWebinarsView->status !=1)
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Title : </label>
              {{$LiveWebinarsView->title}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Type : </label>
              {{$LiveWebinarsView->webinar_type }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Description : </label>
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
          <!--<div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Webinar Transcription : </label>
              {{$LiveWebinarsView->webinar_transcription }} </div>
          </div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Time Zone : </label>
              {{ config('constants.TIME_ZONE')[$LiveWebinarsView->time_zone] }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Date :</label>
              {{ date("F j Y", strtotime($LiveWebinarsView->recorded_date)) }}</div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Start Time:</label>
              {{ date("F j Y - g:i A", strtotime($LiveWebinarsView->start_time)) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">End Time:</label>
              {{ date("F j Y - g:i A", strtotime($LiveWebinarsView->end_time)) }}</div>
          </div>
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
              <label class="control-label"> Instructional Method : </label>
              {{str_replace('_',' ',$LiveWebinarsView->Instructional_method)}} </div>
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
              {{  CommonHelper::getWhoShouldAttendName($LiveWebinarsView->who_should_attend) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Tag : </label>
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
              <label class="control-label">Uploaded documents : </label>
              @if($LiveWebinarsView->documents != '')
              <p>Click <a href="/uploads/webinar_doc/{{$LiveWebinarsView->documents}}" target="_blank">Here</a> to see uploaded documents.</p>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Image : </label>
              @if($LiveWebinarsView->image != '')
              <p>Click <a href="/uploads/webinar_image/{{$LiveWebinarsView->image}}" target="_blank">Here</a> to see uploaded image.</p>
              @endif
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
          <form id="webinar_invitation_status" name="webinar_invitation_status" data-parsley-validate class="form-horizontal form-label-left" action="{{route('speaker.webinar-invitation.updateStatus')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-12">
              <div class="form-group">
                <div class="row">
                  @php 
                  $statusmd = 2;
                  if($LiveWebinarsView->status !="pending")
                  $statusmd = 6;
                  
                  @endphp
                 @if ($LiveWebinarsView->start_time < Carbon\Carbon::now()->addHours(2) && $LiveWebinarsView->status == "pending")
                  <div class="col-md-6">
                     <label class="control-label">Status : </label>
                     Expired
                  </div>
                 @else
                  <div class="col-md-{{$statusmd}}">
                     <label class="control-label">Status : </label>
                     @if($LiveWebinarsView->status != 'pending') {{$LiveWebinarsView->status}} @endif
                  </div>
                 @endif
                  <div class="col-md-4">
                    <div class="form-group">

                  @if ($LiveWebinarsView->start_time > Carbon\Carbon::now()->addHours(2))
                  @if($LiveWebinarsView->status == 'pending')
                  <select name="status" id="status" class="form-control" required onchange="statusCheck(this.value);">
                    <option  value="" >Select Status</option>
                    <option  value="accepted"  @if($LiveWebinarsView->status== "accepted") selected= selected @endif>Accepted</option>
                    <option  value="rejected"  @if($LiveWebinarsView->status == "rejected") selected= selected @endif>Rejected</option>
                  </select>
                  @endif
                  @endif

                </div>
              </div>
                </div>
              </div>
            </div>
             <div class="col-md-6" @if($LiveWebinarsView->reason == "" ) style="display:none;" @endif id="reason_div">
               <div class="form-group">
                      <label class="control-label"> Reason <span aria-required="true" class="required"> * </span> </label>
                      <textarea id="reason" name="reason" class="form-control required" @if($LiveWebinarsView->reason != "")  disabled @endif>{{$LiveWebinarsView->reason}}</textarea>
                    </div>
                     
             </div>
            <div class="box-footer" style="border: none;">
              <div class="col-md-12 text-right"> <a href="{{ URL::previous() }}" class="btn btn-danger" title="Cancel"> Cancel </a>
                 @if ($LiveWebinarsView->start_time > Carbon\Carbon::now()->addHours(2) && $LiveWebinarsView->status == "pending")
                <button type="submit" class="btn btn-primary ml-3">Save</button>
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="{{$LiveWebinarsView->id}}">
                <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
              </div>
            </div>
          </form>
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
{{ HTML::script('js/plugins/validation/validate.min.js') }}

<script type="text/javascript">
  $('#webinar_invitation_status').validate();
function statusCheck($val){
 
    if($val == 'reject'){
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