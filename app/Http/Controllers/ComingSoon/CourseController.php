<?php
namespace App\Http\Controllers\ComingSoon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use App\Repositories\Companies;
use App\Repositories\Courses;
use App\Repositories\Webinar;
use App\Repositories\WebinarQuestions;
use App\Repositories\WebinarQuestionResult;
use App\Repositories\WebinarSelfstudyVideoDuration;
use App\Repositories\WebinarUserRegister;
use App\Repositories\Users;
use Response;
use Redirect;
use Mail;
use DateTime;
use DateTimeZone;
use File;


class CourseController extends Controller{
	
	/**
     * Show the Course listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){ 
		$subjectAria = Courses::select('id', 'name','course_level_id')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
        $companies = Companies::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();

        $webinars = Webinar::select('webinars.id','webinars.title', 'webinars.description', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at','webinars.cpa_credit','speakers.first_name','speakers.last_name','companies.name','webinar_like.id as liked') 
                             ->leftJoin('speakers','speakers.id','=','webinars.created_by')
                             ->leftJoin('companies','companies.id','=','speakers.company_id')
							 ->leftJoin('webinar_like','webinars.id','=','webinar_like.webinar_id');

        $webinars = $webinars->where('webinars.status', '=', 'active');
        
		// For subject_area filter            
        $subject_area = $request->input('subject_area');
        if ($subject_area != '') {
               $webinars  = $webinars->whereRaw('FIND_IN_SET('.$subject_area.', webinars.subject_area)');
        }
        
		// For webinar_type filter      
        $webinar_type = $request->input('webinar_type');
        if ($webinar_type != '') {
               $webinars  = $webinars->where('webinars.webinar_type', '=', $webinar_type);
        }
        
		$fee = $request->input('fee');
        if ($fee == 'paid') {
        	$webinars  = $webinars->where('webinars.fee', '!=', Null);
        }else if ($fee == 'free') {
            $webinars  = $webinars->where('webinars.fee', '=', Null);
        }

        if ($webinar_type == 'live') {
			$current = Carbon::now();
            $webinars  = $webinars->where('start_time', '>=', $current)->orderby('webinars.start_time', 'desc');
        }else if ($webinar_type == 'self_study') {
            $webinars  = $webinars->orderby('webinars.recorded_date', 'desc');
        }else if ($webinar_type == 'archived') {
        	$webinars  = $webinars->orderby('webinars.recorded_date', 'desc');
        }
		
		$company_id = $request->input('companies');
        if ($company_id != '') {
        	$webinars  = $webinars->where('speakers.company_id', '=', $company_id);
        }

        $webinars  = $webinars->paginate(env('PAGINATION'));
        $webinars = $webinars->appends(request()->query());
		
		$webinarRegisters = WebinarUserRegister::where('user_id',Session::get('mycpa_client_id'))->where('payment_status','success')->get();
		$webinarArray = [];
		foreach($webinarRegisters as $webinarRegister){
			//$webinarArray[][$webinarRegister->user_id] = $webinarRegister->webinar_id;
			$webinarArray[] = $webinarRegister->webinar_id;	
		}
		//dd($webinarArray);
        return view('comingSoon.course.index',compact('webinars','subjectAria','companies','webinarArray'));
    }
	
	
	/**
     * Show the Course detail page.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request,$string=NULL){
		$id = decrypt($string);
    	if(is_numeric($id) && !empty($id)){
			$webinar = Webinar::Select('webinars.id','webinars.title','webinars.webinar_type','webinars.description','webinars.fee','webinars.time_zone','webinars.recorded_date',
								'webinars.start_time','webinars.end_time','webinars.subject_area','webinars.cpa_credit','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation',
								'webinars.who_should_attend','webinars.tag','webinars.documents','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5',
								'webinars.webinar_transcription','webinars.presentation_length','webinars.status','webinars.video','webinars.webinar_key','webinars.created_by','webinars.added_by',
								'webinars.vimeo_embaded','webinars.duration',
								'speakers.created_by','speakers.created_at','speakers.first_name','speakers.last_name','speakers.expertise','speakers.about_speaker','speakers.about_company',
								'speakers.company_id','speakers.email','speakers.contact_no','speakers.avatar','companies.name as companyName','companies.logo','companies.website','companies.description as companyDescription')
								->leftjoin('speakers','speakers.id','=','webinars.created_by')
								->leftjoin('companies','companies.id','=','speakers.company_id')
								->where('webinars.status','active')
								->where('webinars.webinar_type','self_study')
								->where('webinars.id',$id)
								->first();
								
			if(!empty($webinar)){
				//get live webinat list
				$liveWebinars = [];
				
				$selfStudyWebinars = Webinar::Select('id','title','start_time','webinar_type')
											->where('status','active')
											->where('webinar_type','self_study')
											->orderBy('start_time','ASC')
											->take(3)
											->get();						
				
				$webinarQuestions = [];
				if(!empty($webinar) && $webinar->webinar_type == 'self_study'){
					$webinarQuestions = WebinarQuestions::where('webinar_id',$webinar->id)->get();	
				}
				
				//get webinar question and answer result for review question.
				$webinarQusReviewResults = WebinarQuestionResult::where('type','review')->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->get();
				$reviewResultArray = [];
				$reviewResultStatus = '';
				
				if(count($webinarQusReviewResults)>0){
					foreach($webinarQusReviewResults as $webinarQusReviewResult){
						$reviewResultArray[$webinarQusReviewResult->question_id] = $webinarQusReviewResult->answer;	
					}
					
					//code for show hide submit button in form
					foreach($webinarQusReviewResults as $webinarQusReviewResult){
						if($webinarQusReviewResult->result == '1'){
							$reviewResultStatus = true;				
						}else{
							$reviewResultStatus = false;
							break;				
						}
					}
				}
				
				
				//get webinar question and answer result for final question.
				$webinarQusFinalResults = WebinarQuestionResult::where('type','final')->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->get();
				$finalResultArray = [];
				$finalResultStatus = '';
				
				if(count($webinarQusFinalResults)>0){
					foreach($webinarQusFinalResults as $webinarQusFinalResult){
						$finalResultArray[$webinarQusFinalResult->question_id] = $webinarQusFinalResult->answer;	
					}
					
					//code for show hide submit button in form
					foreach($webinarQusFinalResults as $webinarQusFinalResult){
						if($webinarQusFinalResult->result == '1'){
							$finalResultStatus = true;				
						}else{
							$finalResultStatus = false;
							break;				
						}
					}
				}
				$resultStatus = '0';
				
				//calculation for check login user has been seen video or not, than and than he can submit final exam.
				$webinarDuration = $webinar->duration;
				$selfStudyVideoDuration = WebinarSelfstudyVideoDuration::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->first();
				$displayFinalExam = false;
				if(!empty($selfStudyVideoDuration)){
					$userSeenVideoDuration = $selfStudyVideoDuration->play_time_duration;
					if($webinarDuration <= ($userSeenVideoDuration+5)){
						$displayFinalExam = true;	
					}
				}
				$type = 'review';
				
				
				//check type is final thna check result and update table
				$finalExamResult = true;
				$trueAnswer = 0;
				$falseAnswer = 0;
				$totalQuestion = 0;
				$finalPer = 0;
				$getWebinarQusResults = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->where('type','final')->get();		
				if(count($getWebinarQusResults)>0){
					foreach($getWebinarQusResults as $getWebinarQusResult){
						if($getWebinarQusResult->result == '1'){
							$trueAnswer++;	
						}elseif($getWebinarQusResult->result == '0'){
							$falseAnswer++;	
						}
						$totalQuestion++;	
					}
					$finalPer = $trueAnswer*100/$totalQuestion;
					if($finalPer >= 70){
						$finalExamResult = true;
					}else{
						//delete latest question and answer for this user
						//$deleteResult = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->where('type',$type)->delete();	
						$finalExamResult = false;
					}
				}else{
					$finalExamResult = true;	
				}
				
				$webinarRegisters = WebinarUserRegister::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->where('payment_status','success')->where('status','active')->first();
				
				//if ajax call than pass it
				if ($request->ajax()) {
					return view('comingSoon.course.detail',compact('id','webinar','resultStatus','liveWebinars','webinarQuestions','selfStudyWebinars','reviewResultArray','webinarQusReviewResults','reviewResultStatus','webinarQusFinalResults','finalResultArray','finalResultStatus','displayFinalExam','selfStudyVideoDuration','type','finalExamResult','finalPer','webinarRegisters'));		
				}
				return view('comingSoon.course.detail',compact('id','webinar','resultStatus','liveWebinars','webinarQuestions','selfStudyWebinars','reviewResultArray','webinarQusReviewResults','reviewResultStatus','webinarQusFinalResults','finalResultArray','finalResultStatus','displayFinalExam','selfStudyVideoDuration','type','finalExamResult','finalPer','webinarRegisters'));		
			}else{
				Session::put('mycpa_message_error', 'We cant find this webinar, please try again.');
				return Redirect('/');
			}
		}else{
			Session::put('mycpa_message_error', 'Something went wrong, please try again.');
			return redirect('/');	
		}
    }
	
	
	/**
     * Change time zone for webinar
     *
     * @return \Illuminate\Http\Response
     */
    public function changeTimezone(Request $request){
		$timeZone = $request->input('timeZone');
		$start_at = $request->input('start_at');
		$created_at = $request->input('created_at');
		
		if(!empty($timeZone) && !empty($created_at) && empty($start_at)){
			$displayEndDate = new DateTime($created_at);
			$displayEndDate->setTimezone(new DateTimeZone($timeZone));
			$finaldisplayEndDate = $displayEndDate->format('Y-m-d');
			return date("l, F d, Y",strtotime($finaldisplayEndDate)).' '.$timeZone;
		}elseif(!empty($timeZone) && empty($created_at) && !empty($start_at)){
			$displayEndDate = new DateTime($start_at);
			$displayEndDate->setTimezone(new DateTimeZone($timeZone));
			$finaldisplayEndDate = $displayEndDate->format('Y-m-d H:i:s');
			return date("l, F d, Y: H:i A",strtotime($finaldisplayEndDate)).' '.$timeZone;	
		}else{
			return Response::json(['error' => true], 300);	
		}
	}
	
	
	
