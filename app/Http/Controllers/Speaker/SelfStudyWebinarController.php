<?php
namespace App\Http\Controllers\Speaker;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\Courses;
use App\Repositories\Administrators;
use App\Repositories\Notifications;
use App\Repositories\CourseLevel;
use App\Repositories\WebinarQuestions;
use App\Repositories\Tag;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use Redirect;
use getID3;

class SelfStudyWebinarController extends Controller{

    /**
     * Speaker Controller listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $webinars = Webinar::select('id','title', 'fee','webinar_type','presentation_length','recorded_date','start_time', 'end_time', 'created_at', 'status', 'time_zone');
        
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $webinars = $webinars->where('webinars.status', '=', $status);
        }else{
            $webinars = $webinars->where('webinars.status', '!=', 'delete');
        }
        
        // For date filter          
        $recorded_date = $request->input('recorded_date');
        if ($recorded_date != '') {
            $webinars = $webinars->where('recorded_date', '>=', $recorded_date);
        }

        $webinars = $webinars->where('webinars.webinar_type', '=', 'self_study'); //webinar type selt study

        // For text input filter
        if ($request->input('title') != '') {
            $searchStr =  $request->input('title');
            $searchStr = '%' . $searchStr . '%';
            $webinars = $webinars->where('title', 'LIKE', $searchStr);
        }
        
        $webinars = $webinars->where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->orderby('id', 'desc')->paginate(env('PAGINATION'));
        $webinars = $webinars->appends(request()->query());
        //echo "<pre>"; print_r($webinars); exit;
        
        $statusList = StatusHelper::getStatusesList();
        
        if ($request->ajax()) {
            return Response::json(View('speaker/self_study_webinars/index-ajax', compact('webinars','statusList'))->render());
        }
        
        return view('speaker.self_study_webinars.index', compact('webinars','statusList'));
    }
    
    
    /**
     * Get create webinar view
     *
     * @param $request
     * 
     * @return view
     */
    public function create() {
        $courseLevel = CourseLevel::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
        $subjectAria = Courses::select('id', 'name','course_level_id')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
        $tags = Tag::select('id', 'tag')
                            ->where('status','=','active')
                            ->orderBy('tag', 'ASC')
                            ->get();
        $userType = UserType::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();                    
        $statusList = StatusHelper::getStatusesList();                                      
        return view('speaker/self_study_webinars/add',compact('courseLevel','subjectAria','statusList','tags','userType'));
    }
     /**
     * Get create webinar store
     *
     * @param $request
     * 
     * @return view
     */

