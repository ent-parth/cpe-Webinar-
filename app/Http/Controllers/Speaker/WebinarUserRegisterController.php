<?php
namespace App\Http\Controllers\Speaker;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\WebinarRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\WebinarUserRegister;
use App\Repositories\Users;
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

class WebinarUserRegisterController extends Controller{
    /**
     * WebinarUserRegisterController listing
     *
     * @var string
     */
	public function index(Request $request){
		$createdBy = Auth::guard('speaker')->user()->id;
		
		$WebinarUserRegister = WebinarUserRegister::select('webinar_user_register.id','webinar_user_register.webinar_id','webinar_user_register.user_id','webinar_user_register.webinar_type','webinar_user_register.paid_amount','webinar_user_register.transection_id','webinar_user_register.start_time','webinar_user_register.end_time','webinar_user_register.updated_at','webinar_user_register.created_at','webinar_user_register.payment_status','webinar_user_register.join_url','webinar_user_register.registrant_key','webinar_user_register.registration_status','webinar_user_register.status','webinars.title','users.first_name','users.last_name','users.email','webinars.title','webinars.webinar_type','webinars.fee','webinars.recorded_date','webinars.created_by','webinars.time_zone')
													->leftJoin('webinars','webinars.id','=','webinar_user_register.webinar_id')
													->leftJoin('users','users.id','=','webinar_user_register.user_id');
		// For Registartion status filter			
        $status = $request->input('status');
        if ($status != '') {
        	$WebinarUserRegister = $WebinarUserRegister->where('webinar_user_register.status', '=', $status);
        }else{
			$WebinarUserRegister = $WebinarUserRegister->where('webinar_user_register.status', '!=', 'delete');
		}
		
		// For recorded date filter
        if ($request->input('recorded_date') != '' ) { 
            $recorded_date = date('Y-m-d', strtotime($request->input('recorded_date')));
            $WebinarUserRegister = $WebinarUserRegister->where("webinars.recorded_date", '>=', $recorded_date);
        }
       
		// For created date filter
        if ($request->input('created_at') != '') { 
            $created_at = date('Y-m-d', strtotime($request->input('created_at')));
			$WebinarUserRegister = $WebinarUserRegister->whereRaw('date(webinar_user_register.created_at) = ?', [$created_at]);
        }

		// For email filter
		$email = $request->input('email');
        if ($email != '') {
			$email = '%' . $email . '%';
        	$WebinarUserRegister = $WebinarUserRegister->where('users.email', 'LIKE', $email);
        }
		// For Webinar name filter
		$title = $request->input('title');
        if ($title != '') {
			$title = '%' . $title . '%';
        	$WebinarUserRegister = $WebinarUserRegister->where('webinars.title', 'LIKE', $title);
        }
		// For Webinar type filter
		$webinar_type = $request->input('webinar_type');
        if ($webinar_type != '') {
        	$WebinarUserRegister = $WebinarUserRegister->where('webinars.webinar_type', '=', $webinar_type);
        }
		
        // For text input filter
        if ($request->input('name') != '') {
			$searchStr =  $request->input('name');
			$searchStr = '%' . $searchStr . '%';
		    $WebinarUserRegister = $WebinarUserRegister->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', $searchStr);
		 } 
		
		$WebinarUserRegister = $WebinarUserRegister->where('webinars.created_by','=',$createdBy)->orderby('webinar_user_register.id', 'desc')->paginate(env('PAGINATION'));
		$WebinarUserRegister =	$WebinarUserRegister->appends(request()->query());
		//echo "<pre>"; print_r($webinar_user_register); exit;
		
		$statusList = StatusHelper::getStatusesList();

		
		if ($request->ajax()) {
			return Response::json(View('speaker/webinar-user-register/index-ajax', compact('WebinarUserRegister','statusList'))->render());
		}
		
        return view('speaker.webinar-user-register.index', compact('WebinarUserRegister','statusList'));
    }
}