<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use App\Repositories\Courses;
use App\Repositories\Companies;
use App\Repositories\Tag;
use App\Repositories\Webinar;
use App\Repositories\WebinarUserRegister;

class IndexController extends Controller{
    
	/**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(Request $request){
    	 $subjectAria = Courses::select('id', 'name','course_level_id')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
		 
		 $tagLists = Tag::select('id', 'tag')
                            ->where('status','=','active')
                            ->orderBy('tag', 'ASC')
                            ->get();
												
         $companies = Companies::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();
							
		$current = Carbon::now();
		$webinars = Webinar::select('webinars.id','webinars.view_count','webinars.title', 'webinars.description', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at','webinars.cpa_credit','speakers.first_name','speakers.last_name','companies.name as CompanyName','webinar_like.id as liked') 
                             ->leftJoin('speakers','speakers.id','=','webinars.created_by')
                             ->leftJoin('companies','companies.id','=','speakers.company_id')
							 ->leftJoin('webinar_like','webinars.id','=','webinar_like.webinar_id')					
							 ->where('start_time', '>=', $current)
							 ->where('webinars.status', '=', 'active')
							 ->where('webinars.webinar_type', '=', 'live')
							 ->orderBy('id','desc')
							 ->limit(16)
							 ->get();
		
		$seflStudyWebinars = Webinar::select('webinars.id','webinars.view_count','webinars.title', 'webinars.description', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at','webinars.cpa_credit','speakers.first_name','speakers.last_name','companies.name as CompanyName','webinar_like.id as liked') 
                             ->leftJoin('speakers','speakers.id','=','webinars.created_by')
                             ->leftJoin('companies','companies.id','=','speakers.company_id')
							 ->leftJoin('webinar_like','webinars.id','=','webinar_like.webinar_id')
							 ->where('webinars.status', '=', 'active')
							 ->where('webinars.webinar_type', '=', 'self_study')
							 ->orderBy('id','desc')
							 ->limit(16)
							 ->get();
		$webinarRegisters = WebinarUserRegister::where('user_id',Session::get('mycpa_client_id'))->where('payment_status','success')->get();
		$webinarArray = [];
		foreach($webinarRegisters as $webinarRegister){
			//$webinarArray[][$webinarRegister->user_id] = $webinarRegister->webinar_id;
			$webinarArray[] = $webinarRegister->webinar_id;	
		}					
        return view('user.index.index',compact('subjectAria','companies','tagLists','webinars','seflStudyWebinars','webinarArray'));
  	}
}
