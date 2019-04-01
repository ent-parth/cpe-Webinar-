<?php
namespace App\Http\Controllers\ComingSoon;
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
use App\Repositories\Webinar;
use App\Repositories\Companies;
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
        $companies = Companies::select('id', 'name')
                            ->where('status','=','active')
                            ->orderBy('name', 'ASC')
                            ->get();

        $webinars = Webinar::select('webinars.id','webinars.view_count','webinars.title', 'webinars.description', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at','webinars.cpa_credit','speakers.first_name','speakers.last_name','companies.name','webinar_like.id as liked') 
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
        return view('comingSoon.index.index',compact('webinars','subjectAria','companies','webinarArray'));
  	}
}