	/**
     * Store webinar question and answer
     *
     * @return \Illuminate\Http\Response
     */
    public function storeQuestion(Request $request){
		$webinarId = decrypt($request->input('webinar_id'));
		$type = $request->input('type');
		$takeExamAgain = $request->input('takeExamAgain');
		if(!empty($webinarId) && is_numeric($webinarId) && !empty($type)){
			//get Question 
			$webinarQuestionss = WebinarQuestions::where('webinar_id',$webinarId)->where('type',$type)->get();
			if(count($webinarQuestionss)>0){
				if($takeExamAgain == '0'){
					$i = 1;
					foreach($webinarQuestionss as $webinarQuestion){
						if($type == 'review'){ //if you add more type in question table than you hav eto add it here....
							$webinarAnswer = $request->input('review_answer_'.$i.'_'.$webinarQuestion->id);
						}elseif($type == 'final'){
							$webinarAnswer = $request->input('final_answer_'.$i.'_'.$webinarQuestion->id);
						}else{
							return Response::json(['error' => true,'message' => 'There was a some issue in add/update question, please try again'], 300);
						}
						
						//check result
						$result = '0';
						if($webinarAnswer == $webinarQuestion->answer){
							$result = '1';	
						}
						
						//store answer and calculation result
						$webinarQusResult = WebinarQuestionResult::where('question_id',$webinarQuestion->id)->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->where('type',$type)->first();
						if(empty($webinarQusResult)){
							$value = ['question_id'=>$webinarQuestion->id,
									  'user_id'=>Session::get('mycpa_client_id'),
									  'webinar_id'=>$webinarId,
									  'answer'=>$webinarAnswer,
									  'type'=>$type,
									  'created_by'=>Session::get('mycpa_client_id'),
									  'created_at'=>Carbon::now(),
									  'result'=>$result];
							$createAnswer = WebinarQuestionResult::create($value);
						}else{
							$updateData = ['question_id'=>$webinarQuestion->id,
										  'user_id'=>Session::get('mycpa_client_id'),
										  'webinar_id'=>$webinarId,
										  'answer'=>$webinarAnswer,
										  'type'=>$type,
										  'created_by'=>Session::get('mycpa_client_id'),
										  'updated_at'=>Carbon::now(),
										  'result'=>$result];
							$updateAnswer = WebinarQuestionResult::where('id',$webinarQusResult->id)->update($updateData);	
						}
						$i++;	
					}
				}
				//check type is final thna check result and update table
				$finalExamResult = true;
				$finalPer = 0;
				if($type == 'final'){
					$trueAnswer = 0;
					$falseAnswer = 0;
					$totalQuestion = 0;
					$finalPer = 0;
					$getWebinarQusResults = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->where('type',$type)->get();		
					if(count($getWebinarQusResults)>0){
						foreach($getWebinarQusResults as $getWebinarQusResult){
							if($getWebinarQusResult->result == '1'){
								$trueAnswer++;	
							}elseif($getWebinarQusResult->result == '0'){
								$falseAnswer++;	
							}
							$totalQuestion++;	
						}
						$finalPer = $trueAnswer*100/$totalQuestion;
						if($finalPer >= 70){
							$finalExamResult = true;
						}else{
							//delete latest question and answer for this user
							//$deleteResult = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->where('type',$type)->delete();	
							$finalExamResult = false;
						}
					}else{
						$finalExamResult = true;	
					}
				}
				
				//take exam Again
				if($takeExamAgain == '1' && $type == 'final'){
					$deleteResult = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->where('type',$type)->delete();	
					$finalExamResult = true;	
				}
				
				//check result for given question and answer
				$questionResults = WebinarQuestionResult::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->get();
				$resultStatus = '0';
				foreach($questionResults as $questionResult){
					if($questionResult->result == '1'){
						$resultStatus = '1';				
					}else{
						$resultStatus = '2';
						break;				
					}
				}
				
				//check if webinar type is self-study or not.	
				$webinar = Webinar::Select('webinars.id','webinars.webinar_type','duration')
									->where('webinars.status','active')
									->where('webinars.id',$webinarId)
									->first();
									
				$webinarQuestions = [];
				if(!empty($webinar) && $webinar->webinar_type == 'self_study'){
					$webinarQuestions = WebinarQuestions::where('webinar_id',$webinar->id)->get();	
				}
				
				//get webinar question and answer result for review question.
				$webinarQusReviewResults = WebinarQuestionResult::where('type','review')->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->get();
				$reviewResultArray = [];
				$reviewResultStatus = '';
				
				if(count($webinarQusReviewResults)>0){
					foreach($webinarQusReviewResults as $webinarQusReviewResult){
						$reviewResultArray[$webinarQusReviewResult->question_id] = $webinarQusReviewResult->answer;	
					}
					
					//code for show hide submit button in form
					foreach($webinarQusReviewResults as $webinarQusReviewResult){
						if($webinarQusReviewResult->result == '1'){
							$reviewResultStatus = true;				
						}else{
							$reviewResultStatus = false;
							break;				
						}
					}
				}
				
				
				//get webinar question and answer result for final question.
				$webinarQusFinalResults = WebinarQuestionResult::where('type','final')->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinarId)->get();
				$finalResultArray = [];
				$finalResultStatus = '';
				
				if(count($webinarQusFinalResults)>0){
					foreach($webinarQusFinalResults as $webinarQusFinalResult){
						$finalResultArray[$webinarQusFinalResult->question_id] = $webinarQusFinalResult->answer;	
					}
					
					//code for show hide submit button in form
					foreach($webinarQusFinalResults as $webinarQusFinalResult){
						if($webinarQusFinalResult->result == '1'){
							$finalResultStatus = true;				
						}else{
							$finalResultStatus = false;
							break;				
						}
					}
				}
				$id = $webinarId;
				
				//calculation for check login user has been seen video or not, than and than he can submit final exam.
				$webinarDuration = $webinar->duration;
				$selfStudyVideoDuration = WebinarSelfstudyVideoDuration::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->first();
				$displayFinalExam = false;
				if(!empty($selfStudyVideoDuration)){
					$userSeenVideoDuration = $selfStudyVideoDuration->play_time_duration;
					if($webinarDuration <= ($userSeenVideoDuration+5)){
						$displayFinalExam = true;	
					}
				}
				return Response::json(View('comingSoon/course/review-question-ajax', compact('resultStatus','id','webinarQuestions','webinarQusReviewResults','reviewResultArray','reviewResultStatus','webinarQusFinalResults','finalResultArray','finalResultStatus','displayFinalExam','selfStudyVideoDuration','type','finalExamResult','finalPer','webinar'))->render());
			}else{
				return Response::json(['error' => true,'message' => "There was a some issue in getting question, please try again."], 300);				
			}
		}else{
			return Response::json(['error' => true,'message' => "Please provide valid data, please try again."], 300);				
		}
	}
	
	
	/**
     * Update vwebinar video duration in database
     *
     * @return \Illuminate\Http\Response
     */
    public function updateVideoTimeDuration(Request $request){
		$webinarId = decrypt($request->input('webinar_id'));	
		$duration = round($request->input('duration'));	
		$userId = Session::get('mycpa_client_id');
		if(!empty($webinarId) && !empty($duration) && !empty($userId)){
			$updateW = ['duration'=>$duration];
			$updateWebinar = Webinar::where('id',$webinarId)->update($updateW);
			return Response::json(['success' => true], 200);		
		}else{
			return Response::json(['error' => true], 300);		
		}
	}
	
	
	/**
     * Calculate video streming and store in database
     *
     * @return \Illuminate\Http\Response
     */
    public function calculateVideoTime(Request $request){
		$webinarId = decrypt($request->input('webinar_id'));	
		$userId = Session::get('mycpa_client_id');
		$durationTime = round($request->input('durationTime'));
		if(!empty($webinarId) && !empty($durationTime) && !empty($userId)){
			//check add data or update
			$videoDurationDetail = WebinarSelfstudyVideoDuration::where('webinar_id',$webinarId)->where('user_id',$userId)->first();
			if(empty($videoDurationDetail)){
				$addData = ['webinar_id'=>$webinarId,
							'user_id'=>$userId,
							//'play_time_duration'=>$durationTime,
							'play_time_duration'=>'1',
							'created_at'=>Carbon::now()];
				$addWebinarDuration = WebinarSelfstudyVideoDuration::create($addData);
			}else{
				$diffrence = $durationTime - $videoDurationDetail->play_time_duration;		
				if($diffrence > 0 && $diffrence <= '10'){
					$updateData = ['webinar_id'=>$webinarId,
									'user_id'=>$userId,
									'play_time_duration'=>$durationTime,
									'updated_at'=>Carbon::now()];
					$addWebinarDuration = WebinarSelfstudyVideoDuration::where('webinar_id',$webinarId)->where('user_id',$userId)->update($updateData);		
				}
			}
			$videoDurationDetails = WebinarSelfstudyVideoDuration::Select('id','play_time_duration')->where('webinar_id',$webinarId)->where('user_id',$userId)->first();
			return Response::json(['success' => true, 'realTime'=>$videoDurationDetails->play_time_duration], 200);	
		}else{
			return Response::json(['error' => true], 300);	
		}
	}
	
	
	
	/**
     * user registration for webinar
     *
     * @return \Illuminate\Http\Response
     */
    public function webinarRegister($webinar_id, Request $request){
		$userId = Session::get('mycpa_client_id');
		$webinar_id = decrypt($webinar_id);
		if(!empty($webinar_id) && !empty($userId)){
			//get webinar detail
			$webinarDetail = Webinar::Select('webinars.id','webinars.webinar_type','webinars.start_time','webinars.end_time','webinars.fee')->where('id',$webinar_id)->where('status','active')->first();
			if(!empty($webinarDetail)){
				if($webinarDetail->webinar_type == 'live'){ //write logic for live webinar
					//check current login user has register or not
					$webinarRegister = WebinarUserRegister::where('webinar_type','live')->where('user_id',$userId)->where('webinar_id',$webinar_id)->first();
					if(empty($webinarRegister)){
						//check alredy registed webinar date and time
						$checkWebinarRegister = WebinarUserRegister::where('webinar_type','live')->where('user_id',$userId)->whereBetween('start_time', [$webinarDetail->start_time, $webinarDetail->end_time])->whereBetween('end_time', [$webinarDetail->start_time, $webinarDetail->end_time])->first();
						if(empty($checkWebinarRegister)){
							//check webinat type its free or paid
							//echo $webinarDetail->fee; exit;
							if(empty($webinarDetail->fee) || $webinarDetail->fee == NULL){
								$storeWebinar = ['user_id'=>$userId,
												'webinar_id'=>$webinarDetail->id,
												'webinar_type'=>$webinarDetail->webinar_type,
												'start_time'=>$webinarDetail->start_time,
												'end_time'=>$webinarDetail->end_time,
												'payment_type'=>'free',
												'payment_status'=>'success',
												'status'=>'active',
												'created_at'=>Carbon::now()];
								$addWebinarRegister = WebinarUserRegister::create($storeWebinar);
								$addAttendeeGoto = $this->CreateAttendees($webinar_id, 'create',  $request);
								if($addAttendeeGoto) {
									Session::put('mycpa_message_success', 'You have been successfully registered for this webinar.');
									return redirect()->back();
								} else {
									Session::put('mycpa_message_error', 'Problem in registration with go to webinar API.');
									return redirect()->back();
								}
								//entry on atendy
								//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=create&redirect_uri='.env("APP_URL").'/course-create-webinar-attendees/'.$webinar_id;
								//return redirect($url);
								
							}else{
								//write code for paid webinar.
								return redirect('comingsoon-course-register-payment/'.encrypt($webinar_id));
							}
						}else{
							Session::put('mycpa_message_error', 'You have already registered webinar for this time slot, please check.');
							return redirect()->back();
						}
					}else{
						Session::put('mycpa_message_error', 'You have already registered for this webinar.');
						return redirect()->back();
					}
				}elseif($webinarDetail->webinar_type == 'self_study'){ //write login for self study 
					//check current login user has register or not
					$webinarRegister = WebinarUserRegister::where('webinar_type','self_study')->where('user_id',$userId)->where('webinar_id',$webinar_id)->first();
					if(empty($webinarRegister)){
						//check webinat type its free or paid
						if(empty($webinarDetail->fee) || $webinarDetail->fee == NULL){
							$storeWebinar = ['user_id'=>$userId,
											'webinar_id'=>$webinarDetail->id,
											'webinar_type'=>$webinarDetail->webinar_type,
											'start_time'=>$webinarDetail->start_time,
											'end_time'=>$webinarDetail->end_time,
											'payment_type'=>'free',
											'payment_status'=>'success',
											'status'=>'active',
											'created_at'=>Carbon::now()];
							$addWebinarRegister = WebinarUserRegister::create($storeWebinar);
							Session::put('mycpa_message_success', 'You have been successfully registered for this webinar.');
							return redirect()->back();		
						}else{
							//write code for paid webinar.
							return redirect('comingsoon-course-register-payment/'.encrypt($webinar_id));	
						}
					}else{
						Session::put('mycpa_message_error', 'You have already registered for this webinar.');
						return redirect()->back();
					}
				}else{ //write logic for archived
					$storeWebinar = ['user_id'=>$userId,
									'webinar_id'=>$webinarDetail->id,
									'webinar_type'=>$webinarDetail->webinar_type,
									'start_time'=>$webinarDetail->start_time,
									'end_time'=>$webinarDetail->end_time,
									'payment_type'=>'free',
									'payment_status'=>'success',
									'status'=>'active',
									'created_at'=>Carbon::now()];
					$addWebinarRegister = WebinarUserRegister::create($storeWebinar);
					Session::put('mycpa_message_success', 'You have been successfully registered for this webinar.');
					return redirect()->back();	
				}
			}else{
				Session::put('mycpa_message_error', 'Opps...! We cant find webinar, please try again.');
				return redirect()->back();
			}
		}else{
			Session::put('mycpa_message_error', 'Something went wrong, please try again.');
			return redirect('/');	
		}
	}
	
	
	
	/**
     * Make payment for register payment
     *
     * @return \Illuminate\Http\Response
     */
    public function webinarRegisterPayment($webinar_id){
		if(!empty($webinar_id)){
			$webinar_id = decrypt($webinar_id);
			$webinarRegister = WebinarUserRegister::Select('id','user_id','webinar_id','payment_status','transection_id')->where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$webinar_id)->first();
			$webinar = Webinar::where('id',$webinar_id)->where('status','active')->first();
			return view('comingSoon.course.make-payment',compact('webinar','webinarRegister'));		
		}else{
			Session::put('mycpa_message_error', 'Something went wrong, please try again.');
			return redirect()->route('comingsoon-course',$request->getQueryString());
		}
	}
	
	
	
	/**
     * make webinar payment
     *
     * @return \Illuminate\Http\Response
     */
    public function makePayment(Request $request){
		$webinarId = decrypt($request->input('webinar_id'));	
		$userId = Session::get('mycpa_client_id');
		$amount = (int)$request->input('amount');
		$stripeAmount = $amount/100;
		$stripeToken = $request->input('stripeToken');
		//dd($request->all());
		
		//Verified amount for this webinar
		if(!empty($webinarId) && is_numeric($webinarId)){
			$webinar = Webinar::Select('id','fee')->where('id',$webinarId)->where('status','active')->first();
			if(!empty($webinar)){
				if($stripeAmount == $webinar->fee){
					//make curl call for payment
					$url = "https://api.stripe.com/v1/charges";
					$curl = curl_init();
					$data = "amount=$amount&currency=usd&source=$stripeToken";
			
					curl_setopt_array($curl, array(
					  CURLOPT_URL => $url,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS =>  $data,
					  CURLOPT_HTTPHEADER => array(
						"Authorization: Bearer ".env('STRIPE_SECRET_KEY'),
						"Content-Type: application/x-www-form-urlencoded"
					  ),
					));
					$result = curl_exec($curl);
					$error = curl_error($curl);
					curl_close($curl);
					
					if($error){
						Session::put('mycpa_message_error', 'Thare was some error on payment process. Error are #: '.curl_error($curl).', please try again.');
						return redirect()->route('comingsoon-course',$request->getQueryString());
					}else{
						$result = json_decode($result,true);
						//dd($request->all());
						//dd($result);
						if(isset($result['status']) == 'succeeded' && isset($result['amount']) && !empty($result['amount'])){
							$userId = Session::get('mycpa_client_id');
							$webinarId = decrypt($request->input('webinar_id'));	
							if(!empty($userId) && !empty($webinarId)){
								$webinar = Webinar::Select('id','fee','webinar_type','start_time','end_time')->where('id',$webinarId)->where('status','active')->first();
								$storeWebinar = ['user_id'=>$userId,
												'webinar_id'=>$webinar->id,
												'webinar_type'=>$webinar->webinar_type,
												'start_time'=>$webinar->start_time,
												'end_time'=>$webinar->end_time,
												'transection_id'=>$result['balance_transaction'],
												'paid_amount'=>$result['amount']/100,
												'payment_type'=>'paid',
												'payment_status'=>'success',
												'status'=>'active',
												'created_at'=>Carbon::now()];
									$addWebinarRegister = WebinarUserRegister::create($storeWebinar);
									//Session::forget('webinar_id'); //unset session variable
									//Create new attendees for this webinar
									if($webinar->webinar_type == 'live'){
										$addAttendeeGoto = $this->CreateAttendees($webinar->id, 'create',  $request);
										if($addAttendeeGoto) {
											Session::put('mycpa_message_success', 'Payment Done successfully. You have been successfully registered for this webinar.');
											return redirect()->back();
										} else {
											Session::put('mycpa_message_error', 'ayment Done successfully. Problem in registration with go to webinar API.');
											return redirect()->back();
										}
										
										//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=create&redirect_uri='.env("APP_URL").'/course-create-webinar-attendees/'.$webinarId;
										//return redirect($url);
									}else{
										Session::put('mycpa_message_success', 'You have been successfully registered for this webinar.');
										return redirect()->back();
									}
							}else{
								Session::put('mycpa_message_warning', 'Your payment successfully done for this webinar but issue in store data, please inform to admin. your Transection id #: '.$result['balance_transaction']);
								return redirect()->back();
							}
						}else{
							$errMsg = 'Something went wrong on payment process, please try again.';
							if(isset($result['error'])){
								$errMsg = $result['error']['message'];
							}
							Session::put('mycpa_message_error', $errMsg);
							return Redirect('comingsoon-course-register-payment/'.encrypt($webinarId)); 
						}
					}	
				}else{
					Session::put('mycpa_message_error', 'Your enter amount does not match with webinar fee, please try again.');
					return Redirect('comingsoon-course-register-payment/'.encrypt($webinarId)); 
				}
			}else{
				Session::put('mycpa_message_error', 'Please select valid webinar for payment, please try again.');
				return Redirect('comingsoon-course-register-payment/'.encrypt($webinarId)); 
			}
		}else{
			Session::put('mycpa_message_error', 'Something went wrong on select webinar, please try again.');
			return redirect()->back();
		}
	}
	
	
	/**
	* Create new attendees for webinar.
	 * @param $id //webinar_id
     * @return value
     * @throws NotFoundException
     */
	 public function CreateAttendees($id, $state, $request) {
		//$id = decrypt($id); 
		//$code = $request->input('code');
		//state = $request->input('state');		
		if(!empty($id) && !empty($state)){
			//for getting token
			// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, 'https://api.getgo.com/oauth/access_token');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=password&user_id=".env('GOTO_DIRECT_USER')."&password=".env('GOTO_DIRECT_PASSWORD')."&client_id=".env("GOTO_CONSUMER_KEY"));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			$headers[] = 'Content-Type: application/x-www-form-urlencoded';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
				if (curl_errno($ch)) {
					$request->session()->flash('error', __(curl_error($ch)));
					return redirect()->route('course',$request->getQueryString());
				} else {
					//curl_close ($ch);
					$decodeData = json_decode($result);
					//dd($decodeData);
					if(!empty($decodeData) && !empty($decodeData->access_token) && !empty($decodeData->organizer_key)){
						 $accessToken = $decodeData->access_token;
						 $organizerKey = $decodeData->organizer_key;
						
						//get webinar Detail
						$userId = Session::get('mycpa_client_id');
						$webinarData = Webinar::select('id','title','start_time','end_time','webinar_key','created_by')->where('id','=',$id)->where('status','=','active')->first();
						if(!empty($webinarData) && !empty($userId)){
							//get login user data
							$userData = Users::Select('users.id','users.first_name','users.last_name','users.email','users.contact_no','users.firm_name','users.zipcode','countries.name as CountryName','states.name as StateName','cities.name as CityName')
												->leftJoin('countries','countries.id','=','users.country_id')
												->leftJoin('states','states.id','=','users.state_id')
												->leftJoin('cities','cities.id','=','users.city_id')
												->where('users.id', '=', $userId)
												->first();
							if(!empty($userData)){					
								//create attenddes
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/G2W/rest/v2/organizers/".$organizerKey."/webinars/".$webinarData->webinar_key."/registrants?resendConfirmation=false");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"firstName\": \"".$userData->first_name."\",\n  \"lastName\": \"".$userData->last_name."\",\n  \"email\": \"".$userData->email."\",\n  \"source\": \"string\",\n  \"address\": \"\",\n  \"city\": \"".$userData->CityName."\",\n  \"state\": \"".$userData->StateName."\",\n  \"zipCode\": \"".$userData->zipcode."\",\n  \"country\": \"".$userData->CountryName."\",\n  \"phone\": \"".$userData->contact_no."\",\n  \"organization\": \"CPA\",\n  \"jobTitle\": \"".preg_replace('/[^A-Za-z0-9\-]/', '', $webinarData->title)."\",\n  \"questionsAndComments\": \"none\",\n  \"industry\": \"IT\",\n  \"numberOfEmployees\": \"string\",\n  \"purchasingTimeFrame\": \"string\",\n  \"purchasingRole\": \"string\",\n  \"responses\": [\n    {\n      \"questionKey\": 0,\n      \"responseText\": \"string\",\n      \"answerKey\": 0\n    }\n  ]\n}");
								curl_setopt($ch, CURLOPT_POST, 1);
								
								$headers = array();
								$headers[] = "Content-Type: application/json";
								$headers[] = "Accept: application/json";
								$headers[] = "Authorization: ".$accessToken;
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								
								$result = curl_exec($ch);
								if (curl_errno($ch)) {
									Session::put('mycpa_message_error', 'Thare was a some error come at register time, Error:'.curl_error($ch));
									return redirect()->route('comingsoon-course',$request->getQueryString());
								}else{
									$decodeAttendees = json_decode($result);
									//dd($decodeAttendees);
									if(isset($decodeAttendees->errorCode)){
										Session::put('mycpa_message_error', 'Thare was a some issue in attenddes register, Error #: '.$decodeAttendees->errorCode.' and Description #'.$decodeAttendees->description);
										return redirect()->route('comingsoon-course',$request->getQueryString());
									}else{
										$updateAttenddes = ['join_url'=>$decodeAttendees->joinUrl,
															'registrant_key'=>$decodeAttendees->registrantKey,
															'registration_status'=>$decodeAttendees->status,
															'status'=>'active',
															'updated_at'=>Carbon::now()];
										$updateAttenddes = WebinarUserRegister::where('user_id',Session::get('mycpa_client_id'))->where('webinar_id',$id)->update($updateAttenddes);
										return true;
									}
								}
								curl_close ($ch);
							}else{
								Session::put('mycpa_message_warning', 'Sorry we cant find this user detail, please login and try again.');
								return redirect()->route('comingsoon-course',$request->getQueryString());
							}
						}else{
							Session::put('mycpa_message_warning', 'Sorry we cant find this webinar, please try again.');
							return redirect()->route('comingsoon-course',$request->getQueryString());
						}
					}else{
						Session::put('mycpa_message_error', 'There was a some issue in getting token from webinar. Please try again.');
						return redirect()->route('comingsoon-course',$request->getQueryString());
					}
				}
		}else{
			Session::put('mycpa_message_error', 'There was a some issue in getting code from webinar. Please try again.');
			return redirect()->route('comingsoon-course',$request->getQueryString());
		}	
	}
}
