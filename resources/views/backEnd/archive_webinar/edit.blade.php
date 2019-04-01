@extends('backEnd.layouts.admin_app')
@section('content')
<style>
#uploadVideoForm {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#uploadVideoForm label {margin:2px; font-size:1em; font-weight:bold;}
.demoInputBox{padding:5px; border:#F0F0F0 1px solid; border-radius:4px; background-color:#FFF;}
#progress-bar {background-color: #12CC1A;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
.btnSubmits{background-color:#09f;border:0;padding:10px 40px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px;}
#progress-div {border:#0FA015 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
#targetLayer{width:100%;text-align:center;}

.requireds{color:#F00;}
.required{color:#000 !important;}
</style>
<section class="content-header">
  <h1> Edit Archive Webinar <span class="pull-right small"><a href="/archive-webinar"><b>List view</b></a></span></h1>
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
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Upload Content <span aria-required="true" class="requireds"> * </span></label>
              <form id="uploadVideoForm" name="uploadVideoForm" action="{{route('archive-webinar.store_video')}}" method="post">
                <div>
                  <input name="video" id="video" type="file" class="demoInputBox form-control" required="required" extension = "mp4|3gp|webm|wmv|flv" />
                </div>
                <div>
                  <input type="submit" id="btnSubmit" value="Upload Video" class="btn btn-primary ml-3 btnSubmits" />
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" value="{{$webinar->id}}">
                  <input type="hidden" name="webinar_id" value="{{$webinar->id}}">
                  <input type="hidden" name="actionType" value="edit">
                  <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
                  <span><a href="javascript:void(0)" class="btn btn-danger stopvideo" title="Cancel"> Cancel </a></span> </div>
                <div id="progress-div" style="display:none;">
                  <div id="progress-bar"></div>
                </div>
                <div id="targetLayer"></div>
                <span>Allowed file type are : mp4, 3gp, webm, wmv, flv</span>
              </form>
              <!--<div id="loader-icon" style="display:none;"><img src="LoaderIcon.gif" /></div>--> 
              @if(!empty($webinar->video) && file_exists(public_path('uploads/webinar_video/'.$webinar->video)))
              <p>Click <a id="uploadedVideo" href="/uploads/webinar_video/{{$webinar->video}}" target="_blank">Here</a> to see uploaded video.</p>
              @endif </div>
          </div>
        </div>
        <!-- /.box-header --> 
        
        <!-- form start -->
        <form id="updateWebinar" name="updateWebinar" action="{{route('archive-webinar.update')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Title <span aria-required="true" class="requireds"> * </span></label>
                    <input type="text"  maxlength="255" noSpace=true placeholder="Webinar Name" value="{{$webinar->title}}" required="required" name="title" id="title" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Presentation Material <span aria-required="true" class="requireds"> * </span></label>
                    <input type="file" name="documents" id="documents" class="form-control" extension = "jpg|png|gif|psd|jpeg|bmp|pdf|doc|docx|ppt|xls|xlsx,pptx" title="Please upload valid fille. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docs, xls, xlsx, ppt, pptx" @if(empty($webinar->
                    documents) || !file_exists(public_path('uploads/webinar_doc/'.$webinar->documents))) required="required" @endif> <span>Allowed file type are : jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx</span> @if(!empty($webinar->documents) && file_exists(public_path('uploads/webinar_doc/'.$webinar->documents)))
                    <p>Click <a id="uploadedVideo" href="/uploads/webinar_doc/{{$webinar->documents}}" target="_blank">Here</a> to see uploaded documents.</p>
                    @endif </div>
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
                    <textarea id="description" name="description"  class="form-control">{{$webinar->description}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label"> Learning Objectives <span aria-required="true" class="requireds"> </span></label>
                  <textarea id="learning_objectives" name="learning_objectives" class="form-control">{{$webinar->learning_objectives}}</textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <label class="control-label"> Instructional Method <span aria-required="true" class="requireds"> * </span></label>
                  <select name="Instructional_method" id="Instructional_method" class="form-control" required="required">
                    <option value="">Select Instructional Method </option>
                    <option value="group_internet_based" @if($webinar->Instructional_method == 'group_internet_based') selected="selected" @endif>Group Internet Based</option>
                    <option value="qas_self_study" @if($webinar->Instructional_method == 'qas_self_study') selected="selected" @endif>QAS - Self Study</option>
                    <option value="nano_learning" @if($webinar->Instructional_method == 'nano_learning') selected="selected" @endif>Nano Learning</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Image <span aria-required="true" class="requireds"> </span></label>
                    <input type="file" name="image" id="image" class="form-control" extension = "jpg|png|gif|,jpeg">
                    <span>Allowed file type are : jpg,png,gif,jpeg</span> @if(!empty($webinar->image) && file_exists(public_path('uploads/webinar_image/'.$webinar->image)))
                    <p>Click <a href="/uploads/webinar_image/{{$webinar->image}}" target="_blank">Here</a> to see uploaded Image.</p>
                    @endif </div>
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
                    <label class="control-label">Time Zone <span aria-required="true" class="requireds"> * </span></label>
                    <input type="text" name="time_zone" id="time_zone" class="form-control"  value="{{ $webinar->time_zone != '' ? config('constants.TIME_ZONE')[$webinar->time_zone] : '' }}" required disabled="disabled">
                    
                    <!-- <select name="time_zone" id="time_zone" class="form-control" required>
                          <option value="">Select time zone</option>
                          @foreach(config('constants.TIME_ZONE') as $key=>$value)
                          	<option value="{{$key}}" @if($key == $webinar->time_zone) selected="selected" @endif>{{$value}}</option>
                          @endforeach
                      </select> --> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Webinar Date <span aria-required="true" class="requireds"> * </span></label>
                    <input type="text"  required="required" placeholder="recorded date" name="recorded_date" id="recorded_date" value="{{$webinar->recorded_date}}" class="form-control" disabled="disabled">
                    <!--<button class="btn btn-primary ml-3" type="button" onclick="checkAvailability()">Check Time Availability</button>--> 
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group" id="bookedSlot"> </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Presentation Length <span aria-required="true" class="requireds"> * </span></label>
                    <input type="number" min="1" value="{{$webinar->presentation_length}}" required="required" name="presentation_length" id="presentation_length" placeholder="presentation length in hours" class="form-control" >
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Fields of study <span aria-required="true" class="requireds"> * </span></label>
                    <select name="subject_area[]" id="subject_area" class="form-control" required multiple="multiple">
                      
                      
                              @foreach($subjectAria as $subject_aria)
                    			
                      
                      <option value="{{$subject_aria->id}}" @if(!empty($subject_area_id) && in_array($subject_aria->id, $subject_area_id)) selected="selected" @endif>{{$subject_aria->name}}</option>
                      
                      
                              @endforeach
                  
                    
                    </select>
                    <span id="subject_area_error-Message"></span> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Course Level<span aria-required="true" class="requireds"> * </span></label>
                    <select name="course_level[]" id="course_level" class="form-control" required multiple="multiple">
                      
                      
                              @foreach($courseLevel as $course_level)
                    			
                      
                      <option value="{{$course_level->id}}" @if(!empty($course_level_id) && in_array($course_level->id, $course_level_id)) selected="selected" @endif>{{$course_level->name}}</option>
                      
                      
                              @endforeach
                  
                    
                    </select>
                    <span id="course_level_error-Message"></span> </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Pre Requirement <span aria-required="true"> </span></label>
                    <textarea id="pre_requirement" name="pre_requirement" class="form-control">{{$webinar->pre_requirement}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Advance Preparation <span aria-required="true" ></span></label>
                    <textarea id="advance_preparation" name="advance_preparation" class="form-control">{{$webinar->advance_preparation}}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Who Should Attend <span aria-required="true" class="requireds"> * </span></label>
                    <?php $who_should_attend  =  explode(',',$webinar->who_should_attend);?>
                    <select name="who_should_attend[]" id="who_should_attend" class="form-control" required multiple="multiple">
                      
                      
                        @foreach($userType as $type)
                         
                      
                      <option value="{{$type->id}}" @if(!empty($who_should_attend_array) && in_array($type->id, $who_should_attend_array)) selected="selected" @endif>{{$type->name}}</option>
                      
                      
                        @endforeach
                  
                    
                    </select>
                    <span id="who_should_attend_error-Message"></span> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Topic of interest <span aria-required="true"> </span></label>
                    <select name="tag[]" id="tag" class="form-control" multiple="multiple">
                      
                      
                    @foreach($tags as $tag)
                    	
                      
                      <option value="{{$tag->id}}" @if(!empty($tag_id) && in_array($tag->id, $tag_id)) selected="selected" @endif>{{$tag->tag}}</option>
                      
                      
                    @endforeach
                  
                    
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Frequently Asked Questions <span aria-required="true"> </span></label>
                  <textarea id="faq_1" name="faq_1" class="form-control">{{$webinar->faq_1}}</textarea>
                </div>
                <!--<div class="form-group"> 
                      <textarea id="faq_2" name="faq_2" class="form-control">{{$webinar->faq_2}}</textarea>
                    </div>
                    <div class="form-group"> 
                      <textarea id="faq_3" name="faq_3" class="form-control" >{{$webinar->faq_3}}</textarea>
                    </div>
                    <div class="form-group"> 
                      <textarea id="faq_4" name="faq_4" class="form-control">{{$webinar->faq_4}}</textarea>
                    </div>
                    <div class="form-group"> 
                      <textarea id="faq_5" name="faq_5" class="form-control">{{$webinar->faq_5}}</textarea>
                   </div>  --> 
              </div>
              <?php /*?><div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Video <span aria-required="true" class="requireds"> * </span></label>
                    <input type="file" name="video" id="video" class="form-control" extension = "mp4|3gp|webm|wmv|flv">
                    <span>Allowed file type are : mp4,3gp,webm,wmv,flv</span> @if(!empty($webinar->video) && file_exists(public_path('uploads/webinar_video/'.$webinar->video)))
                    <p>Click <a href="/uploads/webinar_video/{{$webinar->video}}" target="_blank">Here</a> to see uploaded video.</p>
                    @endif </div>
                </div>
              </div><?php */?>
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> @if(empty($webinar->video))
              <p id="noteMsg"><b>Note: </b>Please upload video first to enable Save button</p>
              @endif <a href="{{ route('archive-webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
              <button type="submit" class="btn btn-primary ml-3" id="submitBtn"   @if(empty($webinar->video)) disabled="disabled" @endif >Save</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{$webinar->id}}">
              <input type="hidden" name="webinar_id" value="{{$webinar->id}}">
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
{{ HTML::script('/js/jquery.form.js') }} 
<script type="text/javascript">
var ajaxCall;
    $(function() {
    	$(document).ready(function(){
			$('#uploadVideoForm').submit(function(e) {	
			 	var valid = $('#uploadVideoForm').valid();
				if(valid){
					if($('#video').val()) {
						e.preventDefault();
						$('#loader-icon').show();
						ajaxCall = $(this).ajaxSubmit({ 
							target:   '#targetLayer', 
							beforeSubmit: function() {
							  $('#updateWebinar').find("[type=submit]").hide();
							  $('#updateWebinar').find(".BtnCancel").hide();	
							  $('#progress-div').show();		
							  $("#progress-bar").width('0%');
							},
							uploadProgress: function (event, position, total, percentComplete){	
								$("#progress-bar").width(percentComplete + '%');
								$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
							},
							success:function (data){
								$('#updateWebinar').find(".BtnCancel").show();
								$('#updateWebinar').find("[type=submit]").show();
								$('#submitBtn').removeAttr('disabled');	
								$('#uploadedVideo').attr('href','/uploads/webinar_video/'+data.latestVideo);	
								$('#noteMsg').hide();	
								$('#loader-icon').hide();
							},
							resetForm: true 
						}); 
						return false; 
					}
				}else{
					return false; 
				}
			});

      $(document).on('click','.stopvideo', function(e){
            var xhr = ajaxCall.data('jqxhr');
            xhr.abort();
          });

   		}); 
 	});
</script> 
<script language="javascript" type="application/javascript">
	var validator =  $('#updateWebinar').validate({
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
				 required: function() 
				{
				 CKEDITOR.instances.description.updateElement();
				 CKEDITOR.instances.description.focus();
				},

				 minlength:10
			}
		},
		messages:
			{

			cktext:{
				required:"Please enter Text",
				minlength:"Please enter 10 characters"


			}
		}

	});
	
	
	$("#validate").click(function() {
        var valid = $('#updateWebinar').valid();
		if(valid) {
			$("#updateWebinar").submit();
		}else{
			validator.focusInvalid();
	        return false;	
		}
  });
	
	
	$(function() {
		jQuery.validator.addMethod("noSpace", function(value) { 
		  return $.trim( value );
		}, "No space please and don't leave it empty");

		$('#updateWebinar').validate();
		
		var date = new Date();
		date.setDate(date.getDate());
		
		
		/*//Customization option For Time Picker
		$(".time-picker").hrTimePicker({
			disableColor: "#989c9c", // red, green, #000
			enableColor: "#ff5722", // red, green, #000
			arrowTopSymbol: "&#9650;", // ▲ -- Enter html entity code
			arrowBottomSymbol: "&#9660;" // ▼ -- Enter html entity code
		});*/
    	//$(".time-picker").hrTimePicker();
	});
	

	
	jQuery(document).ready(function () {
       CKEDITOR.replace('faq_1');
	   CKEDITOR.replace('description');
	   CKEDITOR.replace('learning_objectives');
       //$('#time_zone').select2({placeholder: "Select Time Zone"});
		$('#subject_area').select2({placeholder: "Select Subject Area"});
		$('#Instructional_method').select2({placeholder: "Select Instructional Method"});
		$('#course_level').select2({placeholder: "Select Course Level"});
		$('#who_should_attend').select2({placeholder: "Select Who Should Attend"});
		$('#tag').select2({placeholder: "Select Tag"});
    });
	
	
	$('#webinar_type').on('change', function () { 
		var webinar_type = $('#webinar_type').val();
		
	});
</script> 
@endSection 