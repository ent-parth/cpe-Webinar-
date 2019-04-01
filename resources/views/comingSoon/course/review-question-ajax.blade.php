@if(!empty(Session::get('mycpa_client_id')))
    <div id="responReviewQuestion">
      <form action="{{route('course-question')}}" class="row"  name="review_answer_form" id="review_answer_form" method="post">
        <div class="tab-captions fade @if(isset($type) && $type == 'review') active @endif" id="rquestions">
          <h2 class="text-center">Review Questions</h2>
          @if($resultStatus == '1')
          <p class="text-success text-center">Congratulations! You have passed successfully. Now you can take the Final Exam after watching the video presentation (above).</p>
          @elseif($resultStatus == '2')
          <p class="text-danger text-center">You have not passed successfully. Now you can't take the Final Exam after watching the video presentation (above).</p>
          @else
          <p class="text-danger text-center"></p>
          @endif
          <ul>
            @if(count($webinarQuestions)>0)
            @php $i=1; @endphp
            @foreach($webinarQuestions as $webinarQuestion)
            @if($webinarQuestion->type == 'review')
            <li>
              <h4>{{$i}}. {{$webinarQuestion->question}}</h4>
              <div class="form-check">
                <label class="form-check-label @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == 'a') @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_a}}
                  <input type="radio" name="review_answer_{{$i.'_'.$webinarQuestion->id}}" required="required" id="review_answer_{{$i.'_'.$webinarQuestion->id}}" @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->
                  id] == 'a') checked="checked" @endif value="a"> <span class="checkround"></span></label>
              </div>
              <div class="form-check">
                <label class="form-check-label @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == 'b') @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_b}}
                  <input type="radio" name="review_answer_{{$i.'_'.$webinarQuestion->id}}" required="required" id="review_answer_{{$i.'_'.$webinarQuestion->id}}" @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->
                  id] == 'b') checked="checked" @endif value="b"> <span class="checkround"></span></label>
              </div>
              <div class="form-check">
                <label class="form-check-label @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == 'c') @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_c}}
                  <input type="radio" name="review_answer_{{$i.'_'.$webinarQuestion->id}}" required="required" id="review_answer_{{$i.'_'.$webinarQuestion->id}}" @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->
                  id] == 'c') checked="checked" @endif value="c"> <span class="checkround"></span></label>
              </div>
              <div class="form-check">
                <label class="form-check-label @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == 'd') @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_d}}
                  <input type="radio" name="review_answer_{{$i.'_'.$webinarQuestion->id}}" required="required" id="review_answer_{{$i.'_'.$webinarQuestion->id}}" @if(!empty($reviewResultArray) && $reviewResultArray[$webinarQuestion->
                  id] == 'd') checked="checked" @endif value="d"> <span class="checkround"></span></label>
              </div>
            </li>
            @php $i++; @endphp
            @endif
            @endforeach
            @else
            <li>
              <p>CPE webinar Question are not available.</p>
            </li>
            @endif
          </ul>
          @if(!$reviewResultStatus && count($webinarQuestions)>0)
          <div class="sndbtn-row text-center">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="type" value="review">
            <input type="hidden" name="webinar_id" value="{{encrypt($id)}}">
            <input type="hidden" name="takeExamAgain" value="0">
            <input type="button" data-type="review" class="btn-primary btn submitReviewQues" value="SUBMIT">
          </div>
          @endif </div>
      </form>
    </div>
@else
    <div class="tab-captions fade active" id="rquestions">
      <p>You have to be registered in order to take the Review Questions.</p>
      <a href="{{route('client.register')}}">
      <input class="btn-primary btn" value="Register" type="button">
      </a> </div>
@endif