    public function store(Request $request) {
        try {
            $title = $request->input('title');
            $documents = $request->file('documents');
			$image = $request->file('image');
            $description = $request->input('description');
            $fee = $request->input('fee');
            $cpa_credit = $request->input('cpa_credit');
            $webinar_transcription = $request->input('webinar_transcription');
            $time_zone = $request->input('time_zone');
            $recorded_date = $request->input('recorded_date');
            //$start_time = $request->input('start_time');
            //$end_time = $request->input('end_time');
            $subject_area = $request->input('subject_area');
            $course_level = $request->input('course_level');
            $pre_requirement = $request->input('pre_requirement');
            $advance_preparation = $request->input('advance_preparation');
            $who_should_attend = $request->input('who_should_attend');
            $presentation_length =  $request->input('presentation_length');
			$learning_objectives = $request->input('learning_objectives');
			$Instructional_method = $request->input('Instructional_method');
            $tag = $request->input('tag');
            $faq_1 = $request->input('faq_1');
            $faq_2 = $request->input('faq_2');
            $faq_3 = $request->input('faq_3');
            $faq_4 = $request->input('faq_4');
            $faq_5 = $request->input('faq_5');
            $created_at = Carbon::now();
            $draft = $request->input('draft'); 
			           
            $subject_area_id = '';
            if(!empty($subject_area)){
                $subject_area_id = implode(',',$subject_area);
            }
            
            $course_level_id = '';
            if(!empty($course_level)){
                $course_level_id = implode(',',$course_level);
            }
            
            $tag_id = '';
            if(!empty($tag)){
                $tag_id = implode(',',$tag);
            }
            
            $who_should_attend_id = '';
            if(!empty($who_should_attend)){
                $who_should_attend_id = implode(',',$who_should_attend);
            }

         	$destinationWebinarPath = "uploads/webinar_image/";
			if (!file_exists($destinationWebinarPath)) {
				mkdir($destinationWebinarPath, 0777, true);
			}
            
            //Store webinar documents
            $destinationPath = "uploads/webinar_doc/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $documentsURL = '';
            if($documents != ''){
                $documentsSize = $documents->getSize();
                $documentsName = str_replace(' ','-',time().$documents->getClientOriginalName());
                $documentsExt = strtolower($documents->getClientOriginalExtension());
                $documentsAllowedExt = 'xyz,jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls, xlsx,ppt,pptx';
                if($documentsSize < 81920099999999){ //800kb
                    if(strpos($documentsAllowedExt,$documentsExt) == true){
                        $documents->move($destinationPath,$documentsName);
                        $documentsURL = $documentsName;
                    }else{
                        $request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docx, xls, xlsx, ppt, pptx.'));
                        return redirect()->back();
                        $documentsURL = '';
                    }
                }else{
                    $request->session()->flash('error', __('uploded file size should be less than 800kb.'));
                    return redirect()->back();
                }
            }
			
			$imageURL = '';
			if($image != ''){
				$imageSize = $image->getSize();
				$imageName = str_replace(' ','-',time().$image->getClientOriginalName());
				$imageExt = strtolower($image->getClientOriginalExtension());
				$imageAllowedExt = 'xyz,jpg,png,gif,jpeg';
				if($imageSize < 81920099999999){ //800kb
					if(strpos($imageAllowedExt,$imageExt) == true){
						$image->move($destinationWebinarPath,$imageName);
						$imageURL = $imageName;
					}else{
						$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, jpeg.'));
						return redirect()->back();
						$imageURL = '';
					}
				}else{
					$request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
					return redirect()->back();
				}
			}
			
			
          if($draft==1){
			  
			   $addArray = ['title'=>$title,
                        'webinar_type'=>'self_study',
                        'description'=>$description,
                        'webinar_transcription'=>$webinar_transcription,
                        'fee'=>$fee,
                         'cpa_credit'=>$cpa_credit,
                        'presentation_length' =>$presentation_length,
                       //'start_time'=>$start_time,
                       //'end_time'=>$end_time,
                        'subject_area'=>$subject_area_id,
                        'course_level'=>$course_level_id,
                        'pre_requirement'=>$pre_requirement,
                        'advance_preparation'=>$advance_preparation,
                        'who_should_attend'=>$who_should_attend_id,
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
                        'documents'=>$documentsURL,
						'image'=>$imageURL,
                        'tag'=>$tag_id,
                        'faq_1'=>$faq_1,
                        'faq_2'=>$faq_2,
                        'faq_3'=>$faq_3,
                        'faq_4'=>$faq_4,
                        'faq_5'=>$faq_5,
                        'status'=>'draft',
                        'added_by'=>'speaker',
                        'created_at'=>$created_at,
                        'created_by'=>Auth::guard('speaker')->user()->id,
                        ];
            $createdData = Webinar::create($addArray);
            
            if($createdData){
            $request->session()->flash('success', __('Webinar has been added successfully.'));
             
             return redirect('selfstudy-webinars/');

             //Route::get('/selfystudy-webinars/edit/{id}/documents
                
             //   return redirect()->route('speaker.self_study_webinars');
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
		  }else{
            
            $addArray = ['title'=>$title,
                        'webinar_type'=>'self_study',
                        'description'=>$description,
                        'webinar_transcription'=>$webinar_transcription,
                        'fee'=>$fee,
                        'cpa_credit'=>$cpa_credit,
                        'time_zone'=>$time_zone,
                        'recorded_date'=>$recorded_date,
                        'presentation_length' =>$presentation_length,
                       //'start_time'=>$start_time,
                       //'end_time'=>$end_time,
                        'subject_area'=>$subject_area_id,
                        'course_level'=>$course_level_id,
                        'pre_requirement'=>$pre_requirement,
                        'advance_preparation'=>$advance_preparation,
                        'who_should_attend'=>$who_should_attend_id,
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
                        'documents'=>$documentsURL,
						'image'=>$imageURL,
                        'tag'=>$tag_id,
                        'faq_1'=>$faq_1,
                        'faq_2'=>$faq_2,
                        'faq_3'=>$faq_3,
                        'faq_4'=>$faq_4,
                        'faq_5'=>$faq_5,
                        'status'=>'draft',
                        'added_by'=>'speaker',
                        'created_at'=>$created_at,
                        'created_by'=>Auth::guard('speaker')->user()->id,
                        ];
            $createdData = Webinar::create($addArray);
            
            if($createdData){
            	//$request->session()->flash('success', __('Webinar has been added successfully.'));
             	//return redirect('selfstudy-webinars/'.encrypt($createdData->id).'/video');
				return redirect('selfstudy-webinars/'.encrypt($createdData->id).'/add-webinar-question');
             	//Route::get('/selfystudy-webinars/edit/{id}/documents
             	//return redirect()->route('speaker.self_study_webinars');
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
		  }
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
        }
    }
	
	
	
	
	/**
     * Get create webinar store
     *
     * @param $request
     * 
     * @return view
     */

    public function addQuestion($webinar_id, Request $request) {
		//echo $webinar_id; exit;
		$webinar_id = decrypt($webinar_id);
		if(!empty($webinar_id) && is_numeric($webinar_id)){
			$WebinarQuestionsReview = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
												->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
												->where('webinar_questions.webinar_id',$webinar_id)
												->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
												->where('webinar_questions.status','!=','delete')
												->where('webinar_questions.type','=','review')
												->orderby('id', 'desc')
												->get();
			$WebinarQuestionsFinal = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
												->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
												->where('webinar_questions.webinar_id',$webinar_id)
												->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
												->where('webinar_questions.status','!=','delete')
												->where('webinar_questions.type','=','final')
												->orderby('id', 'desc')
												->get();	
												
			$webinarDetail = Webinar::select('id','title')->where('id',$webinar_id)->first();
			
			$statusList = StatusHelper::getStatusesList();
			
			//check review question
			$review = false;
			$final = false;
			if(count($WebinarQuestionsReview) > 0){
				$review = true;
			}
			if(count($WebinarQuestionsFinal) > 0){
				$final = true;
			}
			
			return view('speaker.self_study_webinars/add-question', compact('WebinarQuestionsReview','WebinarQuestionsFinal','webinarDetail','statusList','review','final'));
		}else{
			$request->session()->flash('error', __('Webinar question could not be saved. Please, try again.'));
			return redirect('selfstudy-webinars');	
		}
	}
	
	
	
	/**
     * add question for new created webinar
     *
     * @param $request
     * 
     * @return view
     */

    public function storeQuestion(Request $request) {
		//dd($request->all());
		try {
			$webinar_id = decrypt($request->input('webinar_id'));
			$type = $request->input('type');
			$time = $request->input('time');
			$question = $request->input('question');
			$option_a = $request->input('option_a');
			$option_b = $request->input('option_b');
			$option_c = $request->input('option_c');
			$option_d = $request->input('option_d');
			$answer = $request->input('answer');
			$currect_answer_note_a = $request->input('currect_answer_note_a');
			$wrong_answer_note_a = $request->input('wrong_answer_note_a');
			$currect_answer_note_b = $request->input('currect_answer_note_b');
			$wrong_answer_note_b = $request->input('wrong_answer_note_b');
			$currect_answer_note_c = $request->input('currect_answer_note_c');
			$wrong_answer_note_c = $request->input('wrong_answer_note_c');
			$currect_answer_note_d = $request->input('currect_answer_note_d');
			$wrong_answer_note_d = $request->input('wrong_answer_note_d');
			$status = 'active';
			$added_by = Auth::guard('speaker')->user()->id;
			$created_at = Carbon::now();
			
			$addArray = ['webinar_id'=>$webinar_id,
						'type'=>$type,
						'time'=>$time,
						'question'=>$question,
						'option_a'=>$option_a,
						'option_b'=>$option_b,
						'option_c'=>$option_c,
						'option_d'=>$option_d,
						'answer'=>$answer,
						'currect_answer_note_a'=>$currect_answer_note_a,
						'wrong_answer_note_a'=>$wrong_answer_note_a,
						'currect_answer_note_b'=>$currect_answer_note_b,
						'wrong_answer_note_b'=>$wrong_answer_note_b,
						'currect_answer_note_c'=>$currect_answer_note_c,
						'wrong_answer_note_c'=>$wrong_answer_note_c,
						'currect_answer_note_d'=>$currect_answer_note_d,
						'wrong_answer_note_d'=>$wrong_answer_note_d,
						'status'=>$status,
						'created_at'=>$created_at,
						'added_by'=>$added_by
						];
			$createdData = WebinarQuestions::create($addArray);
			
			if($createdData){
				$SelfStudyWebinarsData = Webinar::select('webinars.status','webinars.video')
                                             ->where('webinars.id','=', $webinar_id)
                                             ->first();
				//notification start /////
				if($SelfStudyWebinarsData->status == 'draft' && $type == 'final') {
					$first_name = Auth::guard('speaker')->user()->first_name;
					$last_name =  Auth::guard('speaker')->user()->last_name;
					
					$admin_user = Administrators::get();
					foreach($admin_user as $usr){
                        $user_id =  $usr['id'];
                        $link = 'selfstudy-webinar';
                        $notification_text = $first_name.' '. $last_name. ' has uploaded an Self Study Webinar. Please review it.'; 
                        $data[]  = array('notification_text'=>$notification_text,'is_admin'=> '1','user_id' => $user_id,'created_at'=>Carbon::now(),'link'=>$link);
                	}
						
					Notifications::insert($data);
				}
				//notification end /////
				// status change							 
				if($SelfStudyWebinarsData->status == 'draft' && $SelfStudyWebinarsData->video !='' && $type == 'final') {	
					$addstatusArray = ['status'=>'inactive'];
					$updateData = Webinar::where('id',$webinar_id)->where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->update($addstatusArray); 
				}

				$request->session()->flash('success', __('Webinar Questions added successfully.'));
			 	return redirect('selfstudy-webinars/'.encrypt($webinar_id).'/add-webinar-question?'.$request->input('uri'));
			}
			$request->session()->flash('error', __('Webinar Questions could not be saved. Please, try again.'));
			return redirect()->back();
		} catch (Exception $exc) {
			$request->session()->flash('error', __('Webinar Questions could not be saved. Please, try again.'));
		}	
	}
	
	
	
	
	/**
     * Get Webinar Question edit view
     *
     * @param $id
     * 
     * @return view
     */
    public function editQuestion($qus_id) {
		$id = decrypt($qus_id);
		if(!empty($id) && is_numeric($id)){
			$WebinarQuestionsEdit = WebinarQuestions::select('id','webinar_id', 'type','time','question','option_a','option_b', 'option_c', 'option_d','answer', 'currect_answer_note_a', 'wrong_answer_note_a', 'currect_answer_note_b', 'wrong_answer_note_b', 'currect_answer_note_c', 'wrong_answer_note_c', 'currect_answer_note_d', 'wrong_answer_note_d', 'status','created_at','updated_at','added_by','updated_by')
													->where('id','=',$id)
													->where('added_by','=',Auth::guard('speaker')->user()->id)
													->first();
			//dd($WebinarQuestionsEdit);
			if(!empty($WebinarQuestionsEdit)){
				$webinars = Webinar::select('id','title')
							->where('id','=',$WebinarQuestionsEdit->webinar_id)
							->first();
				//dd($webinars);             
				$statusList = StatusHelper::getStatusesList(); 
				
				$WebinarQuestionsReview = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
													->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
													->where('webinar_questions.webinar_id',$WebinarQuestionsEdit->webinar_id)
													->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
													->where('webinar_questions.status','!=','delete')
													->orderby('id', 'desc')
													->get();
													
				$WebinarQuestionsFinal = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
													->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
													->where('webinar_questions.webinar_id',$WebinarQuestionsEdit->webinar_id)
													->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
													->where('webinar_questions.status','!=','delete')
													->orderby('id', 'desc')
													->get();

				return view('speaker.self_study_webinars/edit-question', compact('WebinarQuestionsEdit','webinars','statusList','WebinarQuestionsReview','WebinarQuestionsFinal'));	
			}else{
				$request->session()->flash('error', __('Webinar Questions can not be updated. Please try again.'));
				return redirect()->route('speaker.self_study_webinars').$request->input('uri');	
			}
		}else{
			$request->session()->flash('error', __('Please enter valid data for webinar. Please try again.'));
			return redirect()->route('speaker.self_study_webinars').$request->input('uri');		
		}
	} 
	
	
	
	/**
     * update Webinar Question
     *
     * @param $request
     * 
     * @return view
     */
    public function updateQuestion(Request $request) { 
		//dd($request->all());
    	try {
			$id = decrypt($request->input('id'));
			$webinar_id = decrypt($request->input('webinar_id'));
			
			if(!empty($id) && !empty($webinar_id) && is_numeric($id) && is_numeric($webinar_id)){
				$type = $request->input('type');
				$time = $request->input('time');
				$question = $request->input('question');
				$option_a = $request->input('option_a');
				$option_b = $request->input('option_b');
				$option_c = $request->input('option_c');
				$option_d = $request->input('option_d');
				$answer = $request->input('answer');
				$currect_answer_note_a = $request->input('currect_answer_note_a');
				$wrong_answer_note_a = $request->input('wrong_answer_note_a');
				$currect_answer_note_b = $request->input('currect_answer_note_b');
				$wrong_answer_note_b = $request->input('wrong_answer_note_b');
				$currect_answer_note_c = $request->input('currect_answer_note_c');
				$wrong_answer_note_c = $request->input('wrong_answer_note_c');
				$currect_answer_note_d = $request->input('currect_answer_note_d');
				$wrong_answer_note_d = $request->input('wrong_answer_note_d');
				$updated_by = Auth::guard('speaker')->user()->id;
				$updated_at = Carbon::now();
				
				$editArray = ['webinar_id'=>$webinar_id,
							  'type'=>$type,
							  'time'=>$time,
							  'question'=>$question,
							  'option_a'=>$option_a,
							  'option_b'=>$option_b,
							  'option_c'=>$option_c,
							  'option_d'=>$option_d,
							  'answer'=>$answer,
							  'currect_answer_note_a'=>$currect_answer_note_a,
							  'wrong_answer_note_a'=>$wrong_answer_note_a,
							  'currect_answer_note_b'=>$currect_answer_note_b,
							  'wrong_answer_note_b'=>$wrong_answer_note_b,
							  'currect_answer_note_c'=>$currect_answer_note_c,
							  'wrong_answer_note_c'=>$wrong_answer_note_c,
							  'currect_answer_note_d'=>$currect_answer_note_d,
							  'wrong_answer_note_d'=>$wrong_answer_note_d,
							  'updated_at'=>$updated_at,
							  'updated_by'=>$updated_by
							];
				$updateData = WebinarQuestions::where('id',$id)->update($editArray);
				if($updateData){
					$request->session()->flash('success', __('Webinar Question has been updated successfully.'));
					return redirect('selfstudy-webinars/'.encrypt($webinar_id).'/add-webinar-question?'.$request->input('uri'));
				}
				$request->session()->flash('error', __('Webinar Question could not be saved. Please, try again.'));
			}else{
				$request->session()->flash('error', __('Please enter valid data for webinar. Please try again.'));
				return redirect()->route('speaker.self_study_webinars').$request->input('uri');	
			}
		} catch (Exception $exc) {
			$request->session()->flash('error', __('Webinar Question could not be saved. Please, try again.'));
		}
   }
	
	
	  
	
	
	
	 /**
     * Delete Webinar Question  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroyQuestion($qus_id,Request $request){
		$id = decrypt($qus_id);
		try {
			if(is_numeric($id) && !empty($id)){
				//check question id for webinar
				$webinarQuestion = WebinarQuestions::select('id','webinar_id')
													->where('id','=',$id)
													->where('added_by','=',Auth::guard('speaker')->user()->id)
													->first();
				if(!empty($webinarQuestion)){			
					$deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'updated_by' => Auth::guard('speaker')->user()->id];
					$delete = WebinarQuestions::where('id', '=', $id)->update($deleteArray);
					if($delete){
						$request->session()->flash('success', __('Webinar Questions has been deleted successfully.'));
					} else {
						$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
					}
					return redirect('/selfstudy-webinars/'.encrypt($webinarQuestion->webinar_id).'/add-webinar-question');
				}else{
					$request->session()->flash('error', __('Please Select valid Webinar Questions for delete. Please try again.'));
					return redirect()->route('speaker.self_study_webinars').$request->input('uri');		
				}
			}else{
				$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
				return redirect()->route('speaker.self_study_webinars').$request->input('uri');	
			}   
		} catch (Exception $ex) {
			$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
		}
    }
	
	
	
	
	
     
    
    /**
     * Get webinar information edit view
     *
     * @param $id
     * 
     * @return view
     */
    public function edit($id) {
        $id = decrypt($id);
        try{
            if(is_numeric($id) && !empty($id)){
                $statusList = StatusHelper::getStatusesList();
                
                $courseLevel = CourseLevel::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
                $subjectAria = Courses::select('id', 'name','course_level_id')
                                    ->where('status','=','active')
                                    ->orderBy('name', 'ASC')
                                    ->get();
                $tags = Tag::select('id', 'tag')
                                    ->where('status','=','active')
                                    ->orderBy('tag', 'ASC')
                                    ->get();
                $userType = UserType::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
                                    
                $webinar = Webinar::where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->findOrFail($id);
                
                //Explode subject_area
                if(!empty($webinar->subject_area)){
                    $subject_area_id = explode(',',$webinar->subject_area);
                }else{ 
                    $subject_area_id = []; 
                }
                
                //Explode course_level
                if(!empty($webinar->course_level)){
                    $course_level_id = explode(',',$webinar->course_level);
                }else{ 
                    $course_level_id = []; 
                }
                
                //Explode tag
                if(!empty($webinar->tag)){
                    $tag_id = explode(',',$webinar->tag);
                }else{ 
                    $tag_id = []; 
                }

                if(!empty($webinar->who_should_attend)){
                    $who_should_attend_array = explode(',',$webinar->who_should_attend);
                }else{ 
                    $who_should_attend_array = []; 
                }
    
                if ($webinar) {
                    return view('speaker.self_study_webinars.edit', compact('webinar', 'statusList','subject_area_id','course_level_id','tag_id', 'courseLevel', 'subjectAria', 'tags','userType','who_should_attend_array'));
                }else{
                    $request->session()->flash('error', __('Seltstudy Webinar not available. Please, try again.'));
                    return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
                }
            }else{
                $request->session()->flash('error', __('Webinar could not be load. Please, try again.'));
                return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
            }
        } catch (Exception $ex) {
            abort(404);
        }   
    }
    
    
     /**
     * update webinar data
     *
     * @param $request
     * 
     * @return view
     */
    public function update(Request $request){
		try {
            $id = $request->input('id');
            $title = $request->input('title');
            $documents = $request->file('documents');
            $video = $request->file('video');
			$image = $request->file('image');
            $description = $request->input('description');
            $fee = $request->input('fee');
            $cpa_credit = $request->input('cpa_credit');
            $presentation_length = $request->input('presentation_length');
            $webinar_transcription = $request->input('webinar_transcription');
			
			if($request->input('time_zone') == ''){
				$webinar_time = Webinar::select('time_zone')->where('id', '=', $id)->first();
				$time_zone = $webinar_time->time_zone;
			}else {
				$time_zone = $request->input('time_zone');
			}
			
            $recorded_date = $request->input('recorded_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $subject_area = $request->input('subject_area');
            $course_level = $request->input('course_level');
            $pre_requirement = $request->input('pre_requirement');
            $advance_preparation = $request->input('advance_preparation');
            $who_should_attend = $request->input('who_should_attend');
			$learning_objectives = $request->input('learning_objectives');
			$Instructional_method = $request->input('Instructional_method');
            $tag = $request->input('tag');
            $faq_1 = $request->input('faq_1');
            $faq_2 = $request->input('faq_2');
            $faq_3 = $request->input('faq_3');
            $faq_4 = $request->input('faq_4');
            $faq_5 = $request->input('faq_5');
            $updated_at = Carbon::now();
			$current_status = $request->input('current_status');
            
            $subject_area_id = '';
            if(!empty($subject_area)){
                $subject_area_id = implode(',',$subject_area);
            }
            
            $course_level_id = '';
            if(!empty($course_level)){
                $course_level_id = implode(',',$course_level);
            }
            
            $tag_id = '';
            if(!empty($tag)){
                $tag_id = implode(',',$tag);
            }
            
            $who_should_attend_id = '';
            if(!empty($who_should_attend)){
                $who_should_attend_id = implode(',',$who_should_attend);
            }
            
            //Store webinar documents
            $destinationPath = "uploads/webinar_doc/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
			
			$destinationWebinarPath = "uploads/webinar_image/";
			if (!file_exists($destinationWebinarPath)) {
				mkdir($destinationWebinarPath, 0777, true);
			}
            
            $webinarDoc = Webinar::select('id','documents','image','video')->where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('id','=',$id)->first();
            
			if(empty($webinarDoc->video)){
				$request->session()->flash('error', __('First you have to upload video for this webinar.'));
				return redirect()->back();	
			}
			
			if($image != ''){
				if(!empty($webinarDoc)){
					$imageSize = $image->getSize();
					$imageName = str_replace(' ','-',time().$image->getClientOriginalName());
					$imageExt = strtolower($image->getClientOriginalExtension());
					$imageAllowedExt = 'xyz,jpg,png,gif,jpeg';
					if($imageSize < 81920099999999) { //800kb
						if(strpos($imageAllowedExt,$imageExt) == true){
							//Delete old documents and store new documents
							$DeleteUrl = public_path('uploads/webinar_image/'.$webinarDoc->image);
							File::delete($DeleteUrl);
							//Store new file in syatem
							$image->move($destinationWebinarPath,$imageName);
							$imageURL = $imageName;
						}else{
							$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, jpeg.'));
							return redirect()->back();
							$imageURL = $webinarDoc->image;
						}
					}else{
						$request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
						return redirect()->back();
						$imageURL = $webinarDoc->image;	
					}
				}	
			}else{
				$imageURL = $webinarDoc->image;
			}
			
            if($documents != ''){
                if(!empty($webinarDoc)){
                    $documentsSize = $documents->getSize();
                    $documentsName = str_replace(' ','-',time().$documents->getClientOriginalName());
                    $documentsExt = strtolower($documents->getClientOriginalExtension());
                    $documentsAllowedExt = 'xyz,jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls, xlsx,ppt,pptx';
                    if($documentsSize < 81920099999999) { //800kb
                        if(strpos($documentsAllowedExt,$documentsExt) == true){
                            //Delete old documents and store new documents
                            $DeleteUrl = public_path('uploads/webinar_doc/'.$webinarDoc->documents);
                            File::delete($DeleteUrl);
                            //Store new file in syatem
                            $documents->move($destinationPath,$documentsName);
                            $documentsURL = $documentsName;
                        }else{
                            $request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docx, xls, xlsx, ppt, pptx..'));
                            return redirect()->back();
                            $documentsURL = $webinarDoc->documents;
                        }
                    }else{
                        $request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
                        return redirect()->back();
                        $documentsURL = $webinarDoc->documents; 
                    }
                }   
            }else{
                $documentsURL = $webinarDoc->documents;
            }

            $destinationVideoPath = "uploads/webinar_video/";
            if (!file_exists($destinationVideoPath)) {
                mkdir($destinationVideoPath, 0777, true);
            }

            $videoDoc = Webinar::select('id','video','duration')->where('id','=',$id)->first();
             if($video != ''){
                if(!empty($videoDoc)){
                    //get new uplaoded video duration 
                    $getID3 = new getID3;
                    $file = $getID3->analyze($video);
                    $duration = $file['playtime_string'];
                    
                    /*echo("Duration: ".$file['playtime_string'].
                    " / Dimensions: ".$file['video']['resolution_x']." wide by ".$file['video']['resolution_y']." tall".
                    " / Filesize: ".$file['filesize']." bytes<br />");
                    exit;*/
                    $videoSize = $video->getSize();
                    $videoName = str_replace(' ','-',time().$video->getClientOriginalName());
                    $videoExt = strtolower($video->getClientOriginalExtension());
                    $videoAllowedExt = 'xyz,mp4,3gp,webm,wmv,flv,xyzx';
                    if($videoSize < 81920000000){ //80GB
                        if(strpos($videoAllowedExt,$videoExt) == true){
                            //Delete old documents and store new documents
                            $DeleteUrl = public_path('uploads/webinar_video/'.$videoDoc->video);
                            File::delete($DeleteUrl);
                            //Store new file in syatem
                            $video->move($destinationVideoPath,$videoName);
                            $videoURL = $videoName;
                        }else{
                            $request->session()->flash('error', __('Please upload valid file. Format should be: mp4,3gp,webm,wmv,flv.'));
                            $videoURL = $videoDoc->video;
                            $duration = $videoDoc->duration;
                        }
                    }else{
                        $request->session()->flash('error', __('Uploded file size should be less than 8GB.'));
                        $videoURL = $videoDoc->video; 
                        $duration = $videoDoc->duration;
                    }
                }   
            }else{
                $videoURL = $videoDoc->video;
                $duration = $videoDoc->duration;
            }
            
            
            
            $editArray = ['title'=>$title,
                        'webinar_type'=>'self_study',
                        'description'=>$description,
                        'webinar_transcription'=>$webinar_transcription,
                        'fee'=>$fee,
                        'cpa_credit'=>$cpa_credit,
                        'presentation_length'=>$presentation_length,
                        'time_zone'=>$time_zone,
                        'recorded_date'=>$recorded_date,
                       // 'start_time'=>$start_time,
                       // 'end_time'=>$end_time,
                        'subject_area'=>$subject_area_id,
                        'course_level'=>$course_level_id,
                        'pre_requirement'=>$pre_requirement,
                        'advance_preparation'=>$advance_preparation,
                        'who_should_attend'=>$who_should_attend_id,
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
                        'documents'=>$documentsURL,
                        'video'=>$videoURL,
						'image' => $imageURL,
                        'duration'=>$duration,
                        'tag'=>$tag_id,
                        'faq_1'=>$faq_1,
                        'faq_2'=>$faq_2,
                        'faq_3'=>$faq_3,
                        'faq_4'=>$faq_4,
                        'faq_5'=>$faq_5,
                        'updated_at'=>$updated_at,
                        'modified_by' => Auth::guard('speaker')->user()->id,
                        ];
            $updateData = Webinar::where('id',$id)->update($editArray);
            if($updateData){
                $request->session()->flash('success', __('Self Study Webinar has been update successfully.'));
                //return Response::json(['success' => true], 200);
                //return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
				return redirect('/selfstudy-webinars/'.encrypt($id).'/add-webinar-question?edit=yes');
            }
            return Response::json(['error' => true], 300);
            $request->session()->flash('error', __('Seltstudy Webinar could not be saved. Please, try again.'));
			return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('SeltstudyWebinar could not be saved. Please, try again.'));
        }
    }
    
    
    /**
     * list video for self study video
     *
     * @param $request
     * 
     * @return view
     */
    public function video($id) {
        $id = decrypt($id);
        return view('speaker/self_study_webinars/video',compact('id'));
    }
    
    
    /**
     * store selft study video for webinar
     *
     * @param $request
     * 
     * @return view
     */
    public function store_video(Request $request) {
		//dd($request->input('webinar_id'));
        try {
        	$video = $request->file('video');
            $webinar_id  = $request->input('webinar_id');
			$actionType  = $request->input('actionType');
            
            //Store webinar documents
            $destinationPath = "uploads/webinar_video/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
			
            $videoURL = '';
           	if($video){
            	$videoSize = $video->getSize();
                $videoName = str_replace(' ','-',time().$video->getClientOriginalName());
                $videoExt = strtolower($video->getClientOriginalExtension());
                $videoAllowedExt = 'xyz,mp4,3gp,webm,wmv,flv,xyzx';
				if($videoSize < 81920000000){ //80GB
					if(strpos($videoAllowedExt,$videoExt) == true){
						$video->move($destinationPath,$videoName);
						$videoURL = $videoName;
					}else{
						$request->session()->flash('error', __('Please upload valid file. Format should be: mp4,3gp,webm,wmv,flv.'));
						$videoURL = '';
						return Response::json(['error' => true], 300);
						//return Redirect::back();
					}
				}else{
					$request->session()->flash('error', __('Video size should be less than 8GB.'));
					return Response::json(['error' => true], 300);
				}
            }
			// get webinar current status
			$SelfStudyWebinarsData = Webinar::select('webinars.status','webinars.video')
                                             ->where('webinars.id','=', $webinar_id)
                                             ->first();
			// get webinar final question count								 
			$WebinarQuestionsFinal = WebinarQuestions::select('webinar_questions.id')
												->where('webinar_questions.webinar_id',$webinar_id)
												->where('webinar_questions.status','!=','delete')
												->where('webinar_questions.type','=','final')
												->count();								 
			
			// if webinar inactive	means koi edit kartu hoy aemaj to							 
			if($SelfStudyWebinarsData->status != 'draft') {
            	$addVideoArray = ['video'=>$videoURL,'status'=>'inactive'];
			} elseif($SelfStudyWebinarsData->status == 'draft' && $WebinarQuestionsFinal > 0) { // kif anybody adding new webinar
				$addVideoArray = ['video'=>$videoURL,'status'=>'inactive'];
				//notification start /////
                $first_name = Auth::guard('speaker')->user()->first_name;
                $last_name =  Auth::guard('speaker')->user()->last_name;
                
                $admin_user = Administrators::get();
                foreach($admin_user as $usr){
					$user_id =  $usr['id'];
					$link = 'selfstudy-webinar';
					$notification_text = $first_name.' '. $last_name. ' has uploaded an Self Study Webinar. Please review it.'; 
					$data[]  = array('notification_text'=>$notification_text,'is_admin'=> '1','user_id' => $user_id,'created_at'=>Carbon::now(),'link'=>$link);
                }
                
				Notifications::insert($data); 
                //notification end /////
			} else { // if anybody edit draft webinar
				$addVideoArray = ['video'=>$videoURL,'status'=>'draft'];
			}
            $updateData = Webinar::where('id',$webinar_id)->where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->update($addVideoArray);                
            if($updateData){
				
				$request->session()->flash('success', __('Webinar video has been added successfully.'));
            	if(!empty($actionType)){
					return Response::json(['success' => true,'latestVideo'=>$videoName], 200);
				}else{
					return redirect('selfstudy-webinars');
					//Route::get('/selfstudy-webinars/edit/{id}/documents
					//return redirect()->route('speaker.self_study_webinars');
				}
            }
           	$request->session()->flash('error', __('Webinar video could not be saved. Please, try again.'));
		} catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar video could not be saved. Please, try again.'));
        }
    }
    
    
    
    /**
     * Delete webinar  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
        $id = decrypt($id);
        try {
            if(is_numeric($id) && !empty($id)){
                $deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'modified_by' => Auth::guard('speaker')->user()->id];
                
                $delete = Webinar::where('webinar_type','self_study')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('id', '=', $id)->update($deleteArray);
                if($delete){
                    $request->session()->flash('success', __('Self study webinar has been deleted successfully.'));
                } else {
                    $request->session()->flash('error', __('Self study webinar can not be deleted. Please try again.'));
                }
                return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
            }else{
                $request->session()->flash('error', __('Self study webinar can not be deleted. Please try again.'));
                 return redirect()->route('speaker.self_study_webinars',$request->input('uri'));
            }   
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Self study webinar can not be deleted. Please try again.'));
        }
    }

    /**
    * View Self Study Webinars status 
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
     
     public function view(Request $request, $id){
         $id = decrypt($id);
          $SelfStudyWebinarsView = Webinar::select('webinars.id','webinars.cpa_credit','webinars.title', 'webinars.fee','webinars.image','webinars.learning_objectives','webinars.Instructional_method','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone','webinars.reason')
                                             ->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
                                             ->leftJoin('courses','courses.course_level_id','=','course_levels.id')
                                             ->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
                                             ->leftjoin('speakers','speakers.id','=','webinars.created_by') 
                                             ->leftJoin('tags','tags.id','=','webinars.tag')
                                             ->where('webinars.id','=', $id)
                                             ->first();

        $WebinarQuestionsReview = WebinarQuestions::select('type','time','question','option_a','option_b','option_c','option_d','answer','status')
                                             ->where('webinar_id','=', $id)
                                             ->where('status','=', 'active')
                                             ->where('type','=', 'review')
                                             ->get();
        $WebinarQuestionsFinal = WebinarQuestions::select('type','time','question','option_a','option_b','option_c','option_d','answer','status')
                                             ->where('webinar_id','=', $id)
                                             ->where('status','=', 'active')
                                             ->where('type','=', 'final')
                                             ->get();
          //dd($SelfStudyWebinarsView);
           return view('speaker.self_study_webinars.view', compact('SelfStudyWebinarsView','WebinarQuestionsReview','WebinarQuestionsFinal'));
     }
    
    
        
}
