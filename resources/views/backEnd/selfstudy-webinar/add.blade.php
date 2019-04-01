@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1> Add Self Study Webinar <span class="pull-right small"><a href="/selfstudy-webinar"><b>List view</b></a></span></h1>
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
        <form id="addWebinar" name="addWebinar" action="{{route('selfstudy-webinar.store')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Title <span aria-required="true" class="required"> * </span></label>
                    <input type="text" maxlength="255" placeholder="Webinar Name" required="required" noSpace=true name="title" id="title" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Presentation Material  <span aria-required="true" class="required"> * </span></label>
                    <input type="file" required="required" name="documents" id="documents" class="form-control" extension = "jpg|png|gif|psd|jpeg|bmp|pdf|doc|docx|ppt|xls|xlsx,pptx" title="Please upload valid fille. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docs, xls, xlsx, ppt, pptx">
                    <span>Allowed file type are : jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx</span> </div>
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
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label"> Course Description  <span aria-required="true" class="required"> * </span></label>
                    <textarea id="description" name="description" noSpace=true class="form-control" required="required"></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <label class="control-label col-md-12"> Fee ($) <span aria-required="true" class="required">*</span></label>
                  <div class="form-group">
                    <div class="col-md-6"> Free :
                      <input type="radio" name="fee_type" id="fee_tupe" required="required" value="0" class="" onclick="feeCheck(this.value);">
                      Paid  :
                      <input type="radio" name="fee_type" id="fee_tupe" required="required" value="1" class="" onclick="feeCheck(this.value);">
                    </div>
                    <div class="col-md-6" style="display:none;" id="fee_div">
                      <input type="text" placeholder="Fee amount" name="fee" id="fee" min="1" class="form-control number" >
                    </div>
                  </div>
                </div>
                <?php /*?><div class="col-md-6">
                	<div class="form-group">
                      <label class="control-label">Webinar Transcription <span aria-required="true"> </span></label>
                      <input type="text" name="webinar_transcription" placeholder="webinar transcription" id="webinar_transcription" class="form-control">
                    </div>
              		</div><?php */?>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Time Zone <span aria-required="true" class="required"> * </span></label>
                    <select name="time_zone" id="time_zone" class="form-control" required>
                      <option value="">Select time zone</option>
                      
                          @foreach(config('constants.TIME_ZONE') as $key=>$value)
                            
                      <option value="{{$key}}">{{$value}}</option>
                      
                          @endforeach
                      
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Webinar Date <span aria-required="true" class="required"> * </span></label>
                    <input type="text"  required="required" placeholder="recorded date" name="recorded_date" id="recorded_date" class="form-control">
                    <!-- <button class="btn btn-primary ml-3" type="button" onclick="checkAvailability()">Check Time Availability</button>--> 
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group" id="bookedSlot"> </div>
                </div>
              </div>
              
              <!--     <div class="col-md-12">
              	 <div class="col-md-6">
                	<div class="form-group">
                      <label class="control-label">Start Time <span aria-required="true" class="required"> * </span></label>
                      <input type="text"  required="required" name="start_time" placeholder="start time" id="start_time" class="form-control">
                    </div>
              		</div>
                  
                  <div class="col-md-6">
                	<div class="form-group">
                      <label class="control-label">End Time<span aria-required="true" class="required"> * </span></label>
                      <input type="text"  required="required" name="end_time" placeholder="end time" id="end_time" class="form-control">
                    </div>
              		</div> 
              </div> -->
              
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Presentation Length <span aria-required="true" class="required"> * </span></label>
                    <input type="number" min="1" required="required" name="presentation_length" id="presentation_length" placeholder="presentation length in hours" class="form-control" >
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Subject Area <span aria-required="true" class="required"> * </span></label>
                    <select name="subject_area[]" id="subject_area" class="form-control" required multiple="multiple">
                      
                              @foreach($subjectAria as $subject_aria)
                    
                      <option value="{{$subject_aria->id}}">{{$subject_aria->name}}</option>
                      
                              @endforeach
                  
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Course Level<span aria-required="true" class="required"> * </span></label>
                    <select name="course_level[]" id="course_level" class="form-control" required multiple="multiple">
                      
                              @foreach($courseLevel as $course_level)
                    
                      <option value="{{$course_level->id}}">{{$course_level->name}}</option>
                      
                              @endforeach
                  
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Pre Requirement <span aria-required="true"> </span></label>
                    <textarea id="pre_requirement" name="pre_requirement" class="form-control"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Advance Preparation <span aria-required="true" ></span></label>
                    <textarea id="advance_preparation" name="advance_preparation" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Who Should Attend <span aria-required="true" class="required"> * </span></label>
                    <select name="who_should_attend[]" id="who_should_attend" class="form-control" required multiple="multiple">
                      
                               @foreach($userType as $type)
                            
                      <option value="{{$type->id}}">{{$type->name}}</option>
                      
                                @endforeach
                  
                    
                    </select>
                    <!--  <select name="who_should_attend[]" id="who_should_attend" class="form-control" required multiple="multiple"> 
                              @foreach(config('constants.WHO_SHOULD_ATTEND') as $key=>$value)
                    			<option value="{{$value}}">{{$value}}</option>
                              @endforeach
                  </select> --> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Tag <span aria-required="true"> </span></label>
                    <select name="tag[]" id="tag" class="form-control" multiple="multiple">
                      
                    @foreach($tags as $tag)
                    	
                      <option value="{{$tag->id}}">{{$tag->tag}}</option>
                      
                    @endforeach
                  
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label"> Frequently Asked Questions <span aria-required="true"> </span></label>
                  <textarea id="faq_1" name="faq_1" class="form-control"></textarea>
                </div>
                <!--<div class="form-group"> 
                                  <textarea id="faq_2" name="faq_2" class="form-control"></textarea>
                                </div> 
                                <div class="form-group"> 
                                  <textarea id="faq_3" name="faq_3" class="form-control" ></textarea>
                                </div> 
                                <div class="form-group"> 
                                  <textarea id="faq_4" name="faq_4" class="form-control"></textarea>
                                </div> 
                                <div class="form-group"> 
                                  <textarea id="faq_5" name="faq_5" class="form-control"></textarea>
                                </div>--> 
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ route('selfstudy-webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
              <button type="submit" class="btn btn-primary ml-3" >Save</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="webinar_id" value="">
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
{{ HTML::script('js/plugins/validation/additional_methods.min.js') }} 
<script language="javascript" type="application/javascript">
	$(function() {

jQuery.validator.addMethod("noSpace", function(value) { 
  return $.trim( value );
}, "No space please and don't leave it empty");





		$('#addWebinar').validate();
		
		var date = new Date();
		date.setDate(date.getDate());
				
		$('#recorded_date').datetimepicker({
			format: 'yyyy-mm-dd',
			minView:"month",
			startDate: date,
      autoclose: true
		});
		
		$('#start_time').datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			startDate: date,
      autoclose: true
		});
		
		$('#end_time').datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			startDate: date,
      autoclose: true
		});

		/*//Customization option For Time Picker
		$(".time-picker").hrTimePicker({
			disableColor: "#989c9c", // red, green, #000
			enableColor: "#ff5722", // red, green, #000
			arrowTopSymbol: "&#9650;", // ▲ -- Enter html entity code
			arrowBottomSymbol: "&#9660;" // ▼ -- Enter html entity code
		});*/
    	//$(".time-picker").hrTimePicker();
	});
	
	// fee amount field show hide
	function feeCheck(val){
		if(val == 1){
			$('#fee_div').show();
			$("#fee").prop('required',true);
		} else {
			$('#fee_div').hide();
			$('#fee').val('');
			$("#fee").prop('required',false);
		}
	}
	
	jQuery(document).ready(function () {
        CKEDITOR.replace('description');
    	$('#time_zone').select2({placeholder: "Select Time Zone"});
		$('#subject_area').select2({placeholder: "Select Subject Area"});
		$('#course_level').select2({placeholder: "Select Course Level"});
		$('#who_should_attend').select2({placeholder: "Select Who Should Attend"});
		$('#tag').select2({placeholder: "Select Tag"});
    });
	
	
	$('#webinar_type').on('change', function () { 
		var webinar_type = $('#webinar_type').val();
		
	});
	
	

</script> 
@endSection 