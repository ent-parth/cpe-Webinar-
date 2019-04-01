<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use Auth;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\Series;
use App\Repositories\Courses;
use App\Repositories\CourseLevel;
use App\Repositories\WebinarQuestions;
use App\Repositories\Notifications;
use App\Repositories\Administrators;
use App\Repositories\Tag;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use CommonHelper;
use Redirect;

class SelfStudyWebinarController extends Controller{

    /**
     * Self Study Webinar Controller listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $Self_Study_Webinars = Webinar::select('webinars.id','speakers.first_name','speakers.last_name','webinars.title', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at', 'webinars.status','webinars.series')->leftJoin('speakers','speakers.id','=','webinars.created_by') ;
        
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $Self_Study_Webinars = $Self_Study_Webinars->where('webinars.status', '=', $status);
        }else{
            $Self_Study_Webinars = $Self_Study_Webinars->where('webinars.status', '!=', 'delete')->where('webinars.status', '!=', 'draft');
        }
        
        // For date filter          
        $recorded_date = $request->input('recorded_date');
        if ($recorded_date != '') {
            $Self_Study_Webinars = $Self_Study_Webinars->where('webinars.recorded_date', '>=', $recorded_date);
        }

        $Self_Study_Webinars = $Self_Study_Webinars->where('webinars.webinar_type', '=', 'self_study'); //webinar type selt study

        // For text input filter
        if ($request->input('title') != '') {
            $searchStr =  $request->input('title');
            $searchStr = '%' . $searchStr . '%';
            $Self_Study_Webinars = $Self_Study_Webinars->where('webinars.title', 'LIKE', $searchStr);
        }
        
        $Self_Study_Webinars = $Self_Study_Webinars->orderby('webinars.id', 'desc')->paginate(env('PAGINATION'));
        $Self_Study_Webinars = $Self_Study_Webinars->appends(request()->query());
       // echo "<pre>"; print_r($Self_Study_Webinars); exit;
        
        $statusList = StatusHelper::getStatusesList();

        $seriesList = Series::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
        
        if ($request->ajax()) {
            return Response::json(View('backEnd/selfstudy-webinar/index-ajax', compact('Self_Study_Webinars','statusList','seriesList'))->render());
        }
        
        return view('backEnd.selfstudy-webinar.index', compact('Self_Study_Webinars','statusList','seriesList'));
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
        return view('backEnd.selfstudy-webinar/add',compact('courseLevel','subjectAria','statusList','tags','userType'));
    }
    
     /**
     *  Store Self Webinar
     *
     * @param $request
     * 
     * @return view
     */

