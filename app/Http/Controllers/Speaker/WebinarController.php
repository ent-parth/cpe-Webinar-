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
use App\Repositories\Speakers;
use App\Repositories\SpeakerInvitation;
use App\Repositories\Notifications;
use App\Repositories\Administrators;
use App\Repositories\Courses;
use App\Repositories\CourseLevel;
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

class WebinarController extends Controller{

    /**
     * Speaker Controller listing
     *
     * @var string
     */
    
	public function index(Request $request){
		$webinars = Webinar::select('id','title', 'fee','webinar_type','recorded_date','start_time', 'end_time', 'created_at', 'status','time_zone');
		
		// For status filter			
        $status = $request->input('status');
        if ($status != '') {
        	$webinars = $webinars->where('webinars.status', '=', $status);
        }else{
			$webinars = $webinars->where('webinars.status', '!=', 'delete');
		}
		
		/*// For timezone filter
		$time_zone = $request->input('time_zone');
		$recorded_date = $request->input('recorded_date');
        if ($time_zone != '' && $recorded_date == '') {
        	$webinars = $webinars->where('time_zone', '=', $time_zone);
        }
		
		// For date filter			
        if ($recorded_date != '' && $time_zone == '') {
        	$webinars = $webinars->where('recorded_date', '=', $recorded_date);
        }
		
		// For timezone filter and date both
        if ($time_zone != '' && $recorded_date != '') { 
			$start_date = CommonHelper::convertUTC($recorded_date.' 00:00:00',$time_zone,'Y-m-d');
			$end_date = CommonHelper::convertUTC($recorded_date.' 23:59:59',$time_zone,'Y-m-d');
			$webinars = $webinars->where('recorded_date', '>=', $start_date)->where('recorded_date', '<=', $end_date)->where('time_zone', '=', $time_zone);
        }*/
		
		// For date filter
		$recorded_date = $request->input('recorded_date');
		if ($recorded_date != '') {
        	$webinars = $webinars->where('recorded_date', '>=', $recorded_date);
        }
		
		$now = Carbon::now();
		$webinars = $webinars->where(function($q) use ($now) {
											$q->where('webinars.end_time', '>=', $now)
											->orWhere('status','=','draft');
											});
		
        // For text input filter
        if ($request->input('title') != '') {
			$searchStr =  $request->input('title');
			$searchStr = '%' . $searchStr . '%';
		    $webinars = $webinars->where('title', 'LIKE', $searchStr);
		}
		
		$webinars = $webinars->where('webinar_type','live')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->orderby('id', 'desc')->paginate(env('PAGINATION'));
		$webinars =	$webinars->appends(request()->query());
		//echo "<pre>"; print_r($webinars); exit;
		
		$statusList = StatusHelper::getStatusesList();
        
		if ($request->ajax()) {
			return Response::json(View('speaker/webinars/index-ajax', compact('webinars','statusList'))->render());
		}
		
        return view('speaker.webinars.index', compact('webinars','statusList'));
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
		return view('speaker/webinars/add',compact('courseLevel','subjectAria','statusList','tags','userType'));
    }
	
	
	
