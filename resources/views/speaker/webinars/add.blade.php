@extends('speaker.layouts.speaker_app')
@section('content')
<section class="content-header">
  <h1> Add Webinar <span class="pull-right small"><a href="/webinar"><b>List view</b></a></span></h1>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!} 
{!! HTML::style('css/jquery-confirm.css') !!}
<style type="text/css">
  #bookedSlot p span{background: #ecf0f5;color: #3C8DBC;padding: 5px 10px;border-radius: 5px;}
  .requireds{color:#F00;}
  .required{color:#000 !important;}
</style>
<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        <form id="addWebinar" name="addWebinar" action="{{route('speaker.webinar.store')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Title <span aria-required="true" class="requireds"> * </span></label>
                    <input type="text" maxlength="255" noSpace=true placeholder="Webinar Name" name="title" id="title" class="form-control required">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Presentation Material <span aria-required="true" class="requireds"> * </span></label>
                    <input type="file" name="documents" id="documents" class="form-control required"  extension = "jpg|png|gif|psd|jpeg|bmp|pdf|doc|docx|ppt|xls|xlsx,pptx" title="Please upload valid fille. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docs, xls, xlsx, ppt, pptx">
                    <span>Allowed file type are : jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx</span> </div>
                </div>
                <!--<div class="col-md-6">
                <div class="form-group">
                <label class="control-label"> Webinar Type <span aria-required="true" class="requireds"> * </span></label>
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Course Description <span aria-required="true" class="requireds"> * </span></label>
                    <textarea id="description" name="description"  class="form-control"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label"> Learning Objectives <span aria-required="true" class="requireds"> </span></label>
                  <textarea id="learning_objectives" name="learning_objectives" class="form-control"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <label class="control-label"> CPE Credits <span aria-required="true" class="requireds"> * </span></label>
                  <input type="text" placeholder="CPE Credit" name="cpa_credit" id="cpa_credit" min="1" class="form-control number required">
                </div>
                <div class="col-md-6">
                  <label class="control-label"> Instructional Method <span aria-required="true" class="requireds"> * </span></label>
                  <select name="Instructional_method" id="Instructional_method" class="form-control" required="required">
                    <option value="">Select Instructional Method </option>
                    <option value="group_internet_based">Group Internet Based</option>
                    <option value="qas_self_study">QAS - Self Study</option>
                    <option value="nano_learning">Nano Learning</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12" style="padding-top:15px;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="control-label ">Fee ($) <span aria-required="true" class="requireds">*</span></label>
                    <br>
                    Free :
                    <input type="radio" name="fee_type" id="fee_tupe"  value="0" class="required" onclick="feeCheck(this.value);">
                    Paid  :
                    <input type="radio" name="fee_type" id="fee_tupe"  value="1" class="required" onclick="feeCheck(this.value);">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <div  style="display:none;" id="fee_div">
                      <label class="control-label " style="opacity: 0"> Fee </label>
                      <input type="text" placeholder="Fee amount" name="fee" id="fee" min="1" class="form-control number" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Image </label>
                    <input type="file" name="image" id="image" class="form-control" extension = "jpg|png|gif|,jpeg">
                    <span>Allowed file type are : jpg,jpeg,png,gif</span> </div>
                </div>
              </div>
              <?php /*?><div class="col-md-6">
                	<div class="form-group">
                      <label class="control-label">Webinar Transcription <span aria-required="true"> </span></label>
                      <input type="text" name="webinar_transcription" placeholder="webinar transcription" id="webinar_transcription" class="form-control">
                    </div>
              		</div><?php */?>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Time Zone <span aria-required="true" class="requireds"> * </span></label>
                    <select name="time_zone" id="time_zone" class="form-control required" >
                      <option value="">Select time zone</option>
                      
                          @foreach(config('constants.TIME_ZONE') as $key=>$value)
                            
                      <option value="{{$key}}">{{$value}}</option>
                      
                          @endforeach
                      
                    </select>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group" id="bookedSlot"> </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Start Time <span aria-required="true" class="requireds"> * </span></label>
                    <input type="text" name="start_time" autocomplete="off" placeholder="start time" id="start_time" class="form-control required">
                  </div>
                  <button class="btn btn-primary ml-3" type="button" onclick="checkAvailability()">Check Time Availability</button>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">End Time<span aria-required="true" class="requireds"> * </span></label>
                    <input type="text" name="end_time" autocomplete="off" placeholder="end time" id="end_time" class="form-control required">
                  </div>
                </div>
              </div>
              <div class="col-md-12"> 
                <!--<div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Presentation Length <span aria-required="true" class="requireds"> * </span></label>
                      <input type="text" required="required" name="presentation_length" id="presentation_length" placeholder="presentation length in hours" class="form-control" onfocus="checkAvailabilityFinal()">
                    </div>
                  </div>--> 
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Fields of study <span aria-required="true" class="requireds"> * </span></label>
                    <select name="subject_area[]" id="subject_area" class="form-control required"  multiple="multiple">
                      
                              @foreach($subjectAria as $subject_aria)
                    
                      <option value="{{$subject_aria->id}}">{{$subject_aria->name}}</option>
                      
                              @endforeach
                  
                    </select>
                    <span id="subject_area_error-Message"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Course Level<span aria-required="true" class="requireds"> * </span></label>
                    <select name="course_level[]" id="course_level" class="form-control required"  multiple="multiple">
                      
                              @foreach($courseLevel as $course_level)
                    
                      <option value="{{$course_level->id}}">{{$course_level->name}}</option>
                      
                              @endforeach
                  
                    </select>
                    <span id="course_level_error-Message"></span>
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
                    <label class="control-label">Who Should Attend <span aria-required="true" class="requireds"> * </span></label>
                    <select name="who_should_attend[]" id="who_should_attend" class="form-control required" multiple="multiple">
                      
                                @foreach($userType as $type)
                            
                      <option value="{{$type->id}}">{{$type->name}}</option>
                      
                                @endforeach
                        
                    </select>
                    <span id="who_should_attend_error-Message"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Topic of interest <span aria-required="true"> </span></label>
                    <select name="tag[]" id="tag" class="form-control" multiple="multiple">
                      
                    @foreach($tags as $tag)
                    	
                      <option value="{{$tag->id}}">{{$tag->tag}}</option>
                      
                    @endforeach
                  
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
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
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ route('speaker.webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
              <button type="button" class="btn btn-primary ml-3" onclick="checkAvailabilityFinal()">Save</button>
              <button type="button" class="btn btn-primary ml-3" onclick="saveDraft()">Save as Draft</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="webinar_id" value="">
              <input type="hidden" id="draft" name="draft" value="">
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
<!--http://craftpip.github.io/jquery-confirm/v1.1/--> 
{{ HTML::script('js/jquery-confirm.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}
{{ HTML::script('js/plugins/validation/additional_methods.min.js') }} 

<script language="javascript" type="application/javascript">
	var validator = $('#addWebinar').validate({
		ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
		errorClass: 'validation-invalid-label',
		successClass: 'validation-valid-label',
		validClass: 'validation-valid-label',
		highlight: function (element, errorClass) {
			$(element).removeClass(errorClass);
		},
		unhighlight: function (element, errorClass) {
			$(element).removeClass(errorClass);
		},
		// Different components require proper error label placement
		errorPlacement: function (error, element) {
			// Unstyled checkboxes, radios
			if (element.parents().hasClass('form-check')) {
				error.appendTo(element.parents('.form-check').parent());
			}else if(element.attr("name") == "time_zone" || element.attr("name") == "fee_type" || element.attr("name") == "course_level" || element.attr("name") == "who_should_attend" || element.attr("name") == "description" || element.attr("name") == "Instructional_method") {
				error.appendTo(element.parent("div"));
			}else if(element.attr("id") == "subject_area" ){
				error.appendTo("#subject_area_error-Message");
			}else if(element.attr("id") == "course_level"){
				//element = $("#select2-" + element.attr("id") + "-container").parent(); 
				error.appendTo("#course_level_error-Message");
			}else if(element.attr("id") == "who_should_attend"){
				//element = $("#select2-" + element.attr("id") + "-container").parent(); 
				error.appendTo("#who_should_attend_error-Message");
			}
			// Other elements
			else {
				error.insertAfter(element);
			}
		},
		rules: { 
			description:{
				required: function() {
					CKEDITOR.instances.description.updateElement();
					CKEDITOR.instances.description.focus();
				},
				 minlength:10
			}
		},
		messages:{
			cktext:{
				required:"Please enter Text",
				minlength:"Please enter 10 characters"
			}
		}
	});
	
	
	
  
			
	$(function() {
    	jQuery.validator.addMethod("noSpace", function(value) { 
			return $.trim( value );
		}, "No space please and don't leave it empty");

		//$('#addWebinar').validate();
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
		}).on('changeDate', function () { 
			var minDate = $('#start_time').val();
			$('#end_time').val('');
			$('#end_time').datetimepicker('setStartDate', minDate);
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
	});
	
	
	// fee amount field show hide
	function feeCheck($val){
		if($val == 1){
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
    	CKEDITOR.replace('learning_objectives');
		CKEDITOR.replace('faq_1');
		//CKEDITOR.replace('faq_3');
		//CKEDITOR.replace('faq_4');
		//CKEDITOR.replace('faq_5');
    	$('#time_zone').select2({placeholder: "Select Time Zone"});
		$('#Instructional_method').select2({placeholder: "Select Instructional Method"});
		$('#subject_area').select2({placeholder: "Select Subject Area"});
		$('#course_level').select2({placeholder: "Select Course Level"});
		$('#who_should_attend').select2({placeholder: "Select Who Should Attend"});
		$('#tag').select2({placeholder: "Select Tag"});
    });
	
		
	$('#webinar_type').on('change', function () { 
		var webinar_type = $('#webinar_type').val();
	});
	
	
	function checkAvailability(){
		var start_time = $('#start_time').val();
		var time_zone = $('#time_zone').val();
		
		if(start_time !='' && time_zone !=''){
			$.ajax({
					method: 'post',
					url: '/webinar/check-availability',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						start_time: start_time,
						time_zone: time_zone,
						_token: $('#_token').val()
					}
				}).then(function (data) {
					$('#bookedSlot').html(data)
					//alert(data)
				   }).fail(function (data) { 
					//$('.nameduplicate').html('Category Name is Duplicate..!');			   
			   });
		}else{
			$.alert({
			title: 'Alert!',
			content: 'Please select timezone and start time',
			});
		}
		
	}
	
	function checkAvailabilityFinal(){
		var valid = $('#addWebinar').valid();
		if(valid) {
			//var recorded_date = $('#recorded_date').val();
			var time_zone = $('#time_zone').val();
			var start_time = $('#start_time').val();
			var end_time = $('#end_time').val();
			$.ajax({
				method: 'post',
				url: '/webinar/check-availability-final',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					//recorded_date: recorded_date,
					time_zone: time_zone,
					start_time : start_time,
					end_time : end_time,
					_token: $('#_token').val()
				}
			}).then(function (data) { 
				if(data > 0) {
					$.alert({
						title: 'Error!',
						content: 'This time slot is already booked',
					});
					//alert('This time slot is already booked');
					$('#start_time').focus();
				} else {
					$("#addWebinar").submit();
				}
			   }).fail(function (data) {
				$.alert({
					title: 'Error!',
					content: 'Difference between start time and end time must be between 24 hours.',
				});
				//$('.nameduplicate').html('Category Name is Duplicate..!');			   
		   });
		}else{
			validator.focusInvalid();
	        return false;
		}
	}
	
	// save Draft
	function saveDraft(){
		$("#draft").val(1);
		var validator = $( "#addWebinar" ).validate();
		validator.destroy();
		$.confirm({
			'title': 'Confirm',
			'content': "<strong> For Draft, We are not storing Timezone and Webinar date related fields. We are not even validating your data. Do you want to continue? </strong>",
			theme: 'supervan',
			'buttons': {'Yes': {'class': 'special',
			'action': function(){
				$("#addWebinar").submit();
			}},'No' : {'class'  : ''}}
		});
	}

</script> 
@endSection 