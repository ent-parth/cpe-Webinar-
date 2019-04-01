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
use App\Repositories\Tag;

use App\Repositories\WebinarUserRegister;
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

class WebinarPaymentHistoryController extends Controller{

    /**
     * Self Study Webinar Controller listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $webinar_user_register = WebinarUserRegister::select('webinars.fee','webinars.title','users.email','users.first_name','users.last_name','users.firm_name','webinar_user_register.id','webinar_user_register.webinar_id','webinar_user_register.webinar_type','webinar_user_register.payment_type', 'webinar_user_register.paid_amount','webinar_user_register.transection_id','webinar_user_register.start_time','webinar_user_register.end_time','webinar_user_register.created_at', 'webinar_user_register.updated_at', 'webinar_user_register.payment_status', 'webinar_user_register.join_url','webinar_user_register.registrant_key','webinar_user_register.registration_status','webinar_user_register.status')
													->leftJoin('users','webinar_user_register.user_id','=','users.id')
													->leftJoin('webinars','webinar_user_register.webinar_id','=','webinars.id') ;
        
         // For transection_id filter            
        $transection_id = $request->input('transection_id');
        if ($transection_id != '') {
            $webinar_user_register = $webinar_user_register->where('webinar_user_register.transection_id', '=', $transection_id);
        }
        

        // For webinar_type filter            
        $webinar_type = $request->input('webinar_type');
        if ($webinar_type != '' && $webinar_type !='Select Webinar Type') {
            $webinar_user_register = $webinar_user_register->where('webinar_user_register.webinar_type', '=', $webinar_type);
        }


         // For user name filter            
       
        if ($request->input('user_name') != '') {
            $usrsearchStr =  $request->input('user_name');
            $usrsearchStr = '%' . $usrsearchStr . '%';
            $webinar_user_register = $webinar_user_register->where('users.first_name', 'LIKE', $usrsearchStr)->orWhere('users.last_name', 'LIKE', $usrsearchStr);
        }

        // For text input filter
        if ($request->input('email') != '') {
            $emailsearchStr =  $request->input('email');
            $emailsearchStr = '%' . $emailsearchStr . '%';
            $webinar_user_register = $webinar_user_register->where('users.email', 'LIKE', $emailsearchStr);
        }

        // For webinar name filter
        if ($request->input('title') != '') {
            $searchStr =  $request->input('title');
            $searchStr = '%' . $searchStr . '%';
            $webinar_user_register = $webinar_user_register->where('webinars.title', 'LIKE', $searchStr);
        }

        // For payment date
        $created_at = $request->input('created_at');
        if ($created_at != '') {
            $webinar_user_register = $webinar_user_register->whereDate('webinar_user_register.created_at', '>=', $created_at);
        }
        
        $webinar_user_register = $webinar_user_register->where('payment_type','=','paid')->orderby('webinar_user_register.id', 'desc')->paginate(env('PAGINATION'));
        $webinar_user_register = $webinar_user_register->appends(request()->query());
       // echo "<pre>"; print_r($Self_Study_Webinars); exit;
        
        if ($request->ajax()) {
            return Response::json(View('backEnd/webinar-payment-history/index-ajax', compact('webinar_user_register'))->render());
        }
        
        return view('backEnd.webinar-payment-history.index', compact('webinar_user_register'));
    }
    
       
}