@if(!empty(Session::get('mycpa_client_id')) && $reviewResultStatus && $displayFinalExam)
	<form action="{{route('course-question')}}" class="row"  name="final_answer_form" id="final_answer_form" method="post">
    <div class="tab-captions fade @if(isset($type) && $type == 'final') active @endif" id="qfinal">
        <h2 class="text-center">Final Questions</h2>
        <!--<p class="text-success text-center">Congratulations! You have passed successfully. Now you can take the Final Exam after watching the video presentation (above). </p>
        <p class="text-danger text-center"> You have not passed successfully. Now you can't take the Final Exam after watching the video presentation (above). </p>-->
        @if($finalExamResult)
        	@if($finalPer >= 70)
        		<p class="text-success text-center">Congratulations! You have passed successfully. Now you can click on below button and generate your certificate.</p>
                <div class="sndbtn-row text-center">
                <input type="button" class="btn-primary btn" value="Generate Certificate">
                </div>
            @else
            	<ul>
                	@if(count($webinarQuestions)>0)
                    	@php $j=1; @endphp
                        	@foreach($webinarQuestions as $webinarQuestion)
                            	@if($webinarQuestion->type == 'final')
                                	<li>
                                        <h4>{{$j}}. {{$webinarQuestion->question}}</h4>
                                        <div class="form-check">
                                            <label class="form-check-label @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == 'a') @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_a}}
                                            <input type="radio" name="final_answer_{{$j.'_'.$webinarQuestion->id}}" required="required" id="final_answer_{{$j.'_'.$webinarQuestion->id}}" value="a"> <span class="checkround"></span></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == 'b') @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_b}}
                                            <input type="radio" name="final_answer_{{$j.'_'.$webinarQuestion->id}}" required="required" id="final_answer_{{$j.'_'.$webinarQuestion->id}}" value="b"> <span class="checkround"></span></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == 'c') @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_c}}
                                            <input type="radio" name="final_answer_{{$j.'_'.$webinarQuestion->id}}" required="required" id="final_answer_{{$j.'_'.$webinarQuestion->id}}" value="c"> <span class="checkround"></span></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == 'd') @if(!empty($finalResultArray) && $finalResultArray[$webinarQuestion->id] == $webinarQuestion->answer) color-green @else color-red @endif @endif">{{$webinarQuestion->option_d}}
                                            <input type="radio" name="final_answer_{{$j.'_'.$webinarQuestion->id}}" required="required" id="final_answer_{{$j.'_'.$webinarQuestion->id}}" value="d"> <span class="checkround"></span></label>
                                        </div>
                                 	</li>
                                	@php $j++; @endphp
                               @endif
                           @endforeach
                @else
                    <li>
                        <p>CPE webinar Question are not available.</p>
                    </li>
                @endif
             </ul>
             	<div class="sndbtn-row text-center">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" value="final">
                    <input type="hidden" name="webinar_id" value="{{encrypt($id)}}">
                    <input type="hidden" name="takeExamAgain" value="0">
                    <input type="button" data-type="final" class="btn-primary btn submitReviewQues" value="SUBMIT">
                </div>
          @endif
    	@else
        	<p class="text-danger text-center">You have not passed the Final Exam. In order to earn credit for this course, you must have a passing grade of 70% or higher. We encourage you to review the material and take the Exam again. </p>
            <div class="sndbtn-row text-center">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="type" value="final">
                <input type="hidden" name="webinar_id" value="{{encrypt($id)}}">
                <input type="hidden" name="takeExamAgain" value="1">
                <input type="button" data-type="final" class="btn-primary btn submitReviewQues" value="Take Final Exam Again">
            </div>
        @endif
        
      </div>
    </form>
    @elseif(!empty(Session::get('mycpa_client_id')) && $reviewResultStatus && empty($selfStudyVideoDuration))
        <div class="tab-captions fade" id="qfinal">
          <p id="displayPer">You have to watch the video presentation (above) in order to take the Final Exam.</p>
        </div>	
    @elseif(!empty(Session::get('mycpa_client_id')) && $reviewResultStatus && !empty($selfStudyVideoDuration))
        <div class="tab-captions fade" id="qfinal">
          <p id="displayPer">You have watched only {{round($selfStudyVideoDuration->play_time_duration*100/$webinar->duration,2)}}% of the video. Please continue with the video.</p>
        </div>		
    @else
        <div class="tab-captions fade" id="qfinal">
          <p>You have to answer the Review Questions as well as watch the video presentation (above) in order to take the Final Exam.</p>
        </div>
        
    @endif
</div>
