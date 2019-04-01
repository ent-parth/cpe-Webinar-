@extends( 'layouts_front.master' )
@section( 'content' )
<div id="content-area">
  <section class="main-banner-row">
    <div class="slider-item" style="background-image:url({{config('APP_URL')}}/front_side/images/banner-bg.png)">
      <div class="container-fluid">
        <div class="banner-caption">
          <h1>The Biggest E-learning Educational portal for Accounting and Tax professionals</h1>
          <p>20,000+ Registered User | 1000+ Speakers | 10000+ Hours of CPE Credits | Free Mobile Application</p>
        </div>
      </div>
    </div>
    <div class="slider-item" style="background-image:url({{config('APP_URL')}}/front_side/images/banner-bg1.png)"> 
      <!-- <div class="container-fluid">
                        <div class="banner-caption">
                            <h1>The Biggest E-learning Educational portal for Accounting and Tax professionals</h1>
                            <p>20,000+ Registered User | 1000+ Speakers | 10000+ Hours of CPE Credits | Free Mobile Application</p>
                        </div>
                    </div> --> 
    </div>
    <div class="slider-item" style="background-image:url({{config('APP_URL')}}/front_side/images/1-Free-Webinar.jpg)"></div>
    <div class="slider-item" style="background-image:url({{config('APP_URL')}}/front_side/images/banner-bg.png)">
      <div class="container-fluid">
        <div class="banner-caption">
          <h1>The Biggest E-learning Educational portal for Accounting and Tax professionals</h1>
          <p>20,000+ Registered User | 1000+ Speakers | 10000+ Hours of CPE Credits | Free Mobile Application</p>
        </div>
      </div>
    </div>
  </section>
  <section class="filter-search">
    <div class="container-fluid">
      <div class="d-md-flex justify-content-between align-items-center">
        <div class="filter-area d-flex justify-content-between align-items-center">
          <label>filters:</label>
          <div class="filter-list">
            <div class="lbl-filter">
              <label><a href="javascript:void(0);">Topic of interest</a></label>
              <div class="lbl-item-lst">
                <h2 class="filter-title"></h2>
                <a href="javascript:void(0);" class="apply-filter" id="topic_of_interested"><span>Apply Filter</span></a>
                <div class="ul-wrap">
                  <ul>
                    <form action="{{env('APP_URL')}}/course" method="get" class="" id="tag_search_filter" name="tag_search_filter">
                      <!--<li class="inner-title">Category1</li>--> 
                      @if(count($tagLists) > 0)
                      @foreach($tagLists as $tagList)
                      <li>
                        <input type="checkbox" id="{{$tagList->id}}" name="tag[]" value="{{$tagList->id}}">
                        <label for="{{$tagList->id}}">{{$tagList->tag}}</label>
                      </li>
                      @endforeach
                      @else
                      <li class="inner-title">Opps..! Data not available</li>
                      @endif
                    </form>
                  </ul>
                </div>
              </div>
            </div>
            <div class="lbl-filter">
              <label><a href="javascript:void(0);">Field of Study</a></label>
              <div class="lbl-item-lst"> <a href="javascript:void(0);" class="apply-filter" id="field_of_study"><span>Apply Filter</span></a>
                <ul>
                  <form action="{{env('APP_URL')}}/course" method="get" class="" id="course_search_filter" name="course_search_filter">
                    <!--<li class="inner-title">Category1</li>--> 
                    @if(count($subjectAria) > 0)
                    @foreach($subjectAria as $subjectAriaList)
                    <li>
                      <input type="checkbox" id="study{{$subjectAriaList->id}}" name="field_of_study[]" value="{{$subjectAriaList->id}}">
                      <label for="study{{$subjectAriaList->id}}">{{$subjectAriaList->name}}</label>
                    </li>
                    @endforeach
                    @else
                    <li class="inner-title">Opps..! Data not available</li>
                    @endif
                  </form>
                </ul>
              </div>
            </div>
            <div class="lbl-filter">
              <label><a href="javascript:void(0);" id="live_search">live</a></label>
            </div>
            <div class="lbl-filter">
              <label><a href="javascript:void(0);" id="self_study">Self-Study</a></label>
            </div>
            <div class="lbl-filter">
              <label><a href="javascript:void(0);" id="archived">Archived</a></label>
            </div>
          </div>
        </div>
        <div class="search-area">
          <div class="search-wrap">
            <form>
              <input type="text" name="">
              <button class="search-btn" type="submit"></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="all-coursee-row">
    <div class="container-fluid">
      <div class="d-flex justify-content-center">
        <div class="title-row"> 
          <!-- <span>LEARN NEW SKILLS</span> -->
          <h2 class="text-uppercase">Live</h2>
        </div>
      </div>
      <ul class="courses-slick">
        @if(count($webinars)>0)
        @php $i=1; @endphp
        @foreach($webinars as $data)
        @if($i == 1 || $i == 9)
        <li class="courses-slide"> @endif
          <div class="slide-item"> <span class="badge badge-warning price-badge"> @if($data->fee) ${{$data->fee}} @else FREE @endif </span> <span class="badge badge-warning price-badge cpe-badge text-uppercase"> {{$data->cpa_credit}} cpe</span> @if(!empty(Session::get('mycpa_client_id'))) <a class="favrite-icon" onclick="WebinarLike({{$data->id}});" href="javascript:void(0);"> @if($data->liked !='') <img id="herat_{{$data->id}}" src="{{config('APP_URL')}}/front_side/images/icon-hart.png" alt="favrite" class="active-favrite"> @else <img id="herat_{{$data->id}}" src="{{config('APP_URL')}}/front_side/images/icon-hart-default.png" alt="favrite" class="default-favrite"> @endif </a> @else <a class="favrite-icon"  href="{{route('client.register')}}"> <img src="{{config('APP_URL')}}/front_side/images/icon-hart-default.png" alt="" class="default-favrite"> <img src="{{config('APP_URL')}}/front_side/images/icon-hart.png" alt="" class="active-favrite"> </a> @endif
            <figure><a href="{{env('APP_URL')}}/course-detail/{{encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"><img src="{{config('APP_URL')}}/front_side/images/thumb.png" alt="favrite"></a></figure>
            <div class="courses-cap">
              <div class="d-flex flex-column courses-details">
                <p>{{$data->title}}</p>
                <p class="user"><a href="javascript:void(0)"><i class="icon-user"><img src="{{config('APP_URL')}}/front_side/images/icon-user.png" alt=""></i>{{$data->first_name}} {{$data->last_name}}</a></p>
                <p class="adviser"><i class="icon-adviser"><img src="{{config('APP_URL')}}/front_side/images/icon-advise.png" alt=""></i>{{$data->CompanyName}}</p>
              </div>
              
              <!-- <div class="d-flex align-items-center justify-content-between credit-area">
                                <p>CPE Credit</p>
                                <p>45</p>
                            </div> -->
              <h3></h3>
              @php
              
              $start_time = Carbon\Carbon::parse($data['start_time']);
              $endtime = Carbon\Carbon::parse($data['end_time']);
              $totalDuration = $endtime->diffInMinutes($start_time);
              @endphp
              <div class="d-flex align-items-center justify-content-between courses-time-row"> @if($data->webinar_type == 'live')
                <p class="badge badge-light">{{ date('d M y', strtotime($start_time))}}</p>
                <p class="badge badge-light">{{ date('h:i A', strtotime($start_time))}}</p>
                @else
                <p class="badge badge-light">{{ date('d M y', strtotime($data->recorded_date))}}</p>
                @endif
                @if(!empty(Session::get('mycpa_client_id')) && !in_array($data->id,$webinarArray)) <a class="btn btn-light btn-sm" href="{{empty(Session::get('mycpa_client_id')) ? route('client.register'):env('APP_URL').'/course-register/'.encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}">Register</a> @endif
                @if(empty(Session::get('mycpa_client_id'))) <a class="btn btn-light btn-sm" href="{{route('client.register')}}">Register</a> @endif </div>
            </div>
          </div>
          @if($i == 8 || $i == 18) </li>
        @endif
        @php $i++; @endphp
        @endforeach
        @else
        <p>No course available</p>
        @endif
      </ul>
      <div class="d-flex align-items-center justify-content-center"> <a href="{{env('APP_URL')}}/course?webinar_type=live" title="View More" class="btn btn-primary btn-viewmore">View More</a> </div>
      <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p> --> 
    </div>
  </section>
  <section class="all-coursee-row">
    <div class="container-fluid">
      <div class="d-flex justify-content-center">
        <div class="title-row"> 
          <!-- <span>LEARN NEW SKILLS</span> -->
          <h2 class="text-uppercase">self study</h2>
        </div>
      </div>
      <ul class="courses-slick">
        @if(count($seflStudyWebinars)>0)
        @php $i=1; @endphp
        @foreach($seflStudyWebinars as $data)
        @if($i == 1 || $i == 9)
        <li class="courses-slide"> @endif
          <div class="slide-item"> <span class="badge badge-warning price-badge"> @if($data->fee) ${{$data->fee}} @else FREE @endif </span> <span class="badge badge-warning price-badge cpe-badge text-uppercase"> {{$data->cpa_credit}} cpe</span> @if(!empty(Session::get('mycpa_client_id'))) <a class="favrite-icon" onclick="WebinarLike({{$data->id}});" href="javascript:void(0);"> @if($data->liked !='') <img id="herat_{{$data->id}}" src="{{config('APP_URL')}}/front_side/images/icon-hart.png" alt="favrite" class="active-favrite"> @else <img id="herat_{{$data->id}}" src="{{config('APP_URL')}}/front_side/images/icon-hart-default.png" alt="favrite" class="default-favrite"> @endif </a> @else <a class="favrite-icon"  href="{{route('client.register')}}"> <img src="{{config('APP_URL')}}/front_side/images/icon-hart-default.png" alt="" class="default-favrite"> <img src="{{config('APP_URL')}}/front_side/images/icon-hart.png" alt="" class="active-favrite"> </a> @endif
            <figure><a href="{{env('APP_URL')}}/course-detail/{{encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"><img src="{{config('APP_URL')}}/front_side/images/thumb.png" alt="favrite"></a></figure>
            <div class="courses-cap">
              <div class="d-flex flex-column courses-details">
                <p>{{$data->title}}</p>
                <p class="user"><a href="#"><i class="icon-user"><img src="{{config('APP_URL')}}/front_side/images/icon-user.png" alt=""></i>{{$data->first_name}} {{$data->last_name}}</a></p>
                <p class="adviser"><i class="icon-adviser"><img src="{{config('APP_URL')}}/front_side/images/icon-advise.png" alt=""></i>{{$data->CompanyName}}</p>
              </div>
              
              <!-- <div class="d-flex align-items-center justify-content-between credit-area">
                                <p>CPE Credit</p>
                                <p>45</p>
                            </div> -->
              <h3></h3>
              @php
              
              $start_time = Carbon\Carbon::parse($data['start_time']);
              $endtime = Carbon\Carbon::parse($data['end_time']);
              $totalDuration = $endtime->diffInMinutes($start_time);
              @endphp
              <div class="d-flex align-items-center justify-content-between courses-time-row"> @if($data->webinar_type == 'live')
                <p class="badge badge-light">{{ date('d M y', strtotime($start_time))}}</p>
                <p class="badge badge-light">{{ date('h:i A', strtotime($start_time))}}</p>
                @else
                <p class="badge badge-light">{{ date('d M y', strtotime($data->recorded_date))}}</p>
                @endif
                @if(!empty(Session::get('mycpa_client_id')) && !in_array($data->id,$webinarArray)) <a class="btn btn-light btn-sm" href="{{empty(Session::get('mycpa_client_id')) ? route('client.register'):env('APP_URL').'/course-register/'.encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}">Register</a> @endif
                @if(empty(Session::get('mycpa_client_id'))) <a class="btn btn-light btn-sm" href="{{route('client.register')}}">Register</a> @endif </div>
            </div>
          </div>
          @if($i == 8 || $i == 18) </li>
        @endif
        @php $i++; @endphp
        @endforeach
        @else
        <p>No course available</p>
        @endif
      </ul>
      <div class="d-flex align-items-center justify-content-center"> <a href="{{env('APP_URL')}}/course?webinar_type=self_study" title="View More" class="btn btn-primary btn-viewmore">View More</a> </div>
      <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p> --> 
    </div>
  </section>