	/**
     * Check time availability for new cretae webinar
     *
     * @param $request
     * 
     * @return view
     */
    public function checkAvailability(Request $request) {
		$recorded_date = $request->input('start_time');
		$time_zone = $request->input('time_zone');
		
		if(!empty($recorded_date) && !empty($time_zone)){
			$recorded_date = date("Y-m-d", strtotime($recorded_date));
			$recorded_date = str_replace('-', '/', $recorded_date);
			
			$tomorrow = date('Y-m-d',strtotime($recorded_date . "+1 days"));
			$yesterday = date('Y-m-d',strtotime($recorded_date . "-1 days"));
			
			$webinarList = Webinar::select('id', 'start_time','end_time','recorded_date')
									->whereBetween('recorded_date',array($yesterday, $tomorrow))
									->where('status','!=','delete')
									->where('webinar_type','live')
									->orderBy('start_time', 'ASC')
									->get();
			if(count($webinarList) == 0) {
				echo '<p><b>No any Booked time slots near your date</b></p>';
			} else {
				echo '<p><b>Booked time slots near your date</b></p>';
				foreach($webinarList as $wb) {
					$bookedStartDate = $wb->start_time;
					$bookedEndDate = $wb->end_time;
	
					$displayStartDate = new DateTime($bookedStartDate);
					$displayStartDate->setTimezone(new DateTimeZone($time_zone));
					$finaldisplayStartDate = $displayStartDate->format('Y-m-d H:i:s');
					
					$displayEndDate = new DateTime($bookedEndDate);
					$displayEndDate->setTimezone(new DateTimeZone($time_zone));
					$finaldisplayEndDate = $displayEndDate->format('Y-m-d H:i:s');
					
					echo '<P><span style="color:#3C8DBC">'.date("Y-m-d H:i",strtotime($finaldisplayStartDate)).'</span>  <span style="color:#D73925; font-weight:bold; padding-left:5px; padding-right:5px;">to</span>  <span style="color:#3C8DBC">'.date("Y-m-d H:i",strtotime($finaldisplayEndDate)).'</span></p>';
					 
				}
			}
		}
	}
	
	
	/**
     * Check time availability for new cretae webinar
     *
     * @param $request
     * 
     * @return view
     */
    public function checkAvailabilityFinal(Request $request) {
		$time_zone = $request->input('time_zone');
		$start_time =  $request->input('start_time');
		$end_time =  $request->input('end_time');
		$webinar_id = $request->input('webinar_id');
		
		
		$hourdiff = (strtotime($end_time) - strtotime($start_time))/3600;

		
		if($hourdiff <= 0 || $hourdiff > 24) {
			return Response::json(['error' => true], 300);exit;
		}
		
		//calculate time with utc and check reserve time for webinar
		$bookingStartDate = $start_time;
		$bookingEndDate = $end_time;

		date_default_timezone_set($time_zone);
		$user_timestamp_start = strtotime($bookingStartDate);
		date_default_timezone_set('UTC');
		$final_start = date("Y-m-d H:i:s", $user_timestamp_start);
		
		date_default_timezone_set($time_zone);
		$user_timestamp_end = strtotime($bookingEndDate);
		date_default_timezone_set('UTC');
		$final_end = date("Y-m-d H:i:s", $user_timestamp_end); 
		
		$webinar_qry = Webinar::select('id')->where('webinar_type','live')->where('status','!=','delete')
											->where(function($q) use ($final_start,$final_end) {
											$q->whereBetween('start_time',[$final_start,$final_end])
											->orWhereBetween('end_time',[$final_start,$final_end]);
											});
		if($webinar_id!='') {
			$webinar_qry = $webinar_qry->whereNotIn('id',[$webinar_id]);
		}
		$webinar_qry = $webinar_qry->count();
		
		
		return 	$webinar_qry;			
	}
	
	
	/**
     * Add webinar
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
			$temp_recorded_date = $request->input('recorded_date');
			$booking_start_time = $request->input('start_time');
			$booking_end_time = $request->input('end_time');
			$subject_area = $request->input('subject_area');
			$course_level = $request->input('course_level');
			$pre_requirement = $request->input('pre_requirement');
			$advance_preparation = $request->input('advance_preparation');
			$who_should_attend = $request->input('who_should_attend');
			$tag = $request->input('tag');
			$faq_1 = $request->input('faq_1');
			$faq_2 = $request->input('faq_2');
			$faq_3 = $request->input('faq_3');
			$faq_4 = $request->input('faq_4');
			$faq_5 = $request->input('faq_5');
			$created_at = Carbon::now();
			$draft = $request->input('draft');
			$learning_objectives = $request->input('learning_objectives');
			$Instructional_method = $request->input('Instructional_method');
			//echo 'dd';exit;	
			if(!empty($time_zone) && !empty($booking_end_time) && !empty($booking_start_time)){	
				$recorded_date = date("Y-m-d", strtotime($booking_start_time));
			
				date_default_timezone_set($time_zone);
				$user_timestamp_start = strtotime($booking_start_time);
				date_default_timezone_set('UTC');
				$start_time = date("Y-m-d H:i:s", $user_timestamp_start);
				
				
				
				date_default_timezone_set($time_zone);
				$user_timestamp_end = strtotime($booking_end_time);
				date_default_timezone_set('UTC');
				$end_time = date("Y-m-d H:i:s", $user_timestamp_end);
			}
			
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
						$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, xls, xlsx, pdf, doc, docx, ppt, pptx.'));
						return redirect()->back();
						$documentsURL = '';
					}
				}else{
					$request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
					return redirect()->back();
				}
			}
			
		if($draft==1){
				
			$addArray = ['title'=>$title,
						'webinar_type'=>'live',
						'description'=>$description,
						'webinar_transcription'=>$webinar_transcription,
						'fee'=>$fee,
						'cpa_credit'=>$cpa_credit,
						'subject_area'=>$subject_area_id,
						'course_level'=>$course_level_id,
						'pre_requirement'=>$pre_requirement,
						'advance_preparation'=>$advance_preparation,
						'who_should_attend'=>$who_should_attend_id,
						'documents'=>$documentsURL,
						'image'=>$imageURL,
						'tag'=>$tag_id,
						'faq_1'=>$faq_1,
						'faq_2'=>$faq_2,
						'faq_3'=>$faq_3,
						'faq_4'=>$faq_4,
						'faq_5'=>$faq_5,
						'status'=>'draft',
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
						'added_by'=>'speaker',
						'created_at'=>$created_at,
						'created_by'=>Auth::guard('speaker')->user()->id,
						];
								
			$createdData = Webinar::create($addArray);
		    
			if($createdData){
                $request->session()->flash('success', __('Webinar has been added successfully.'));
                return redirect()->route('speaker.webinar');
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
			
			}else{	
			$addArray = ['title'=>$title,
						'webinar_type'=>'live',
						'description'=>$description,
						'webinar_transcription'=>$webinar_transcription,
						'fee'=>$fee,
						'cpa_credit'=>$cpa_credit,
						'time_zone'=>$time_zone,
						'recorded_date'=>$recorded_date,
						'start_time'=>$start_time,
						'end_time'=>$end_time,
						'subject_area'=>$subject_area_id,
						'course_level'=>$course_level_id,
						'pre_requirement'=>$pre_requirement,
						'advance_preparation'=>$advance_preparation,
						'who_should_attend'=>$who_should_attend_id,
						'documents'=>$documentsURL,
						'image'=>$imageURL,
						'tag'=>$tag_id,
						'faq_1'=>$faq_1,
						'faq_2'=>$faq_2,
						'faq_3'=>$faq_3,
						'faq_4'=>$faq_4,
						'faq_5'=>$faq_5,
						'status'=>'inactive',
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
						'added_by'=>'speaker',
						'created_at'=>$created_at,
						'created_by'=>Auth::guard('speaker')->user()->id,
						];
								
			$createdData = Webinar::create($addArray);


		    
			if($createdData){
				
				//notification start /////
				$first_name = Auth::guard('speaker')->user()->first_name;
				$last_name =  Auth::guard('speaker')->user()->last_name;
				
				$admin_user = Administrators::get();
				
				foreach($admin_user as $usr){
						$user_id =  $usr['id'];
						$link = 'live-webinar';
						$notification_text = $first_name.' '. $last_name. ' has uploaded an Live Webinar. Please review it.'; 
						$data[]  = array('notification_text'=>$notification_text,'is_admin'=> '1','user_id' => $user_id,'created_at'=>Carbon::now(),'link'=>$link);
				}
					
				Notifications::insert($data); 
				//notification end /////




                $request->session()->flash('success', __('Webinar has been added successfully.'));
                return redirect()->route('speaker.webinar');
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
		}
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
									
				$webinar = Webinar::where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('webinar_type','live')->findOrFail($id);
				
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
					return view('speaker.webinars.edit', compact('webinar', 'statusList','subject_area_id','course_level_id','tag_id', 'courseLevel', 'subjectAria', 'tags', 'userType','who_should_attend_array'));
				}else{
					$request->session()->flash('error', __('Webinar not available. Please, try again.'));
					return redirect()->route('speaker.webinar',$request->input('uri'));
				}
			}else{
				$request->session()->flash('error', __('Webinar could not be load. Please, try again.'));
				return redirect()->route('speaker.webinar',$request->input('uri'));
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
			$image = $request->file('image');
			$description = $request->input('description');
			$fee = $request->input('fee');
			$cpa_credit = $request->input('cpa_credit');
			$webinar_transcription = $request->input('webinar_transcription');
			if($request->input('time_zone') == ''){
				$webinar_time = Webinar::select('time_zone')->where('id', '=', $id)->first();
				$time_zone = $webinar_time->time_zone;
			}else {
				$time_zone = $request->input('time_zone');
			}
			$temp_recorded_date = $request->input('recorded_date');
			$booking_start_time = $request->input('start_time');
			$booking_end_time = $request->input('end_time');
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
			
			$recorded_date = date("Y-m-d", strtotime($booking_start_time));
			
			date_default_timezone_set($time_zone);
			$user_timestamp_start = strtotime($booking_start_time);
			date_default_timezone_set('UTC');
			$start_time = date("Y-m-d H:i:s", $user_timestamp_start);
						
			date_default_timezone_set($time_zone);
			$user_timestamp_end = strtotime($booking_end_time);
			date_default_timezone_set('UTC');
			$end_time = date("Y-m-d H:i:s", $user_timestamp_end);
			
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
			
			$webinarDoc	= Webinar::select('id','documents','image')->where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('webinar_type','live')->where('id','=',$id)->first();
			
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
							$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, xls, xlsx, bmp, pdf, doc, docx, xls, xlsx, ppt, pptx.'));
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
			
			
			$editArray = ['title'=>$title,
						'webinar_type'=>'live',
						'description'=>$description,
						'webinar_transcription'=>$webinar_transcription,
						'fee'=>$fee,
						'cpa_credit'=>$cpa_credit,
						'time_zone'=>$time_zone,
						'recorded_date'=>$recorded_date,
						'start_time'=>$start_time,
						'end_time'=>$end_time,
						'subject_area'=>$subject_area_id,
						'course_level'=>$course_level_id,
						'pre_requirement'=>$pre_requirement,
						'advance_preparation'=>$advance_preparation,
						'who_should_attend'=>$who_should_attend_id,
						'documents'=>$documentsURL,
						'image' => $imageURL,
						'tag'=>$tag_id,
						'faq_1'=>$faq_1,
						'faq_2'=>$faq_2,
						'faq_3'=>$faq_3,
						'faq_4'=>$faq_4,
						'faq_5'=>$faq_5,
						'status'=>'inactive',
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
						'updated_at'=>$updated_at,
						'modified_by' => Auth::guard('speaker')->user()->id,
						];
			$updateData = Webinar::where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('id',$id)->update($editArray);
		    if($updateData){
				//notification start /////
				if($current_status == 'draft') {
					$first_name = Auth::guard('speaker')->user()->first_name;
					$last_name =  Auth::guard('speaker')->user()->last_name;
					
					$admin_user = Administrators::get();
					
					foreach($admin_user as $usr){
							$user_id =  $usr['id'];
							$link = 'live-webinar';
							$notification_text = $first_name.' '. $last_name. ' has uploaded an Live Webinar. Please review it.'; 
							$data[]  = array('notification_text'=>$notification_text,'is_admin'=> '1','user_id' => $user_id,'created_at'=>Carbon::now(),'link'=>$link);
					}
						
					Notifications::insert($data); 
				}
				//notification end /////
                $request->session()->flash('success', __('Webinar has been update successfully.'));
                return redirect()->route('speaker.webinar',$request->input('uri'));
            }
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar could not be saved. Please, try again.'));
        }
	}
	
	/**
	* View Speaker Invation 
	 * @param Request $request
     * @return type
     *
     */
	 
	
	public function speaker_invitation(Request $request, $sid){


		$sid = decrypt($sid);
		
		$SpeakerInvitation = Speakers::select('speakers.id','speakers.avatar','speakers.first_name', 'speakers.last_name','speakers.email','companies.name','speakers.contact_no')
										->leftJoin('companies','companies.id','=','speakers.company_id')
										->where('speakers.id','!=',Auth::guard('speaker')->user()->id)
										->where('speakers.status','=','active')
										->get();
										//dd($SelfStudyWebinarsView);


		$Invitation = array();
		$i=0;
		foreach($SpeakerInvitation as $idata){
			$Invitation[$i]['id'] = $idata->id;
			$Invitation[$i]['first_name'] = $idata->first_name;
			$Invitation[$i]['last_name'] = $idata->last_name;
			$Invitation[$i]['email'] = $idata->email;
			$Invitation[$i]['company_name'] = $idata->name;
			$Invitation[$i]['speaker_status'] = $idata->status;
			$Invitation[$i]['avatar'] = $idata->avatar;
			$Invitation[$i]['contact_no'] = $idata->contact_no;

			$SpeakerInvitationChecked = SpeakerInvitation::select('id','status')->where('webinar_id',$sid)->where('speaker_id',$idata->id)->first();

			$Invitation[$i]['speaker_invited'] = 'no';
			if($SpeakerInvitationChecked){
				$Invitation[$i]['speaker_invited']  = 'yes';
				$Invitation[$i]['speaker_status'] = $SpeakerInvitationChecked->status;
			}
			$i++;
		} 

		$webinar_id = $sid;	
		return view('speaker.webinars.speaker_invitation', compact('Invitation','webinar_id'));

	 }

