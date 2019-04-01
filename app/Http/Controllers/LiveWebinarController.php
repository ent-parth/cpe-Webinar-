<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\Courses;
use App\Repositories\CourseLevel;
use App\Repositories\Series;
use App\Repositories\Speakers;
use App\Repositories\WebinarCoOrganizer;
use App\Repositories\SpeakerInvitation;
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

class LiveWebinarController extends Controller{

    /**
     * live webinar Controller listing
     *
     * @var string
     */
    
	public function index(Request $request){

		$webinars = Webinar::select('webinars.id','speakers.first_name','speakers.last_name','webinars.title', 'webinars.fee','webinars.webinar_type','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at', 'webinars.status','webinars.series')->leftJoin('speakers','speakers.id','=','webinars.created_by');
		
		// For status filter			
        $status = $request->input('status');
        if ($status != '') {
        	$webinars = $webinars->where('webinars.status', '=', $status);
        }else{
			$webinars = $webinars->where('webinars.status', '!=', 'delete')->where('webinars.status', '!=', 'draft');
		}
		
		$webinars = $webinars->where('webinars.end_time', '>=', Carbon::now());
		
        // For text input filter
        if ($request->input('title') != '') {
			$searchStr =  $request->input('title');
			$searchStr = '%' . $searchStr . '%';
		    $webinars = $webinars->where('webinars.title', 'LIKE', $searchStr);
		 }
		 
		// For date filter          
        $recorded_date = $request->input('recorded_date');
        if ($recorded_date != '') {
            $webinars = $webinars->where('webinars.recorded_date', '>=', $recorded_date);
        }

		
		$webinars = $webinars->where('webinars.webinar_type','live')->orderby('webinars.id', 'desc')->paginate(env('PAGINATION'));
		$webinars =	$webinars->appends(request()->query());
		//echo "<pre>"; print_r($webinars); exit;
		
		$statusList = StatusHelper::getStatusesList();

		$seriesList = Series::select('id', 'name')
							->where('status','=','active')
							->orderBy('name', 'ASC')
							->get();

        
		if ($request->ajax()) {
			return Response::json(View('backEnd/live_webinars/index-ajax', compact('webinars','statusList','seriesList'))->render());
		}
		
        return view('backEnd.live_webinars.index', compact('webinars','statusList','seriesList'));
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
		return view('backEnd/live_webinars/add',compact('courseLevel','subjectAria','statusList','tags','userType'));
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
			$description = $request->input('description');
			$fee = $request->input('fee');
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
			$learning_objectives = $request->input('learning_objectives');
			$Instructional_method = $request->input('Instructional_method');
			$tag = $request->input('tag');
			$faq_1 = $request->input('faq_1');
			$faq_2 = $request->input('faq_2');
			$faq_3 = $request->input('faq_3');
			$faq_4 = $request->input('faq_4');
			$faq_5 = $request->input('faq_5');
			$created_at = Carbon::now();
						
			date_default_timezone_set($time_zone);
			$user_timestamp_start = strtotime($booking_start_time);
			date_default_timezone_set('UTC');
			$start_time = date("Y-m-d H:i:s", $user_timestamp_start);
			
			$recorded_date = date("Y-m-d", $user_timestamp_start);
			
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
			
			$documentsURL = '';
			if($documents != ''){
				$documentsSize = $documents->getSize();
				$documentsName = str_replace(' ','-',time().$documents->getClientOriginalName());
				$documentsExt = strtolower($documents->getClientOriginalExtension());
				$documentsAllowedExt = 'xyz,jpg,png,gif,psd,jpeg,bmp,pdf,doc,docx,xls,xlsx,ppt,pptx';
				if($documentsSize < 819200){ //800kb
					if(strpos($documentsAllowedExt,$documentsExt) == true){
						$documents->move($destinationPath,$documentsName);
						$documentsURL = $documentsName;
					}else{
						$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, xls, xlsx, pdf, doc, docx, xls, xlsx, ppt, pptx.'));
						return redirect()->back();
						$documentsURL = '';
					}
				}else{
					$request->session()->flash('error', __('Image size should be less than 800kb.'));
					return redirect()->back();
				}
			}
			
			
			$addArray = ['title'=>$title,
						'webinar_type'=>'live',
						'description'=>$description,
						'webinar_transcription'=>$webinar_transcription,
						'fee'=>$fee,
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
						'tag'=>$tag_id,
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
						'faq_1'=>$faq_1,
						'faq_2'=>$faq_2,
						'faq_3'=>$faq_3,
						'faq_4'=>$faq_4,
						'faq_5'=>$faq_5,
						'status'=>'inactive',
						'added_by'=>'admin',
						'created_at'=>$created_at,
						'created_by'=>Auth::guard('administrator')->user()->id,
						];
								
			$createdData = Webinar::create($addArray);
		    
			if($createdData){
                $request->session()->flash('success', __('Live webinar has been added successfully.'));
                return redirect()->route('live-webinar');
            }
            $request->session()->flash('error', __('Live webinar could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Live webinar could not be saved. Please, try again.'));
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
					return view('backEnd.live_webinars.edit', compact('webinar', 'statusList','subject_area_id','course_level_id','tag_id', 'courseLevel', 'subjectAria', 'tags', 'who_should_attend_array','userType'));
				}else{
					$request->session()->flash('error', __('Live webinar not available. Please, try again.'));
					return redirect()->route('live-webinar',$request->input('uri'));
				}
			}else{
				$request->session()->flash('error', __('Live webinar could not be load. Please, try again.'));
				return redirect()->route('live-webinar',$request->input('uri'));
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
						
			date_default_timezone_set($time_zone);
			$user_timestamp_start = strtotime($booking_start_time);
			date_default_timezone_set('UTC');
			$start_time = date("Y-m-d H:i:s", $user_timestamp_start);
			
			$recorded_date = date("Y-m-d", $user_timestamp_start);
			
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
			
			$webinarDoc	= Webinar::select('id','documents','image')->where('id','=',$id)->first();
			
			
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
					if($documentsSize < 819200) { //800kb
						if(strpos($documentsAllowedExt,$documentsExt) == true){
							//Delete old documents and store new documents
							$DeleteUrl = public_path('uploads/webinar_doc/'.$webinarDoc->documents);
							File::delete($DeleteUrl);
							//Store new file in syatem
							$documents->move($destinationPath,$documentsName);
							$documentsURL = $documentsName;
						}else{
							$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, psd, jpeg, bmp, xls,xlsx, pdf, doc , docx, xls, xlsx, ppt, pptx.'));
							return redirect()->back();
							$documentsURL = $webinarDoc->documents;
						}
					}else{
						$request->session()->flash('error', __('Image size should be less than 800kb.'));
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
						'learning_objectives'=>$learning_objectives,
						'Instructional_method'=>$Instructional_method,
						'documents'=>$documentsURL,
						'image' => $imageURL,
						'tag'=>$tag_id,
						'faq_1'=>$faq_1,
						'faq_2'=>$faq_2,
						'faq_3'=>$faq_3,
						'faq_4'=>$faq_4,
						'faq_5'=>$faq_5,
						'updated_at'=>$updated_at,
						'modified_by' => Auth::guard('administrator')->user()->id,
						];
			$updateData = Webinar::where('id',$id)->update($editArray);
		    if($updateData){
                $request->session()->flash('success', __('Live webinar has been update successfully.'));
                return redirect()->route('live-webinar',$request->input('uri'));
            }
            $request->session()->flash('error', __('Live webinar could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Live webinar could not be saved. Please, try again.'));
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
        try {
			if(is_numeric($id) && !empty($id)){
				$deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'modified_by' => Auth::guard('administrator')->user()->id];
				
				$delete = Webinar::where('id', '=', $id)->update($deleteArray);
				if($delete){
					$request->session()->flash('success', __('Live webinar has been deleted successfully.'));
				} else {
					$request->session()->flash('error', __('Live webinar can not be deleted. Please try again.'));
				}
				return redirect()->route('live-webinar',$request->input('uri'));
			}else{
				$request->session()->flash('error', __('Live webinar can not be deleted. Please try again.'));
				 return redirect()->route('live-webinar',$request->input('uri'));
			}	
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Live webinar can not be deleted. Please try again.'));
        }
    }
	
	
	/**
     * Remove the multiple data.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request){
        try {
            if (!empty($request->id)) {
                $webinar = Webinar::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                	]);
                if ($webinar) {

                    $data = ['success' => 'Live webinar has been deleted successfully.'];
                    
                   
                } else {
                    $data = ['error' => 'Live webinar can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Live webinar can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }
	
	
	
	
	/**
     * Create webinar in Live site.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
	public function createWebinar($id, $state, Request $request){
		//$code = $request->input('code');
		//$state = $request->input('state');
		if(!empty($id) && !empty($state)){
			//for getting token
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
				return redirect()->route('live-webinar',$request->input('uri'));
			} else {
				$decodeData = json_decode($result);
				if(!empty($decodeData) && !empty($decodeData->access_token) && !empty($decodeData->organizer_key)){
					$accessToken = $decodeData->access_token;
					$organizerKey = $decodeData->organizer_key;
					
					//get data for create webinar.
					$webinarData = Webinar::select('id','title','description','time_zone','start_time','end_time','webinar_key','created_by')->where('id','=',$id)->first();
					if(!empty($webinarData)){
						if($state == 'create'){
							$startTime = Carbon::parse($webinarData->start_time)->toW3cString();
							$endTime = Carbon::parse($webinarData->end_time)->toW3cString();
							
							//create a webinar for new user.
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/G2W/rest/organizers/".$organizerKey."/webinars");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"subject\": \"".$webinarData->title."\",\n  \"description\": \"".preg_replace('/[^A-Za-z0-9\-]/', ' ',(strip_tags(substr($webinarData->description,0,100))))."\",\n  \"times\": [\n    {\n      \"startTime\": \"".$startTime."\",\n      \"endTime\": \"".$endTime."\"\n    }\n  ],\n  \"timeZone\": \"".$webinarData->time_zone."\",\n  \"type\": \"single_session\",\n  \"isPasswordProtected\": false\n}");
							curl_setopt($ch, CURLOPT_POST, 1);
							
							$headers = array();
							$headers[] = "Content-Type: application/json";
							$headers[] = "Accept: application/json";
							$headers[] = "Authorization: ".$accessToken;
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							
							$webinarResult = curl_exec($ch);
							if (curl_errno($ch)) {
								$request->session()->flash('error', __(curl_error($ch)));
								return redirect()->route('live-webinar',$request->input('uri'));
							}else{
								$webinarCreateData = json_decode($webinarResult);
								//dd($webinarCreateData);
								if(!empty($webinarCreateData) && !empty($webinarCreateData->webinarKey)){
									$webinarKey = $webinarCreateData->webinarKey;
									Session::forget('mycpa_webinar_reason');
									//now update webinar key to webinar table
									$webinar = Webinar::where('id', $id)->update([
										'webinar_key' => $webinarKey,
										'webinar_response' => $webinarResult,
										'reason' => '',
										'status' => config('constants.STATUS.STATUS_ACTIVE'),
										'modified_by' => Auth::guard('administrator')->user()->id,
										'updated_at' => Carbon::now()
									 ]);
									 
									//now you have to create co-organizer for this webinar
									$getSpeakerDetail = Speakers::select('id','first_name','last_name','email')->where('id',$webinarData->created_by)->first();
									//dd($getSpeakerDetail);
									if(!empty($getSpeakerDetail)){
										$ch = curl_init();
									
										curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/G2W/rest/v2/organizers/".$organizerKey."/webinars/".$webinarKey."/coorganizers");
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
										curl_setopt($ch, CURLOPT_POSTFIELDS, "[\n  {\n    \"external\": true,\n    \"organizerKey\": \"".$organizerKey."\",\n    \"givenName\": \"".$getSpeakerDetail->first_name.' '.$getSpeakerDetail->last_name."\",\n    \"email\": \"".$getSpeakerDetail->email."\"\n  }\n]");
										curl_setopt($ch, CURLOPT_POST, 1);
										
										$headers = array();
										$headers[] = "Content-Type: application/json";
										$headers[] = "Accept: application/json";
										$headers[] = "Authorization: ".$accessToken;
										curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
										$coOrganizerResult = curl_exec($ch);
										
										if (curl_errno($ch)) {
											$request->session()->flash('error', __(curl_error($ch)));
											return redirect()->route('live-webinar',$request->input('uri'));
										}else{
											$coOrganizer = json_decode($coOrganizerResult);
											//now cretae new co-organizer for this webinar
											if(!empty($coOrganizer)){
												$createCoOrganizer = WebinarCoOrganizer::create([
																						'webinar_id' => $id,
																						'speaker_id' => $webinarData->created_by,
																						'memberKey' => $coOrganizer[0]->memberKey,
																						'surname' => $coOrganizer[0]->surname,
																						'givenName' => $coOrganizer[0]->givenName,
																						'joinLink' => $coOrganizer[0]->joinLink,
																						'email' => $coOrganizer[0]->email,
																						'status' => config('constants.STATUS.STATUS_ACTIVE'),
																						'created_by' => Auth::guard('administrator')->user()->id,
																						'created_at' => Carbon::now()
																					 ]);
											}else{
												$request->session()->flash('error', __('Opps...! Cant get data from webinar co-organizer.'));
											}
										}
										curl_close ($ch);	
									}else{
										$request->session()->flash('error', __('Thare was a some issue in cretae Co-organizers for this webinar.'));	
									}

									$request->session()->flash('success', __('Live webinar created successfully.'));
									return redirect()->route('live-webinar',$request->input('uri'));
								}else{
									$request->session()->flash('error', __('There was a some issue in create webinar error : '.$webinarCreateData->errorCode.' : '.$webinarCreateData->description.'. Please try again.'));
									return redirect()->route('live-webinar',$request->input('uri'));		
								}
							}
						
						}elseif($state == 'delete' || $state == 'inactive'){
							if(!empty($webinarData->webinar_key) && !empty($organizerKey)){
								//run curl to delete webinar
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/G2W/rest/organizers/".$organizerKey."/webinars/".$webinarData->webinar_key."?sendCancellationEmails=true");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
								
								$headers = array();
								$headers[] = "Accept: application/json";
								$headers[] = "Authorization: ".$accessToken;
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								$result = curl_exec($ch);
								$deleteWebinar = json_decode($result);
								//echo "<pre>"; print_r($deleteWebinar); exit;	
								if (curl_errno($ch)) {
									$request->session()->flash('error', __(curl_error($ch)));
									curl_close ($ch);
									return redirect()->route('live-webinar',$request->input('uri'));
								}else{
									//if get success result than delete webinar in database
									if(empty($deleteWebinar)){
										$reason = Session::get('mycpa_webinar_reason');
										Session::forget('mycpa_webinar_reason');
										
										$statusCode = $state == 'delete' ? 'STATUS_DELETE':'STATUS_INACTIVE';
										$webinar = Webinar::where('id', $id)->update([
											'webinar_key' => '',
											'webinar_response' => '',
											'reason' => $reason,
											'status' => config('constants.STATUS.'.$statusCode),
											'modified_by' => Auth::guard('administrator')->user()->id,
											'updated_at' => Carbon::now()
										 ]);
										$request->session()->flash('success', __('Live webinar '.$state.' successfully.'));
										return redirect()->route('live-webinar',$request->input('uri'));	
									}else{
										$request->session()->flash('error', __('There was a some issue in '.$state.' webinar error errorCode: '.$deleteWebinar->errorCode.' and description: '.$deleteWebinar->description.'. Please try again.'));
										return redirect()->route('live-webinar',$request->input('uri'));		
									}
								}
							}else{
								//if webinar alread delete than change status only
								$statusCode = $state == 'delete' ? 'STATUS_DELETE':'STATUS_INACTIVE';


								$reason = Session::get('mycpa_webinar_reason');
										  Session::forget('mycpa_webinar_reason');



								$webinar = Webinar::where('id', $id)->update([
											'webinar_key' => '',
											'webinar_response' => '',
											'reason' => $reason,
											'status' => config('constants.STATUS.'.$statusCode),
											'modified_by' => Auth::guard('administrator')->user()->id,
											'updated_at' => Carbon::now()
										 ]);
								
								$request->session()->flash('success', __('Live webinar '.$state.' successfully.'));
								return redirect()->route('live-webinar',$request->input('uri'));	
							}
						}
					}else{
						$request->session()->flash('error', __('No data found for create webinar. Please try again.'));
						return redirect()->route('live-webinar',$request->input('uri'));	
					}
				}else{
					$request->session()->flash('error', __('There was a some issue in getting token from webinar. Please try again.'));
					return redirect()->route('live-webinar',$request->input('uri'));	
				}
			}
		}else{
			$request->session()->flash('error', __('There was a some issue in getting code from webinar. Please try again.'));
			return redirect()->route('live-webinar',$request->input('uri'));	
		}
	}
	
	/**
	* View Live Webinars status 
	 * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	 
	public function view(Request $request, $id){

			$AcceptedSpeaker = SpeakerInvitation::select('speaker_invitation.id','speaker_invitation.webinar_id','speaker_invitation.speaker_id','speakers.first_name','speakers.last_name','speakers.email','speakers.contact_no','speakers.avatar','companies.name')
							->leftJoin('webinars','webinars.id','=','speaker_invitation.webinar_id')
							->leftJoin('speakers','speakers.id','=','webinars.created_by')
							->leftJoin('companies','companies.id','=','speakers.company_id')
							->where('speaker_invitation.webinar_id','=', $id)
							->where('speaker_invitation.status','=', 'accepted')
									->get();
		

		$LiveWebinarsView = Webinar::select('webinars.id','webinars.title','webinars.cpa_credit','webinars.fee','webinars.learning_objectives','webinars.Instructional_method','webinars.image','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone','webinars.reason')
									->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
									->leftJoin('courses','courses.course_level_id','=','course_levels.id')
									->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
									->leftjoin('speakers','speakers.id','=','webinars.created_by') 
									->leftJoin('tags','tags.id','=','webinars.tag')
									->where('webinars.id','=', $id)
									->first();
									//dd($SelfStudyWebinarsView);
		return view('backEnd.live_webinars.view', compact('LiveWebinarsView','AcceptedSpeaker'));
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

		$webinar_data = Webinar::select('id','created_by','title')->where('id',$id)->first();
		$speaker_id = $webinar_data['created_by'];
		$status = $request->input('status');

		$reason = $request->input('reason');
		$code = $request->input('code');
		Session::forget('mycpa_webinar_reason');

		if(!empty($id)){ 
			if($status == 'active' && empty($code)){
				Session::put('mycpa_webinar_reason', '');
				//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=create&redirect_uri='.env("HTTP_ADMIN_APP_URL").'live-webinar/webinars/create/'.$id;
				
				$notification_text = 'Your webinar has been accepted from the admin.';
				$link = 'webinar/view/'.encrypt($id); 

				$data = ['notification_text'=>$notification_text,
							'is_admin'=>'0',
							'user_id'=>$speaker_id,
							'created_at'=>Carbon::now(),
							'link'=>$link,
						];
				Notifications::insert($data);
				
				//create webinar
				$createWebinar = $this->createWebinar($id, 'create',  $request); 
				if($createWebinar){
					$request->session()->flash('success', __('Live webinar created successfully.'));
					return redirect()->route('live-webinar',$request->input('uri'));	
				}else{
					$request->session()->flash('error', __('Thare was a some issue in create live webinar.'));
					return redirect()->route('live-webinar',$request->input('uri'));
				}
				//return redirect($url);	
			}elseif($status == 'inactive' && empty($code)){
				Session::put('mycpa_webinar_reason', $reason);
				//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=inactive&redirect_uri='.env("HTTP_ADMIN_APP_URL").'live-webinar/webinars/create/'.$id;
				

				$notification_text = 'Your webinar has been disapproved from the admin. Please see the comments section or contact them directly. ';
				$link = 'webinar/view/'.encrypt($id); 

				$data = ['notification_text'=>$notification_text,
						'is_admin'=>'0',
						'user_id'=>$speaker_id,
						'created_at'=>Carbon::now(),
						'link'=>$link,
						];
				Notifications::insert($data);
				
				
				//delete webinar
				$inactiveWebinar = $this->createWebinar($id, 'inactive',  $request); 
				if($inactiveWebinar){
					$request->session()->flash('success', __('Live webinar Inactive successfully.'));
					return redirect()->route('live-webinar',$request->input('uri'));	
				}else{
					$request->session()->flash('error', __('Thare was a some issue in Inactive live webinar.'));
					return redirect()->route('live-webinar',$request->input('uri'));
				}
				
				//return redirect($url);
			}elseif($status == 'delete' && empty($code)){
				Session::put('mycpa_webinar_reason', $reason);
				//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=delete&redirect_uri='.env("HTTP_ADMIN_APP_URL").'live-webinar/webinars/create/'.$id;
				
				//delete webinar
				$deleteWebinar = $this->createWebinar($id, 'delete',  $request); 
				if($deleteWebinar){
					$request->session()->flash('success', __('Live webinar Delete successfully.'));
					return redirect()->route('live-webinar',$request->input('uri'));	
				}else{
					$request->session()->flash('error', __('Thare was a some issue in Delete live webinar.'));
					return redirect()->route('live-webinar',$request->input('uri'));
				}
				
				//return redirect($url);	
			}else{
				$request->session()->flash('error', __('There was a some issue on data. Please try again.'));
				return redirect()->route('live-webinar').$request->input('uri');	
			}
		}else{
			$request->session()->flash('error', __('There was a some issue on data. Please try again.'));
			return redirect()->route('live-webinar').$request->input('uri');		
		}
	}

}