    public function store(Request $request) {
        try {
            $title = $request->input('title');
            $documents = $request->file('documents');
            $description = $request->input('description');
            $fee = $request->input('fee');
            $webinar_transcription = $request->input('webinar_transcription');
            $time_zone = $request->input('time_zone');
            $recorded_date = $request->input('recorded_date');
           // $start_time = $request->input('start_time');
           // $end_time = $request->input('end_time');
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
            
            $documentsURL = '';
            if($documents != ''){
                $documentsSize = $documents->getSize();
                $documentsName = str_replace(' ','-',time().$documents->getClientOriginalName());
                $documentsExt = strtolower($documents->getClientOriginalExtension());
                $documentsAllowedExt = 'xyz,jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx';
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
                    $request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
					return redirect()->back();
                }
            }
            
            
            $addArray = ['title'=>$title,
                        'webinar_type'=>'self_study',
                        'description'=>$description,
                        'webinar_transcription'=>$webinar_transcription,
                        'fee'=>$fee,
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
                        'tag'=>$tag_id,
                        'faq_1'=>$faq_1,
                        'faq_2'=>$faq_2,
                        'faq_3'=>$faq_3,
                        'faq_4'=>$faq_4,
                        'faq_5'=>$faq_5,
                        'status'=>'inactive',
                        'created_at'=>$created_at,
                        'created_by'=>Auth::guard('administrator')->user()->id,
                        ];
                             
                            
                           
            $createdData = Webinar::create($addArray);
            
            if($createdData){
            //$request->session()->flash('success', __('Webinar has been added successfully.'));
             
             return redirect('/selfstudy-webinar/'.$createdData->id.'/video');

             //Route::get('/selfystudy-Self_Study_Webinars/edit/{id}/documents
                
             //   return redirect()->route('speaker.self_study_Self_Study_Webinars').$request->input('uri');
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
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
                                    
                $webinar = Webinar::findOrFail($id);
                
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
                    return view('backEnd.selfstudy-webinar.edit', compact('webinar', 'statusList','subject_area_id','course_level_id','tag_id', 'courseLevel', 'subjectAria', 'tags','userType','who_should_attend_array'));
                }else{
                    $request->session()->flash('error', __('Seltstudy Webinar not available. Please, try again.'));
                    return redirect()->route('/selfstudy-webinar').$request->input('uri');
                }
            }else{
                $request->session()->flash('error', __('Webinar could not be load. Please, try again.'));
                return redirect()->route('/selfstudy-webinar').$request->input('uri');
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
    public function update(Request $request) { 

        try {
            $id = $request->input('id');
            $title = $request->input('title');
            $documents = $request->file('documents');
            $video = $request->file('video');
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
            
            $webinarDoc = Webinar::select('id','documents','video')->where('id','=',$id)->first();
            
			if(empty($webinarDoc->video)){
				$request->session()->flash('error', __('First you have to upload video, Than you can edit webinar.'));
                return redirect()->back();	
			}
			
            if($documents != ''){
				
                if(!empty($webinarDoc)){
                    $documentsSize = $documents->getSize();
                    $documentsName = str_replace(' ','-',time().$documents->getClientOriginalName());
                    $documentsExt = strtolower($documents->getClientOriginalExtension());
                    $documentsAllowedExt = 'xyz,jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx';
                    if($documentsSize < 81920099999999) { //800kb
                        if(strpos($documentsAllowedExt,$documentsExt) == true){
                            //Delete old documents and store new documents
                            $DeleteUrl = public_path('uploads/webinar_doc/'.$webinarDoc->documents);
                            File::delete($DeleteUrl);
                            //Store new file in syatem
                            $documents->move($destinationPath,$documentsName);
                            $documentsURL = $documentsName;
                        }else{
                            $request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, pdf, doc, docx, xls, xlsx, ppt, pptx.'));
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

            $videoDoc = Webinar::select('id','video')->where('id','=',$id)->first();
             if($video != ''){
                if(!empty($videoDoc)){
                    $videoSize = $video->getSize();
                    $videoName = str_replace(' ','-',time().$video->getClientOriginalName());
                    $videoExt = strtolower($video->getClientOriginalExtension());
                    $videoAllowedExt = 'xyz,mp4,3gp,webm,wmv,flv';
                    if($videoSize < 8192000000){ //8GB
                    if(strpos($videoAllowedExt,$videoExt) == true){
                            //Delete old documents and store new documents
                            $DeleteUrl = public_path('uploads/webinar_video/'.$videoDoc->video);
                            File::delete($DeleteUrl);
                            //Store new file in syatem
                            $video->move($destinationVideoPath,$videoName);
                            $videoURL = $videoName;
                        }else{
                            $request->session()->flash('error', __('Please upload valid file. Format should be: mp4,3gp,webm,wmv,flv'));
                            $videoURL = $videoDoc->video;
                        }
                    }else{
                        $request->session()->flash('error', __('Uploded file size should be less than 8GB.'));
                        $videoURL = $videoDoc->video; 
                    }
                }   
            }else{
                $videoURL = $videoDoc->video;
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
                        'tag'=>$tag_id,
                        'faq_1'=>$faq_1,
                        'faq_2'=>$faq_2,
                        'faq_3'=>$faq_3,
                        'faq_4'=>$faq_4,
                        'faq_5'=>$faq_5,
                        'updated_at'=>$updated_at,
                       // 'modified_by' => Auth::guard('speaker')->user()->id,
                        ];


  
            $updateData = Webinar::where('id',$id)->update($editArray);

 
            if($updateData){
                $request->session()->flash('success', __('Self Study Webinar has been update successfully.'));
                //return redirect()->route('selfstudy-webinar',$request->input('uri'));
				return redirect('/selfstudy-webinars/'.$id.'/add-webinar-question');
			}
            $request->session()->flash('error', __('Seltstudy Webinar could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('SeltstudyWebinar could not be saved. Please, try again.'));
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
		$webinar_id = $webinar_id;
		if(!empty($webinar_id) && is_numeric($webinar_id)){
			$WebinarQuestionsReview = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
												->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
												->where('webinar_questions.webinar_id',$webinar_id)
												//->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
												->where('webinar_questions.status','!=','delete')
												->where('webinar_questions.type','=','review')
												->orderby('id', 'desc')
												->get();
			$WebinarQuestionsFinal = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
												->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
												->where('webinar_questions.webinar_id',$webinar_id)
												//->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
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
			
			return view('backEnd.selfstudy-webinar/add-question', compact('WebinarQuestionsReview','WebinarQuestionsFinal','webinarDetail','statusList','review','final'));
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
			$added_by = Auth::guard('administrator')->user()->id;
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
				$request->session()->flash('success', __('Webinar Questions added successfully.'));
			 	//return redirect('selfstudy-webinars/'.$webinar_id.'/add-webinar-question');
				return redirect()->back();
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
		$id = $qus_id;
		if(!empty($id) && is_numeric($id)){
			$WebinarQuestionsEdit = WebinarQuestions::select('id','webinar_id', 'type','time','question','option_a','option_b', 'option_c', 'option_d','answer', 'currect_answer_note_a', 'wrong_answer_note_a', 'currect_answer_note_b', 'wrong_answer_note_b', 'currect_answer_note_c', 'wrong_answer_note_c', 'currect_answer_note_d', 'wrong_answer_note_d',  'status','created_at','updated_at','added_by','updated_by')
													->where('id','=',$id)
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
													//->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
													->where('webinar_questions.status','!=','delete')
													->orderby('id', 'desc')
													->get();
													
				$WebinarQuestionsFinal = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
													->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id')
													->where('webinar_questions.webinar_id',$WebinarQuestionsEdit->webinar_id)
													//->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)
													//->where('webinar_questions.status','!=','delete')
													->orderby('id', 'desc')
													->get();
				return view('backEnd.selfstudy-webinar/edit-question', compact('WebinarQuestionsEdit','webinars','statusList','WebinarQuestionsReview','WebinarQuestionsFinal'));	
			}else{
				$request->session()->flash('error', __('Webinar Questions can not be updated. Please try again.'));
				return redirect()->route('selfstudy.self_study_webinars').$request->input('uri');	
			}
		}else{
			$request->session()->flash('error', __('Please enter valid data for webinar. Please try again.'));
			return redirect()->route('selfstudy.self_study_webinars').$request->input('uri');		
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
		try {
			$id = $request->input('id');
			$webinar_id = $request->input('webinar_id');
			
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
				$updated_by = Auth::guard('administrator')->user()->id;
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
					//return redirect('selfstudy-webinars/edit-webinar-question/'.$id);
				}else{
					$request->session()->flash('error', __('Webinar Question could not be saved. Please, try again.'));
				}
				return redirect('selfstudy-webinars/'.$webinar_id.'/add-webinar-question');
			}else{
				$request->session()->flash('error', __('Please enter valid data for webinar. Please try again.'));
				return redirect('selfstudy-webinars/'.$webinar_id.'/add-webinar-question');
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
		$id = $qus_id;
		try {
			if(is_numeric($id) && !empty($id)){
				//check question id for webinar
				$webinarQuestion = WebinarQuestions::select('id','webinar_id')
													->where('id','=',$id)
													->first();
				if(!empty($webinarQuestion)){			
					$deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'updated_by' => Auth::guard('administrator')->user()->id];
					$delete = WebinarQuestions::where('id', '=', $id)->update($deleteArray);
					if($delete){
						$request->session()->flash('success', __('Webinar Questions has been deleted successfully.'));
					} else {
						$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
					}
					return redirect('/selfstudy-webinars/'.$webinarQuestion->webinar_id.'/add-webinar-question');
				}else{
					$request->session()->flash('error', __('Please Select valid Webinar Questions for delete. Please try again.'));
					return redirect()->route('selfstudy.self_study_webinars').$request->input('uri');		
				}
			}else{
				$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
				return redirect()->route('selfstudy.self_study_webinars').$request->input('uri');	
			}   
		} catch (Exception $ex) {
			$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
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
        return view('/backEnd/selfstudy-webinar/video',compact('id'));
    }
    
    
    /**
     * store selft study video for webinar
     *
     * @param $request
     * 
     * @return view
     */
    public function store_video(Request $request) {
        try {
            $video = $request->file('video');
            $webinar_id  =$request->input('webinar_id');
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
                $videoAllowedExt = 'xyz,mp4,3gp,webm,wmv,flv';
                if($videoSize < 8192000000){ //8GB
                    if(strpos($videoAllowedExt,$videoExt) == true){
                        $video->move($destinationPath,$videoName);
                        $videoURL = $videoName;
                    }else{
                        $request->session()->flash('error', __('Please upload valid file. Format should be: mp4,3gp,webm,wmv,flv.'));
                        $videoURL = '';
                         return Redirect::back();
                    }
                }else{
                    $request->session()->flash('error', __('uploaded file size should be less than 8GB.'));
                   return Redirect::back();
                }
            }
            $addVideoArray = ['video'=>$videoURL];
            $updateData = Webinar::where('id',$webinar_id)->where('created_by',Auth::guard('administrator')->user()->id)->update($addVideoArray);                
            if($updateData){
            	$request->session()->flash('success', __('Webinar video has been added successfully.'));
            	if(!empty($actionType)){
					return Response::json(['success' => true,'latestVideo'=>$videoName], 200);
				}else{
					return redirect('/selfstudy-webinar');
				}
	         	//Route::get('/selfstudy-Self_Study_Webinars/edit/{id}/documents
             	//return redirect()->route('speaker.self_study_Self_Study_Webinars').$request->input('uri');
            }
            $request->session()->flash('error', __('Webinar video could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar video could not be saved. Please, try again.'));
        }
    }
    
    /**
     * Delete Self Study webinar  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
        try {
            if(is_numeric($id) && !empty($id)){
                $deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'modified_by' => Auth::guard('administrator')->user()->id];
                
                $delete = Webinar::where('id', '=', $id)->update($deleteArray);
                if($delete){
                    $request->session()->flash('success', __('Self study webinar has been deleted successfully.'));
                } else {
                    $request->session()->flash('error', __('Self study webinar can not be deleted. Please try again.'));
                }
                return redirect()->route('selfstudy-webinar').$request->input('uri');
            }else{
                $request->session()->flash('error', __('Self study webinar can not be deleted. Please try again.'));
                 return redirect()->route('selfstudy-webinar').$request->input('uri');
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
        $SelfStudyWebinarsView = Webinar::select('webinars.id','webinars.cpa_credit','webinars.title','webinars.image','webinars.learning_objectives','webinars.Instructional_method', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone','webinars.reason')
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
           return view('backEnd.selfstudy-webinar.view', compact('SelfStudyWebinarsView','WebinarQuestionsReview','WebinarQuestionsFinal'));
     }


     /**
     * Update series 
     *
     * @param $request
     * 
     * @return ajax call
     */

    public function updateSeries(Request $request) {
        $series = $request->input('series');
        $id = $request->input('id');
         if(!empty($series)){
            $editArray = ['series'=>$series,
                        'updated_at'=>Carbon::now(),
                        'modified_by' => Auth::guard('administrator')->user()->id,
                        ];
            $updateData = Webinar::where('id',$id)->update($editArray);
        } 
    }
    
     /**
     * Update status
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function statusUpdate(Request $request) { 
        $id = $request->input('id');
        $status = $request->input('status');
        $code = $request->input('code');
        $state = $request->input('state');
        $reason = $request->input('reason');

        $webinar_data = Webinar::select('id','created_by','title')->where('id',$id)->first();
        $speaker_id = $webinar_data['created_by'];
        //Session::forget('mycpa_webinar_reason');
        if(!empty($id)){ 
            if($status == 'active' && empty($code)){
                Session::put('mycpa_webinar_reason', '');
                $url = 'https://api.vimeo.com/oauth/authorize?client_id='.env("VIMEO_CLIENTS_KEY").'&response_type=code&redirect_uri='.env("HTTP_ADMIN_APP_URL").'selfstudy-webinar/update-status?id='.$id.'&state=create&scope=upload';
                
                $notification_text = 'Your webinar has been accepted from the admin.';
                $link = 'selfstudy-webinars/view/'.encrypt($id); 
                $data = ['notification_text'=>$notification_text,
                'is_admin'=>'0',
                'user_id'=>$speaker_id,
                'created_at'=>Carbon::now(),
                'link'=>$link,
                ];

                Notifications::insert($data);

                return redirect($url);
            }elseif(($status == 'inactive' || $status == 'delete') && empty($code)){
                Session::put('mycpa_webinar_reason', $reason);
                $url = 'https://api.vimeo.com/oauth/authorize?client_id='.env("VIMEO_CLIENTS_KEY").'&response_type=code&redirect_uri='.env("HTTP_ADMIN_APP_URL").'selfstudy-webinar/update-status?id='.$id.'&state='.$status.'&scope=delete';
                
                if($status == 'inactive'){
                    $notification_text = 'Your webinar has been disapproved from the admin. Please see the comments section or contact them directly. ';
                    $link = 'selfstudy-webinars/view/'.encrypt($id); 
                    $data = ['notification_text'=>$notification_text,
                    'is_admin'=>'0',
                    'user_id'=>$speaker_id,
                    'created_at'=>Carbon::now(),
                    'link'=>$link,
                    ];
                     Notifications::insert($data);
                }
               
                return redirect($url);  
            }elseif(!empty($code) && !empty($state)){
                if($state == 'create'){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.vimeo.com/oauth/access_token",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\nauthorization_code\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"code\"\r\n\r\n".$code."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"redirect_uri\"\r\n\r\n".env("HTTP_ADMIN_APP_URL")."selfstudy-webinar/update-status?id=".$id."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ".env("VIMEO_BASE_64_AUTHORIZATION_KEY"),
                            "cache-control: no-cache",
                            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
                        ),
                    ));
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        $request->session()->flash('error', __($err));
                        return redirect()->route('selfstudy-webina',$request->input('uri'));
                    } else {
                        $decodeJsonResponce = json_decode($response);
                        //dd($decodeJsonResponce);
                        if(!empty($decodeJsonResponce) && !empty($decodeJsonResponce->access_token)){
                            //get set id data from database
                            $webinarData = Webinar::select('id','title','description','video')->where('id','=',$id)->first();
                            if(!empty($webinarData)){
                                $videoLink = env('APP_URL').'/uploads/webinar_video/'.$webinarData->video;
                                //generate new password for video
                                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                                $pass = array();
                                $alphaLength = strlen($alphabet) - 1;
                                for($i = 0; $i < 8; $i++){
                                    $n = rand(0, $alphaLength);
                                    $pass[] = $alphabet[$n];
                                }
                                $generatePassword = implode($pass);
                                
                                //write code for upload video in vimeo server
                                //NOTE:------AFTER MAKIN LIVE YOU HAVE TO REPLACE VIDEO URL WITH LIVE DATABASE------------------------------------------------INPORTANT
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => "https://api.vimeo.com/me/videos",
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                     CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "POST",
                                    CURLOPT_POSTFIELDS => "{\r\n    \"upload\" : {\r\n        \"approach\" : \"pull\",\r\n        \"link\" : \"".$videoLink."\"\r\n    },\r\n    \"name\" : \"".preg_replace('/[^A-Za-z0-9\-]/', '', $webinarData->title)."\",\r\n    \"description\" : \"\",\r\n    \"privacy\" : {\r\n        \"view\" : \"anybody\"\r\n    }\r\n}",
                                    CURLOPT_HTTPHEADER => array(
                                        "Authorization: bearer ".$decodeJsonResponce->access_token,
                                        "Content-Type: application/json",
                                        "cache-control: no-cache"
                                    ),
                                ));
                                
                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                                $decodeVimeoArray = json_decode($response);
								//dd($decodeVimeoArray);
                                curl_close($curl);
                                if($err){
                                    $request->session()->flash('error', __($err));
                                    return redirect()->route('selfstudy-webina',$request->input('uri'));
                                }else{
                                    if(!empty($decodeVimeoArray) && !empty($decodeVimeoArray->link)){
                                        //update vimeo data with table
										$updated_at = Carbon::now();
                                        $status = 'active';
                                        $vimeo_response  = $decodeVimeoArray;
                                        $vimeo_url = $vimeo_response->link;
                                        $vimeo_res = $response;
                                        $vimeo_video_code = substr($vimeo_url, strrpos($vimeo_url, '/') + 1);
                                        $vimeo_embaded = $vimeo_response->embed->html;
                                        $Upadatestatus = ['status'=>$status,'vimeo_url'=>$vimeo_url,'vimeo_response' =>$vimeo_res,'vimeo_embaded'=>$vimeo_embaded,'vimeo_video_code'=>$vimeo_video_code,'vimeo_password'=>$generatePassword,'reason'=>'','updated_at'=>$updated_at];
                                        $upadateSelfStudy = Webinar::where('id','=',$id)->update($Upadatestatus);

                                        $notification_text = 'Your webinar has been accepted from the admin.';
                                        $link = 'selfstudy-webinars/view/'.encrypt($id); 
                                        $data = ['notification_text'=>$notification_text,
                                        'is_admin'=>'0',
                                        'user_id'=>$speaker_id,
                                        'created_at'=>Carbon::now(),
                                        'link'=>$link,
                                        ];

                                        Notifications::insert($data);
                                        
                                        $request->session()->flash('success', __('Webinar activated and video uploaded successfully.'));
                                        return redirect()->route('selfstudy-webinar');  
                                    }else{
                                        $request->session()->flash('error', __('There was a some issue on upload video to vimeo server. Please try again.'));
                                        return redirect()->route('selfstudy-webinar').$request->input('uri');
                                    }
                                }   
                            }else{
                                $request->session()->flash('error', __('There was a some issue on getting data for selected record. Please try again.'));
                                return redirect()->route('selfstudy-webinar').$request->input('uri');   
                            }
                        }else{
                            $request->session()->flash('error', __('There was a some issue on getting token from vimeo. Please try again.'));
                            return redirect()->route('selfstudy-webinar').$request->input('uri');
                        }
                    }   
                }elseif($state == 'inactive' || $state == 'delete'){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://api.vimeo.com/oauth/access_token",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\nauthorization_code\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"code\"\r\n\r\n".$code."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"redirect_uri\"\r\n\r\n".env("HTTP_ADMIN_APP_URL")."selfstudy-webinar/update-status?id=".$id."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
                      CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic ".env("VIMEO_BASE_64_AUTHORIZATION_KEY"),
                        "cache-control: no-cache",
                        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
                      ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        $request->session()->flash('error', __($err));
                        return redirect()->route('selfstudy-webinar',$request->input('uri'));
                    } else {
                        $decodeJsonResponce = json_decode($response);
                        //dd($decodeJsonResponce);
                        if(!empty($decodeJsonResponce) && !empty($decodeJsonResponce->access_token)){
                            //get set id data from database
                            $webinarData = Webinar::select('id','title','description','vimeo_video_code','vimeo_password')->where('id','=',$id)->first();
                            //dd($webinarData);
                            if(!empty($webinarData) && !empty($webinarData->vimeo_video_code) && !empty($webinarData->vimeo_password)){
                                //write code for upload video in vimeo server
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => "https://api.vimeo.com/videos/".$webinarData->vimeo_video_code,
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => "",
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 30,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => "DELETE",
                                  CURLOPT_POSTFIELDS => "{\r\n    \"password\": \"".$webinarData->vimeo_password."\"\r\n}",
                                  CURLOPT_HTTPHEADER => array(
                                    "Authorization: bearer ".$decodeJsonResponce->access_token,
                                    "cache-control: no-cache"
                                  ),
                                ));
                                
                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                                if($err){
                                    $request->session()->flash('error', __($err));
                                    curl_close($curl);
                                    return redirect()->route('selfstudy-webina',$request->input('uri'));
                                }else{
                                    $decodeVimeoArray = json_decode($response);
                                    //echo "<pre>"; print_r($decodeVimeoArray); exit;
                                    curl_close($curl);
                                    if(empty($decodeVimeoArray)){
                                        //update webinar status
                                        $reason = Session::get('mycpa_webinar_reason');
                                        Session::forget('mycpa_webinar_reason');



                                        $statusCode = $state == 'delete' ? 'STATUS_DELETE':'STATUS_INACTIVE';
                                        $webinar = Webinar::where('id', $id)->update([
                                            'vimeo_video_code' => '',
                                            'vimeo_response' => '',
                                            'vimeo_url'=>'',
                                            'vimeo_embaded'=>'',
                                            'vimeo_password'=>'',
                                            'reason'=>$reason,
                                            'status' => config('constants.STATUS.'.$statusCode),
                                            'modified_by' => Auth::guard('administrator')->user()->id,
                                            'updated_at' => Carbon::now()
                                         ]);

                                        if($status == 'inactive'){
                                            $notification_text = 'Your webinar has been disapproved from the admin. Please see the comments section or contact them directly. ';
                                            $link = 'selfstudy-webinars/view/'.encrypt($id); 
                                            $data = ['notification_text'=>$notification_text,
                                            'is_admin'=>'0',
                                            'user_id'=>$speaker_id,
                                            'created_at'=>Carbon::now(),
                                            'link'=>$link,
                                            ];
                                            Notifications::insert($data);
                                        }

                                        $request->session()->flash('success', __('Selfstudy webinar '.$state.' successfully.'));
                                        return redirect()->route('selfstudy-webinar',$request->input('uri'));
                                    }else{
                                        $request->session()->flash('error', __('There was a some issue on delete vimeo video. Please try again.'));
                                        return redirect()->route('selfstudy-webinar').$request->input('uri');
                                    }
                                }   
                            }else{
                                $statusCode = $state == 'delete' ? 'STATUS_DELETE':'STATUS_INACTIVE';
                                 $reason = Session::get('mycpa_webinar_reason');
                                           Session::forget('mycpa_webinar_reason');
                                $webinar = Webinar::where('id', $id)->update([
                                                        'vimeo_video_code' => '',
                                                        'vimeo_response' => '',
                                                        'vimeo_url'=>'',
                                                        'vimeo_embaded'=>'',
                                                        'vimeo_password'=>'',
                                                        'reason'=>$reason,
                                                        'status' => config('constants.STATUS.'.$statusCode),
                                                        'modified_by' => Auth::guard('administrator')->user()->id,
                                                        'updated_at' => Carbon::now()
                                                     ]);

                                if($status == 'inactive'){
                                            $notification_text = 'Your webinar has been disapproved from the admin. Please see the comments section or contact them directly. ';
                                            $link = 'selfstudy-webinars/view/'.encrypt($id); 
                                            $data = ['notification_text'=>$notification_text,
                                            'is_admin'=>'0',
                                            'user_id'=>$speaker_id,
                                            'created_at'=>Carbon::now(),
                                            'link'=>$link,
                                            ];
                                            Notifications::insert($data);
                                }

                                $request->session()->flash('success', __('Selfstudy webinar '.$state.' successfully.'));
                                return redirect()->route('selfstudy-webinar',$request->input('uri'));   
                            }
                        }else{
                            $request->session()->flash('error', __('There was a some issue on getting token from vimeo. Please try again.'));
                            return redirect()->route('selfstudy-webinar').$request->input('uri');
                        }
                    }
                }
            }else{
                $request->session()->flash('error', __('There was a some issue on your request. Please try again.'));
                return redirect()->route('selfstudy-webinar').$request->input('uri');
            }
        }else{
            $request->session()->flash('error', __('There was a some issue on data. Please try again.'));
            return redirect()->route('selfstudy-webinar').$request->input('uri');       
        }
    }
       
}