</div>
<script src="{{ env('APP_URL') }}/front_side/js/common.js"></script> 
<script type="text/javascript">
        $(function() {
             $(".ul-wrap").niceScroll({cursorcolor:"#1D3E71"});
        });
        $(window).resize(function() {
          $('.selecttwo').select2();
         
              $('.select2-multiple').select2MultiCheckboxes({
                templateSelection: function(selected, total) {
                  return "Selected " + selected.length ;
                }
              })
        });
        $(document).ready(function() {
			$('#topic_of_interested').on('click',function(e){
				$('#tag_search_filter').submit();	
			});
			
			$('#field_of_study').on('click',function(e){
				$('#course_search_filter').submit();	
			});
			
			
			$('#live_search').on('click',function(e){
				window.location.href = '{{env("APP_URL")}}/course?webinar_type=live';
			});
			
			$('#self_study').on('click',function(e){
				window.location.href = '{{env("APP_URL")}}/course?webinar_type=self_study';
			});
			
			$('#archived').on('click',function(e){
				window.location.href = '{{env("APP_URL")}}/course?webinar_type=archived';
			});
			
            
            //$(".ul-wrap").niceScroll({cursorcolor:"#1D3E71"});
            $('.lbl-filter label a').click(function(){
            	$(this).toggleClass('selected');
            });
            $('body').on('click',function(e) {
               $(".ul-wrap").niceScroll({cursorcolor:"#1D3E71"});
                if($(e.target).is('.lbl-filter label a')){                     
                    $('.lbl-filter .lbl-item-lst').hide();
                    $(e.target).parent().next().show();

                }
                else if($(e.target).is('.lbl-item-lst *') || $(e.target).is('.lbl-item-lst')){
                }
                else{
                    $('.lbl-filter .lbl-item-lst').hide();
                } 
            });
            $('.selecttwo').select2();
            $('.courses-slick').slick({
                  dots: false,
                  arrow: true,
                  infinite: false,
                adaptiveHeight: true,
                  speed: 300,
                  centerMode: true,
                  centerPadding: '0',
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false,
                        dots: false
                      }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                  ]
                });
            $('.main-banner-row').slick({
                dots: false,
                arrow: true,
                infinite: false,
                slidesToShow: 1,
                 slidesToScroll: 1,
                  // speed: 300,
                  // centerMode: true,
                  // centerPadding: '0',
                  
                  // responsive: [
                  //   {
                  //     breakpoint: 1024,
                  //     settings: {
                  //       slidesToShow: 1,
                  //       slidesToScroll: 1,
                  //       infinite: false,
                  //       dots: false
                  //     }
                  //   }
                  // ]
            });

           
            
            
        });
        jQuery(function($) {
          $('.select2-multiple').select2MultiCheckboxes({
            templateSelection: function(selected, total) {
              return "Selected " + selected.length ;
            }
          })
          
        });
    </script> 
@stop