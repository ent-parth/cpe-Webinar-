@extends( 'layouts_comingsoon.master' )
@section( 'content' )
<div id="content-area">
<section class="main-banner-row" style="background-image:url({{env('APP_URL')}}/images/banner-bg.png)">
    <div class="container-fluid">
      <div class="banner-caption">
        <h1>The Biggest E-learning Educational portal for Accounting and Tax professionals</h1>
        <p>20,000+ Registered User | 1000+ Speakers | 10000+ Hours of CPE Credits | Free Mobile Application</p>
      </div>
      <div class="search-area">
         <form id="searchWebinar" name="searchWebinar" action="{{route('comingsoon-course')}}" method="get" enctype="multipart/form-data">
       
          <div class="d-md-flex justify-content-md-between searcharea-row">
            <div class="flex-item">
              <div class="form-group">
                <label for="">Select Field of Study</label>
                <select name="subject_area" id="subject_area" class="selecttwo form-control">
				   <option value="">Select Subject Area</option>
                   @foreach($subjectAria as $subject_aria)
                      <option value="{{$subject_aria->id}}"  @if($subject_aria->id ==  app('request')->input('subject_area')) selected @endif >{{$subject_aria->name}}</option>
                    @endforeach
                 </select>
              </div>
            </div>
            <div class="flex-item">
              <div class="form-group">
                <label for="">Select Webinar Type</label>
                <select name="webinar_type" id= "webinar_type"class="form-control selecttwo">
                 <option value="">Select Webinar Type</option>
                  <option value="self_study" @if('self_study'==  app('request')->input('webinar_type')) selected @endif >Self Study</option>
                </select>
              </div>
            </div>
            <div class="flex-item">
              <div class="form-group">
                <label for="">Free/Paid</label>
                <select name="fee" id="fee" class="form-control">
                <option value="">Select Payment Type</option>
                  <option value="free" @if('free'==  app('request')->input('fee')) selected @endif>Free</option>
                  <option value="paid" @if('paid'==  app('request')->input('fee')) selected @endif>Paid</option>
                  
                </select>
              </div>
            </div>
            <div class="flex-item">
              <div class="form-group">
                <label for="">Select Company Name</label>
                <select name="companies" id="companies" class="form-control">
                	<option value="">Select Company Name</option>
                    @foreach($companies as $company)
                      <option value="{{$company->id}}" @if(app('request')->input('companies') == $company->id) selected="selected" @endif>{{$company->name}}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Search</button>
        </form>
      </div>
    </div>
  </section>
  <section class="all-coursee-row">
    <div class="container-fluid">
      <div class="d-flex">
        <div class="title-row"> <span>LEARN NEW SKILLS</span>
          <h2>Courses.</h2>
        </div>
      </div>
      <ul class="courses-slick">
        <li class="courses-slide">
          @if(count($webinars) >0)
          @foreach($webinars as $data)
          <div class="slide-item"> <span class="badge badge-warning price-badge">@if($data->fee) ${{$data->fee}} @else FREE @endif</span> <a class="favrite-icon" href="javascript:void(0);"><img src="{{env('APP_URL')}}/images/icon-hart.png" alt=""></a>
            <figure><a href="{{env('COMINGSOON_URL')}}/comingsoon-course-detail/{{encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"><img src="{{env('APP_URL')}}/images/thumb.png" alt=""></a></figure>
            <div class="courses-cap">
              <div class="d-flex align-items-center justify-content-between courses-details">
                <p>{{$data->first_name}} {{$data->last_name}}</p>
                <p><span>{{$data->name}}</span></p>
                @php
               
                $start_time = Carbon\Carbon::parse($data['start_time']);
                $endtime = Carbon\Carbon::parse($data['end_time']);
                $totalDuration = $endtime->diffInMinutes($start_time);
                @endphp

                <p>@if($totalDuration) {{$totalDuration}} Minuts @endif</p>
              </div>
              <h3><a href="{{env('COMINGSOON_URL')}}/comingsoon-course-detail/{{encrypt($data->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}">{{$data->title}}</a></h3>
              <p class="courses-caption">@php echo  mb_strimwidth($data->description, 0, 100, "...") @endphp</p>
              @if($data->cpe_credit)
              <div class="d-flex align-items-center justify-content-between credit-area">
                <p>CPE Credit</p>
                <p>{{$data->cpe_credit}}</p>
              </div>
              @endif
              <div class="d-flex align-items-center justify-content-between courses-time-row">
                
                @if($data->webinar_type == 'live')
                    <p class="badge badge-light">{{ date('d M y', strtotime($start_time))}}</p>
                    <p class="badge badge-light">{{ date('h:i A', strtotime($start_time))}}</p>
                @else
                	<p class="badge badge-light">{{ date('d M y', strtotime($data->recorded_date))}}</p>
                @endif
                
                @if(!empty(Session::get('mycpa_client_id')) && !in_array($data->id,$webinarArray))
                    <a class="btn btn-light btn-sm" href="javascript:void(0);">Register</a> 
                @endif
                @if(empty(Session::get('mycpa_client_id')))
                	<a class="btn btn-light btn-sm" href="javascript:void(0);">Register</a> 
                @endif
             </div>
            </div>
          </div>
          @endforeach
          @else
          <p>No course found</p>
          @endif
       
        </li>
      </ul>
       <div class="pull-right">{{$webinars->links()}}</div>
    </div>
  </section>
</div>
<script type="text/javascript">
        $(window).resize(function() {
          $('.selecttwo').select2();
         
              $('.select2-multiple').select2MultiCheckboxes({
                templateSelection: function(selected, total) {
                  return "Selected " + selected.length ;
                }
              })
        });
        $(document).ready(function() {
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