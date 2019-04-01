@extends( 'layouts_front.master' )
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
          <li><a href="{{env('APP_URL')}}">Home</a> ></li>
          <li><a href="{{route('course')}}">Course</a> > </li>
          <li>course webinar payment</li>
        </ul>
      </div>
    </div>
  </section>
  <div class="container-fluid">
    <div class="d-md-flex aside-area justify-content-md-between">
      <main class="">
        <div class="courses-title">
          <h2>{{$webinar->title}} Payment</h2>
          
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
			@if(!empty($webinarRegister) && $webinarRegister->payment_status == 'success')
          		<a href="/course-detail/{{encrypt($webinar->id)}}" class="btn btn-secondary">View Webinar</a>
           	@elseif(empty(Session::get('mycpa_client_id')))
           		<a class="btn-primary btn" href="{{route('client.register')}}">Register</a>
           	@else
        		<form action="{{env('APP_URL')}}/course-payment" id="stripeForm" method="POST" class="">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control number" name="amount" id="stripeAmount" value="{{$webinar->fee*100}}"/>
                    <input type="hidden" class="form-control" id="stripeClientEmail" name="stripeClientEmail" value="{{Session::get('mycpa_client_email')}}">
                    <input type="hidden" class="form-control" id="stripePaymentCurrency" name="stripePaymentCurrency" value="USD"> 
                    <input type="hidden" id="stripeToken" name="stripeToken" />
                    <input type="hidden" id="webinar_id" name="webinar_id" value="{{encrypt($webinar->id)}}" />
                    <script src="https://checkout.stripe.com/checkout.js"></script>
                    <input type="button" id="stripe-button" class="btn btn-secondary" value="Make Payment"/>
                </form>
        	@endif
      </aside>
    </div>
  </div>
</div>
<script language="javascript" type="application/javascript">
	var handler = StripeCheckout.configure({
		  	key: "{{env('STRIPE_PUBLISH_KEY')}}",									
			name:"MYCPA.COM",
			description:"Webinar Registration",
			image:'{{env("APP_URL")}}/images/logo.png',
			locale:"auto",
			currency:"usd",
  			token: function(token) {
    			$("#stripeToken").val(token.id);
    			$("#stripeForm").submit();
  			}
	});
	
	//Stripe Payment Checkout
	$('#stripe-button').on('click', function(e) {		
		var amount = '{{$webinar->fee}}'
		if(amount=='' || amount<=0){
			return false;
		}
		var amountInCents = parseFloat(amount*100).toFixed(2);
		var displayAmount = parseFloat(Math.floor(amount*100) / 100).toFixed(2);
		var clientEmail = $("#stripeClientEmail").val();
		handler.open({
			amount: amountInCents,
			email: clientEmail,
			description: 'Payment for Webinar (US$' + displayAmount + ')',
		});
		e.preventDefault();
	});
	
</script>
@stop