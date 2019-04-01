<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\Courses;
use App\Repositories\WebinarUserRegister;
use App\Repositories\Series;
use App\Repositories\Speakers;
use App\Repositories\WebinarCoOrganizer;
use App\Repositories\SpeakerInvitation;
use App\Repositories\Tag;
use App\Repositories\Users;
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
		Session::forget('query_string');
		$WebinarUserRegister = WebinarUserRegister::select('webinar_user_register.id','webinar_user_register.webinar_id','webinar_user_register.user_id','webinar_user_register.webinar_type','webinar_user_register.paid_amount','webinar_user_register.transection_id','webinar_user_register.start_time','webinar_user_register.end_time','webinar_user_register.updated_at','webinar_user_register.created_at','webinar_user_register.payment_status','webinar_user_register.join_url','webinar_user_register.registrant_key','webinar_user_register.registration_status','webinar_user_register.status','webinars.title','users.first_name','users.last_name','users.email','webinars.title','webinars.webinar_type','webinars.fee','webinars.recorded_date')
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
		
		$WebinarUserRegister = $WebinarUserRegister->orderby('webinar_user_register.id', 'desc')->paginate(env('PAGINATION'));
		$WebinarUserRegister =	$WebinarUserRegister->appends(request()->query());
		//echo "<pre>"; print_r($webinar_user_register); exit;
		
		$statusList = StatusHelper::getStatusesList();

		
		if ($request->ajax()) {
			return Response::json(View('backEnd/webinar-user-register/index-ajax', compact('WebinarUserRegister','statusList'))->render());
		}
		
        return view('backEnd.webinar-user-register.index', compact('WebinarUserRegister','statusList'));
    }
	
	
	/**
	* Add attendees for webinar.
	* @param $id //webinar_id
    * @return value
    * @throws NotFoundException
    */
	public function addAttendees($id,Request $request) {
		$queryString = $request->getQueryString();
		Session::put('query_string',$queryString); //store query in session
		if(!empty($id)){
			$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=create&redirect_uri='.env("APP_ADMIN_URL").'/webinar-user-register-attendees/'.$id;
			return redirect($url);
		}else{
			$request->session()->flash('error', __('Your enter webinar detail are wrong, please try again.'));
			return redirect()->route('webinar-user-register',$queryString);	
		}
	}
	
	
	/**
	* Create new attendees for webinar.
	 * @param $id //webinar_id
     * @return value
     * @throws NotFoundException
     */
	 public function CreateAttendees($id,Request $request) {
		$code = $request->input('code');
		$state = $request->input('state');
		
		if(!empty($id) && !empty($code) && !empty($state)){
			//for getting token
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/oauth/v2/token");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=".$code."&state=".$state."&redirect_uri=".env("APP_ADMIN_URL")."/webinar-user-register-attendees/".$id);
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$headers = array();
			$headers[] = "Authorization: Basic ".env("WEBINAR_BASE_64_AUTHORIZATION_KEY");
			$headers[] = "Accept: application/json";
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				$request->session()->flash('error', __(curl_error($ch)));
				return redirect()->route('webinar-user-register',Session::get('query_string'));	
			}else{
				$decodeData = json_decode($result);
				//dd($decodeData);
				if(!empty($decodeData) && !empty($decodeData->access_token) && !empty($decodeData->organizer_key)){
					$accessToken = $decodeData->access_token;
					$organizerKey = $decodeData->organizer_key;
					//get webinar register detail
					$webinarRegisterData = WebinarUserRegister::where('id','=',$id)->where('status','=','inactive')->first();
					if(!empty($webinarRegisterData)){
						//get webinar Detail
						$webinarData = Webinar::select('id','title','start_time','end_time','webinar_key','created_by')->where('id','=',$webinarRegisterData->webinar_id)->where('status','=','active')->first();
						if(!empty($webinarData)){
							//get login user data
							$userData = Users::Select('users.id','users.first_name','users.last_name','users.email','users.contact_no','users.firm_name','users.zipcode','countries.name as CountryName','states.name as StateName','cities.name as CityName')
												->leftJoin('countries','countries.id','=','users.country_id')
												->leftJoin('states','states.id','=','users.state_id')
												->leftJoin('cities','cities.id','=','users.city_id')
												->where('users.id', '=', $webinarRegisterData->user_id)
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
								$queryString  = $request->input('query_string');
								if (curl_errno($ch)) {
									$request->session()->flash('error', __('Thare was a some error come at register time, Error: '.curl_error($ch)));
									return redirect()->route('webinar-user-register',Session::get('query_string'));	
								}else{
									$decodeAttendees = json_decode($result);
									if(isset($decodeAttendees->errorCode)){
										$request->session()->flash('error', __('Thare was a some issue in attenddes register, Error #: '.$decodeAttendees->errorCode.' and Description #'.$decodeAttendees->description));
										return redirect()->route('webinar-user-register',Session::get('query_string'));
									}else{
										$updateAttenddes = ['join_url'=>$decodeAttendees->joinUrl,
															'registrant_key'=>$decodeAttendees->registrantKey,
															'registration_status'=>$decodeAttendees->status,
															'status'=>'active',
															'updated_at'=>Carbon::now()];
										$updateAttenddes = WebinarUserRegister::where('id',$id)->update($updateAttenddes);
										$request->session()->flash('success', __('Attendees registered successfully.'));
										return redirect()->route('webinar-user-register',Session::get('query_string'));
									}
								}
								curl_close ($ch);
							}else{
								$request->session()->flash('error', __('Sorry we cant find this user detail, please login and try again.'));
								return redirect()->route('webinar-user-register',Session::get('query_string'));
							}
						}else{
							$request->session()->flash('error', __('Sorry we cant find this webinar, please try again.'));
							return redirect()->route('webinar-user-register',Session::get('query_string'));
						}
					}else{
						$request->session()->flash('error', __('Can not find webinar register detail. Please try again.'));
						return redirect()->route('webinar-user-register',Session::get('query_string'));
					}
				}else{
					$request->session()->flash('error', __('There was a some issue in getting token from webinar. Please try again.'));
					return redirect()->route('webinar-user-register',Session::get('query_string'));
				}
			}
		}else{
			$request->session()->flash('error', __('There was a some issue in getting code from webinar. Please try again.'));
			return redirect()->route('webinar-user-register',Session::get('query_string'));
		}	
	 }
	
}
