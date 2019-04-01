@extends( 'layouts_comingsoon.master' )
@section( 'content' )
<style type="text/css">
.color-red{color:#F00;}
.color-green{color:#090;}
.error{color:#F00;}
</style>
<div id="content-area">
  <section class="inner-mainbanner" style="background-image:url({{env('APP_URL')}}/images/inner-banner.png);">
    <div class="container-fluid">
      <div class="inner-mainbanner-caption">
        <h1>{{$webinar->title}}</h1>
        <ul class="breadcrumb">
          <li><a href="{{env('COMINGSOON_URL')}}">Home</a> ></li>
          <li><a href="{{route('comingsoon-course')}}">Course</a> > </li>
          <li>Course detail</li>
        </ul>
      </div>
    </div>
  </section>
  <div class="container-fluid">
    <div class="d-md-flex aside-area justify-content-md-between">
      <main class="">
        <div class="courses-title">
          <h2>{{$webinar->title}}</h2>
          <div class="d-md-flex justify-content-between align-items-center">
            <p class="date-col">Webinar Date(s)<strong> <span id="changTZ">@if($webinar->start_time != ''){{date("l, F d, Y: H:i A",strtotime($webinar->start_time))}} @else {{date("l, F d, Y",strtotime($webinar->recorded_date))}} @endif {{$webinar->time_zone}} </span></strong></p>
            <p class="time-zone">Choose Your Time Zone:
              <select name="time_zone" id="time_zone" class="form-control changeTimeZone">
                @foreach(config('constants.TIME_ZONE') as $key=>$value)
                	<option value="{{$key}}" @if($key == $webinar->time_zone) selected="selected" @endif>{{$value.' - '.$key}}</option>	
                @endforeach
              </select>
            </p>
            <ul class="social-media flex-item">
              <li><a href="javascript:void(0);" target="_blank"><img src="{{env('APP_URL')}}/{{env('APP_URL')}}/images/icon-fb.png" alt=""></a></li>
              <li><a href="javascript:void(0);" target="_blank"><img src="{{env('APP_URL')}}/images/icon-tw.png" alt=""></a></li>
              <li><a href="javascript:void(0);" target="_blank"><img src="{{env('APP_URL')}}/images/icon-insta.png" alt=""></a></li>
            </ul>
          </div>
          <div class="post-block"> 
            @if(Session::get('mycpa_client_id'))
            	@if(!empty($webinarRegisters))
            		@php echo $webinar->vimeo_embaded @endphp
                @else
                	<p>You have to register in this course to see video.</p>
                	<a href="javascript:void(0)"><input class="btn-primary btn" value="Register" type="button"></a>
                @endif    
            @else
            	<p>You have to register to see video.</p>
                <a href="javascript:void(0)"><input class="btn-primary btn" value="Register" type="button"></a>
            @endif    
          </div>
        </div>
        <div id="video_progress" class="video_progress" style="display:none;"></div>
        <div class="tab-row"> 
          <!-- Nav pills -->
          <ul class="nav nav-pills">
            <li> <a class="nav-link active" data-toggle="pill" href="#Overview">Overview</a> </li>
            <li> <a data-toggle="pill" href="#About">About Presenter</a> </li>
            <li> <a data-toggle="pill" href="#Testimonials">Testimonials</a> </li>
            <li> <a data-toggle="pill" href="#faq">FAQ</a> </li>
            @if($webinar->webinar_type == 'self_study')
            <li> <a data-toggle="pill" href="#add_materials">Additional Materials</a> </li>
            @endif
          </ul>
          
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="Overview">
              <h3>Course Description</h3>
              @php echo $webinar->description; @endphp
            </div>
            <div class="tab-pane fade" id="About">
            
            
              <div class="instructor-wrapper"> 
                  <div class="instructor-wrapper-picture pull-left">
                    <img src="{{env('APP_URL')}}/avatars/{{$webinar->avatar}}" style="width: 150px; height: 150px;">
                  </div>
                  
                  <div class="instructor-wrapper-info pull-left">
                    <h3><a href="javascript:void(0);">{{$webinar->first_name.' '.$webinar->last_name}}</a></h3>
                    <p><strong>
                      <a target="_blank" href="{{$webinar->website}}">{{$webinar->companyName}}</a>
                    <br>
                    Partner
                    <br> 
                    <a href="mailto:{{$webinar->email}}">{{$webinar->email}}</a>
                    <br>
                    {{$webinar->contact_no}}
                    </strong></p>
                  </div>
                
                  <div class="pull-left right content_provider_width">
                      <a href="javascript:void(0)"><img width="190" src="{{env('APP_URL')}}/logos/{{$webinar->logo}}" alt="{{$webinar->companyName}}"></a> 
                  </div>
                
                  <div class="fix"></div>
                  <div class="instructor-instructor-bio">
                  	<p>@php echo $webinar->about_speaker @endphp</p>
                    <p></p>
                    <p>@php echo $webinar->about_company @endphp</p>
                </div>
                </div>



            </div>
            <div class="tab-pane fade" id="Testimonials">
              <h3>Course Description</h3>
              <p>Brands, because of their success and/or widespread recognition tend to be infringed by third parties. Some trademark owners, because of budget restraints or lack of funds, may be unable to enforce their valid trademarks against these third-party infringers. As such, this course seeks to alleviate their angst in enforcing their trademarks. This course seeks to present these trademark owners with possible litigation venues and scenarios</p>
              <h3>Course Description</h3>
              <p>Brands, because of their success and/or widespread recognition tend to be infringed by third parties. Some trademark owners, because of budget restraints or lack of funds, may be unable to enforce their valid trademarks against these third-party infringers. As such, this course seeks to alleviate their angst in enforcing their trademarks. This course seeks to present these trademark owners with possible litigation venues and scenarios</p>
              <h3>Course Description</h3>
              <p>Brands, because of their success and/or widespread recognition tend to be infringed by third parties. Some trademark owners, because of budget restraints or lack of funds, may be unable to enforce their valid trademarks against these third-party infringers. As such, this course seeks to alleviate their angst in enforcing their trademarks. This course seeks to present these trademark owners with possible litigation venues and scenarios</p>
            </div>
            <div class="tab-pane fade" id="faq">
             @if(!empty($webinar->faq_1))
             	<li><p>@php echo $webinar->faq_1; @endphp</p></li>
             @endif
             <?php /*?>@if(!empty($webinar->faq_2))
             	<li><p>{{$webinar->faq_2}}</p></li>
             @endif
             @if(!empty($webinar->faq_3))
             	<li><p>{{$webinar->faq_3}}</p></li>
             @endif
             @if(!empty($webinar->faq_4))
             	<li><p>{{$webinar->faq_4}}</p></li>
             @endif
             @if(!empty($webinar->faq_5))
             	<li><p>{{$webinar->faq_5}}</p></li>
             @endif<?php */?>
             @if(empty($webinar->faq_1))
             	<p>FAQ not available for this webinar</p>
             @endif 
            </div>
            @if($webinar->webinar_type == 'self_study')
            <div class="tab-pane active" id="add_materials">
              @if(!empty(Session::get('mycpa_client_id')))
              	<a href="{{env('APP_URL')}}/uploads/webinar_doc/{{$webinar->documents}}" target="_blank">Course Materials</a>
              @else
              	<a href="{{route('client.register')}}">Course Materials</a>
              @endif
            </div>
            @endif
          </div>
        </div>
        
        <div class="sponser-box">
          <div class="d-md-flex justify-content-between align-items-center">
            <div class="sponser-title ">
              <h3>NASBA Approved</h3>
              <p><strong>CPAacademy.org 1685 S. Colorado Blvd, Suite #205, Denver, CO 80222</strong></p>
            </div>
            <img src="{{env('APP_URL')}}/images/course-sponser.png" alt=""> </div>
          <p>CPAacademy.org (Sponsor Id#: 111889) is registered with the National Association of State Boards of Accountancy (NASBA) as a sponsor of continuing professional education on the National Registry of CPE Sponsors. State boards of accountancy have final authority on the acceptance of individual courses for CPE credit. Complaints regarding registered sponsors may be submitted to the National Registry of CPE Sponsors through its website: www.nasbaregistry.org.</p>
        </div>
      </main>
      <aside>
        <div class="cource-detail-box">
          <div class="card ">
            <p class="card-header">{{$webinar->fee != '' ? '$'.$webinar->fee : 'Free'}}</p>
            <div class="card-body">
              <p><span>CPE Credits</span> <strong>{{$webinar->cpa_credit}}</strong></p>
              @if($webinar->webinar_type == 'self_study')
              	<p><span>Webinar Transcription</span> <strong>{{$webinar->webinar_transcription}}</strong></p>
              @endif
              @if($webinar->webinar_type == 'self_study' || $webinar->webinar_type == 'archived')
              	<p><span>Presentation Length Hour(s)</span> <strong>{{$webinar->presentation_length}}</strong></p>
              @endif
              <p><span>Subject Area </span><strong>{{$webinar->subject_area != '' ? str_replace(',',', ',CommonHelper::getSubjectAreaName($webinar->subject_area)) : 'None'}}</strong></p>
              <p><span>Course Level </span><strong>{{$webinar->course_level != '' ? str_replace(',',', ',CommonHelper::getCourseLevelName($webinar->course_level)) : 'None'}}</strong></p>
              <p><span>Instructional Method </span><strong>Group Internet Based</strong></p>
              <p><span>Prerequisites </span><strong>{{$webinar->pre_requirement != '' ? $webinar->pre_requirement : 'None'}}</strong></p>
              <p><span>Advanced Preparation </span><strong>{{$webinar->advance_preparation != '' ? $webinar->advance_preparation : 'None'}}</strong></p>
              @if($webinar->webinar_type == 'self_study' || $webinar->webinar_type == 'archived')
              	<p><span>Recorded Date </span><strong>{{date("M d, Y",strtotime($webinar->recorded_date))}}</strong></p>
              @endif  
              <p><span>Who should attend? </span><strong>{{$webinar->who_should_attend != '' ? str_replace(',',', ',CommonHelper::getWhoShouldAttendName($webinar->who_should_attend)) : 'None'}}</strong></p>
              @if($webinar->webinar_type == 'live' || $webinar->webinar_type == 'archived')
              	<p><span>Series </span><strong>{{$webinar->series != '' ? str_replace(',',', ',CommonHelper::getSeriesName($webinar->series)) : 'None'}}</strong></p>
              @endif
            </div>
          </div>
     
     	@if(!empty(Session::get('mycpa_client_id')) && empty($webinarRegisters))
        	<!--<a href="{{empty(Session::get('mycpa_client_id')) ? route('client.register') : env('APP_URL').'/course-register/'.encrypt($webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-secondary">TAKE THIS COURSE</a> -->
            @if($webinar->fee != '')
            
            @else
            	<a href="javascript:void(0)" class="btn btn-secondary">TAKE THIS COURSE</a>
            @endif
        @endif
        @if(empty(Session::get('mycpa_client_id')))
            <a class="btn-primary btn" href="javascript:void(0)">Register</a> 
        @endif
        
        </div>
        <div class="aside-box">
          <h3>Self-Study CPE</h3>
          @if(count($selfStudyWebinars) > 0)
            	@foreach($selfStudyWebinars as $selfStudyWebinar)
                    <div class="card">
                        <h4>{{$selfStudyWebinar->title}}</h4>
                        <p>{{date("l, F d, Y",strtotime($selfStudyWebinar->recorded_date))}}</p>
                        <a href="{{env('COMINGSOON_URL')}}/comingsoon-course-detail/{{encrypt($selfStudyWebinar->id)}}" class="btn-text">View Details/Register</a> 
                    </div>
                @endforeach
          	@else
            	<div class="card">
                	<p>No sefl study CPE webinar</p>
                </div>	
            @endif
        </div>
      </aside>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('#review_answer_form').validate();
	$('#final_answer_form').validate();
	
	//Ajax call for change timezone
	$(document).on("change", '.changeTimeZone', function() {
		var timeZone = $('#time_zone').val();
		$.ajax({
			method: 'get',
			url: '/course-change-timezone',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
                timeZone : timeZone,
                <?php if($webinar->start_time != '') { ?>
                start_at : '{{$webinar->start_time}}',
                <?php } else { ?>
                created_at : '{{$webinar->recorded_date}}',
                <?php } ?>
                _token: $('#_token').val()
            }
		}).then(function (data) {
			$('#changTZ').html(data)
		}).fail(function (data) { 
			//$('.nameduplicate').html('Category Name is Duplicate..!');               
		});
	});
	
	
	//Ajax call for submit review Question
	$(document).on("click", '.submitReviewQues', function() {
		var type = $(this).data('type');
		if(type == 'review' ? $('#review_answer_form').valid():$('#final_answer_form').valid()){
			$.ajax({
				method: 'POST',
				url: '/course-question',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: type == 'review' ? $('#review_answer_form').serialize() : $('#final_answer_form').serialize(),
				
			}).then(function (data) {
				//var responseJson = $.parseJSON(data.responseText);
				$('#responReviewQuestion').html(data)
			}).fail(function (data) { 
				$('#responReviewQuestion').html(data)       
			});
		}
	});
			
	$(document).ready(function() {
		$('.selecttwo').select2();
		
		$('.my-tabs li a').click(function(){
			$('.my-tabs li a').removeClass('active');
			$(this).addClass('active');
			var tagid = $(this).data('target');
			$('.tab-contents .tab-captions').removeClass('active show');
			$(tagid).addClass('active show');
		});
	});
		
	jQuery(function($) {
	  $('.select2-multiple').select2MultiCheckboxes({
		templateSelection: function(selected, total) {
		  return "Selected " + selected.length ;
		}
	  })
	  
	});
	
	
	
	<!--Reload ajax question porsion-->
	function reloadQuestion(webinar_id,type){
		$.ajax({
			method: 'POST',
			url: '/course-question',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				webinar_id : webinar_id,
				type : type,
				takeExamAgain : 1,
				_token: $('#_token').val()
			}
			
		}).then(function (data) {
			//var responseJson = $.parseJSON(data.responseText);
			$('#responReviewQuestion').html(data)
		}).fail(function (data) { 
			$('#responReviewQuestion').html(data)       
		});	
	}
    </script>
    
	<!--Ajax call for track video duration in vimeo-->    
    
	<script src="https://player.vimeo.com/api/player.js"></script>
    <script language="javascript" type="application/javascript">
        var iframe = document.querySelector('iframe');
        var player = new Vimeo.Player(iframe);
		
        player.on('play', function() { //onclick on play button store user play video information 
			player.getDuration().then(function(duration) {
				// duration = the duration of the video in seconds set Ajax call for update video duration in webinar data
				$.ajax({
					method: 'POST',
					url: '/course-update-selfstudy-video',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						webinar_id : '{{encrypt($id)}}',
						duration: duration
					}
				}).then(function (data) {
					//$('#video_progress').html('<b>You have watched only '+minute.toFixed(2)+'  minutes. Please continue with the video.</b>')
				}).fail(function (data) { 
					//$('#video_progress').html(data)       
				});	
			});
			
			//call for store video duration data
            interval = setInterval(function(){//
				player.getCurrentTime().then(function(seconds) {
					addTime(seconds);//get current seen video duraion
				});
			}, 5000);
		});
		
		player.on('pause', function() { //Stop video seen update on pause button
			clearInterval(interval);
		});
		
        /*player.getVideoTitle().then(function(title) {
            alert('video titlee');
        });*/
		
		//store video duration information in databse (user and webinar wise)
		function addTime(durationTime){ 
			//var minute = durationTime/60;
			//console.log(durationTime);
			var totalTime = '{{$webinar->duration}}';
			var reviewResultStatus = '{{$reviewResultStatus}}';
			$.ajax({
				method: 'POST',
				url: '/course-calculate-video-time',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					webinar_id : '{{encrypt($id)}}',
					durationTime: durationTime
				}
			}).then(function (data) {
				//console.log(data.realTime);
				//var responseJson = $.parseJSON(data.responseText);
				//alert(responseJson.realTime);
				var mintime = data.realTime/60;
				var duration = data.realTime;
				$('#video_progress').show();
				$('#video_progress').html('<b>You have watched only '+mintime.toFixed(2)+'  minutes. Please continue with the video.</b>')
				//if(reviewResultStatus){
					$('#displayPer').html('You have watched only '+(duration*100/totalTime).toFixed(2)+'% of the video. Please continue with the video.')
					var addDuration = parseFloat(duration)+5;
					//console.log(addDuration);
					if((addDuration.toFixed()) >= totalTime){
						reloadQuestion('{{encrypt($id)}}','final');
					}
				//}
			}).fail(function (data) { 
				//$('#video_progress').html(data)       
			});	
		}
    </script> 
@stop