	/**
	* Update Speaker Invatation
	 * @param Request $request
     * @return type
     * 
     */
		public function speaker_invitation_update(Request $request){


		$webinar_id = $request->webinar_id;

		$webinar_data = Webinar::select('title')->where('id',$webinar_id)->first();
		$webinar_name  = '';
		if($webinar_data){
			$webinar_name = $webinar_data->title;
		}

		if (is_array($request->invitation) || is_object($request->invitation)){
			foreach ($request->invitation as $speaker_id) {


				$invitesArray = ['speaker_id'=>$speaker_id,
								'webinar_id'=>$webinar_id,
								'status'=>'pending',
								'created_at'=>Carbon::now(),
								//'created_by'=>Auth::guard('speaker')->user()->id,
	 							];
	 			$invidatedData = SpeakerInvitation::create($invitesArray);

	 			//notification start
				$first_name = Auth::guard('speaker')->user()->first_name;
				$last_name =  Auth::guard('speaker')->user()->last_name;
				$notification_text = 'You have been invited as speaker in the '.$webinar_name.' by '.$first_name.' '.$last_name;
				$link = 'webinar/view/'.encrypt($webinar_id); 

	 			$data = ['notification_text'=>$notification_text,
								'is_admin'=>'0',
								'user_id'=>$speaker_id,
								'created_at'=>Carbon::now(),
								'link'=>$link,
							
	 							];

				Notifications::insert($data);
				//notification end



			}
		}			
		
		$request->session()->flash('success', __('Speaker Invite successfully.'));
       	return redirect()->route('speaker.webinar',$request->input('uri'));
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
				
				$delete = Webinar::where('created_by',Auth::guard('speaker')->user()->id)->where('added_by','speaker')->where('webinar_type','live')->where('id', '=', $id)->update($deleteArray);
				if($delete){
					$request->session()->flash('success', __('Webinar has been deleted successfully.'));
				} else {
					$request->session()->flash('error', __('Webinar can not be deleted. Please try again.'));
				}
				return redirect()->route('speaker.webinar',$request->input('uri'));
			}else{
				$request->session()->flash('error', __('Webinar can not be deleted. Please try again.'));
				 return redirect()->route('speaker.webinar',$request->input('uri'));
			}	
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Webinar can not be deleted. Please try again.'));
        }
    }

    /**
	* View Live Webinars status 
	 * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	 
	public function view(Request $request, $id){
		$id = decrypt($id);
		$LiveWebinarsView = Webinar::select('webinars.id','webinars.cpa_credit','webinars.title', 'webinars.fee','webinars.webinar_type','webinars.image','webinars.learning_objectives','webinars.Instructional_method','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone','webinars.reason')
									->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
									->leftJoin('courses','courses.course_level_id','=','course_levels.id')
									->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
									->leftjoin('speakers','speakers.id','=','webinars.created_by') 
									->leftJoin('tags','tags.id','=','webinars.tag')
									->where('webinars.id','=', $id)
									->first();
									//dd($SelfStudyWebinarsView);
		return view('speaker.webinars.view', compact('LiveWebinarsView'));
	 }
	
	
		
}
