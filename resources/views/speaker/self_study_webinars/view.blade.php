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
          <div class="col-md-6" style="padding-top:15px;">
            <div class="form-group">
              <label class="control-label"> Title : </label>
              {{$SelfStudyWebinarsView->title}} </div>
          </div>
          <div class="col-md-6" style="padding-top:15px;">
            <div class="form-group">
              <label class="control-label">Webinar Type : </label>
              {{ str_replace('_',' ',$SelfStudyWebinarsView->webinar_type) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Course Description  : </label>
              @php echo $SelfStudyWebinarsView->description; @endphp </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Learning Objectives  : </label>
              @php echo $SelfStudyWebinarsView->learning_objectives; @endphp </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fee ($):</label>
              @if($SelfStudyWebinarsView->fee != ''){{ number_format($SelfStudyWebinarsView->fee,2) }} @else Free @endif </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">CPE Credits  :</label>
              {{$SelfStudyWebinarsView->cpa_credit }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Instructional Method : </label>
              {{str_replace('_',' ',$SelfStudyWebinarsView->Instructional_method)}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Time Zone : </label>
              {{ $SelfStudyWebinarsView->time_zone != '' ? config('constants.TIME_ZONE')[$SelfStudyWebinarsView->time_zone] : ''}} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Webinar Date :</label>
              {{ date("F j Y", strtotime($SelfStudyWebinarsView->recorded_date)) }}</div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Presentation Length:</label>
              {{ $SelfStudyWebinarsView->presentation_length }} minutes</div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Fields of study : </label>
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
              {{  CommonHelper::getWhoShouldAttendName($SelfStudyWebinarsView->who_should_attend) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Topic of interest : </label>
              {{  CommonHelper::getTagName($SelfStudyWebinarsView->tag) }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">FAQ : </label>
              @php echo $SelfStudyWebinarsView->faq_1; @endphp </div>
          </div>
          <!-- <div class="col-md-6">
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
          </div>-->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created At : </label>
              {{ date("F j Y",strtotime($SelfStudyWebinarsView->created_at))  }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Created By : </label>
              {{$SelfStudyWebinarsView->first_name }} {{$SelfStudyWebinarsView->last_name }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Upload Content  : </label>
              @if($SelfStudyWebinarsView->video != '')
              <p>Click <a href="/uploads/webinar_video/{{$SelfStudyWebinarsView->video}}" target="_blank">Here</a> to see uploaded Upload Content.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Presentation Material  : </label>
              @if($SelfStudyWebinarsView->documents != '')
              <p>Click <a href="/uploads/webinar_doc/{{$SelfStudyWebinarsView->documents}}" target="_blank">Here</a> to see uploaded Presentation Material.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">video : </label>
              @if($SelfStudyWebinarsView->video != '')
              <p>Click <a href="/uploads/webinar_video/{{$SelfStudyWebinarsView->video}}" target="_blank">Here</a> to see uploaded video.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Image : </label>
              @if($SelfStudyWebinarsView->image != '')
              <p>Click <a href="/uploads/webinar_image/{{$SelfStudyWebinarsView->image}}" target="_blank">Here</a> to see uploaded image.</p>
              @else
              	-
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Status : </label>
              {{$SelfStudyWebinarsView->status}} </div>
          </div>
          @if($SelfStudyWebinarsView->reason != "" && $SelfStudyWebinarsView->status != 'active')
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Reason : </label>
              {{$SelfStudyWebinarsView->reason}} </div>
          </div>
          @endif
          <div class="col-md-12">
            <h3 class="box-title">Review Exam Question & Answers</h3>
          </div>
          <div class="col-md-12"> @if(count($WebinarQuestionsReview) > 0)
            @foreach($WebinarQuestionsReview as $review)
            <h5><b>Q.{{$review->question}}</b></h5>
            <h5>A.
              @if($review->answer == 'a')
              {{$review->option_a}}
              @elseif($review->answer == 'b')
              {{$review->option_b}}
              @elseif($review->answer == 'c')
              {{$review->option_c}}
              @elseif($review->answer == 'd')
              {{$review->option_d}}
              @endif </h5>
            @endforeach
            @else
            Not found any review exam quesion 
            @endif </div>
          <div class="col-md-12">
            <h3 class="box-title">Final Exam Question & Answers</h3>
          </div>
          <div class="col-md-12"> @if(count($WebinarQuestionsFinal) > 0)
            @foreach($WebinarQuestionsFinal as $final)
            <h5><b>Q.{{$final->question}}</b></h5>
            <h5>A.
              @if($final->answer == 'a')
              {{$final->option_a}}
              @elseif($final->answer == 'b')
              {{$final->option_b}}
              @elseif($final->answer == 'c')
              {{$final->option_c}}
              @elseif($final->answer == 'd')
              {{$final->option_d}}
              @endif </h5>
            @endforeach
            @else
            Not found any final exam quesion 
            @endif </div>
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ URL::previous() }}" class="btn btn-danger" title="Cancel"> Cancel </a> </div>
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