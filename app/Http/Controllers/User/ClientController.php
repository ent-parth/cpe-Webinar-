<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Tag;
use App\Repositories\Users;
use App\Repositories\UserType;
use App\Repositories\TagUser;
use App\Repositories\UserPasswordReset;
use App\Repositories\Cities;
use App\Repositories\Countries;
use App\Repositories\States;
use App\Models\User;
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
use Hash;
use Illuminate\Support\Facades\URL;

class ClientController extends Controller
{
	
	/**
     * Get registration view
     *
     * @param $request
     * @return view
     */

	public function register(Request $request) {
		$user_type = UserType::select('id','name')->get();
		$tag = Tag::select('id','tag')->get();


		$Countries = Countries::select('id', 'name')
							->where('status','=','active')
							->orderBy('name', 'ASC')
							->get();
		$States = States::select('id', 'name','country_id')
							->where('status','=','active')
							->orderBy('name', 'ASC')
							->get();
		$Cities = Cities::select('id', 'name','country_id','state_id')
							->where('status','=','active')
							->orderBy('name', 'ASC')
							->get();
		if (strpos(URL::previous(), 'register') === false) {					
			Session::put('redirect_url', URL::previous());
		}
		return View('user.client.register', compact('user_type','tag','Countries','States','Cities'));
		
	}
	
	/**
     * Get registration store
     *
     * @param $request
     * @return view
     */
	 public function store(Request $request){
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$contact_no = $request->input('contact_no');
		$email = $request->input('email');
		$firm_name = $request->input('firm_name');
		$password = $request->input('password');
		$user_type_id = $request->input('user_type_id');
		$tag =  $request->input('tag');

		$time_zone = $request->input('time_zone');
		$country_id = $request->input('country_id');
		$state_id = $request->input('state_id');
		$city_id = $request->input('city_id');
		
		$created_at = Carbon::now();
		
		$checkEmail = Users::where('email', 'LIKE', $email)->first();
		
		if(empty($checkEmail)){
			$value = ['first_name'=>$first_name,
					  'last_name'=>$last_name,
					  'contact_no'=>$contact_no,
					  'email'=>$email,
					  'firm_name'=>$firm_name,
					  'password'=>bcrypt($password),
					  'user_type_id'=>$user_type_id,
					  'time_zone'=>$time_zone,
					  'country_id'=>$country_id,
					  'state_id'=>$state_id,
					  'city_id'=>$city_id,
					  'status'=>'inactive',
					  'created_at'=>$created_at
					  ];
			$ClientDetails = Users::create($value);
			$clientID = $ClientDetails->id;
			
			foreach ($tag  as $tag_id) {
				$tag_value = [
					'user_id'=>$clientID,
					  'tag_id'=>$tag_id,
					  'created_at'=>$created_at,
					  ];
					$TagUserDetail = TagUser::create($tag_value);
				# code...
			}
			$this->sendVerificationMail($clientID,$first_name,$email);


		//These session messages are not displaying while submitting form  -- remaining --
			Session::put('mycpa_message_success', 'Thank you for registering! Please check your email to confirm your registration.');
			return Redirect::back();
		
		}else{
			
			Session::put('mycpa_message_error', "Email already exists.");
			return Redirect::back();
		}
			
	 }
	
	
    /**
	* Login View Create
     *
     * @param $request
     * 
     * @return view
     */ 
    public function login(Request $request)
    {
        return view('user.client.login');

    }
	
	/**
	* store Login details
     *
     * @param $request
     * 
     * @return view
    */
	
	public function check(Request $request){
		$email	= $request->input('email');
		$password	= $request->input('password');
		if(!empty($email) && !empty($password)){
			$check = Users::where('email', 'LIKE', $email)->where('status','=','active')->first();
			if(!empty($check)){ //echo 'eeee';exit;
				if(Hash::check($request->input('password'), $check->password)){ //sucess login
					Session::put('mycpa_client_id', $check->id); 
					Session::put('mycpa_client_first_name', $check->first_name);
					Session::put('mycpa_client_last_name', $check->last_name);
					Session::put('mycpa_client_contact_no', $check->contact_no); 
					Session::put('mycpa_client_email', $check->email);
					Session::put('mycpa_client_firm_name', $check->firm_name);
					Session::put('mycpa_client_user_type_id', $check->user_type_id);
					Session::put('mycpa_client_country_id', $check->country_id);
					Session::put('mycpa_client_state_id', $check->state_id);
					Session::put('mycpa_client_city_id', $check->city_id);
					Session::put('mycpa_client_time_zone', $check->time_zone);
    				Session::put('mycpa_message_success', "Login Success.");
					if(!empty(Session::get('redirect_url'))) {
						$redirect_url = Session::get('redirect_url');
					} else {
						$redirect_url = '/';
					}
					return Redirect($redirect_url); ///sucess
				}else{
					Session::put('mycpa_message_warning', "Please Enter Valid Password.");
					return Redirect('register'); //wrong passwod
				}
			}else{
					Session::put('mycpa_message_warning', "Invalid Email or Inactive Email.");
					return Redirect('/register');
				}
		}else{ 
			Session::put('mycpa_message_warning', "Please Enter Email and Passsword.");
			return Redirect('register');
	 	}
	
	}	
	
	/**
     * Get Client Forgot Password Form 
     *
     * @param $request
     * 
     * @return view
     */
    public function forgotpassword(Request $request) {
		return view('user.client.forgot-password');      
    }   
    

	/**
     * Get After Registration Email Verification 
     * 
     * @param Email
     * 
     * @return email send   
     */
    public function resetpassword(Request $request) {
        $email = $request->input('email');
        $checkUser = Users::where('email','LIKE',$email)->where('status','active')->first();
        //dd($checkUser);
        if(!empty($checkUser)){
            $title = 'Forgot Password';
			if($checkUser->password == ''){
				Session::put('mycpa_message_error', 'Opps..!, There is no password.');
				return Redirect::back(); 
			}else{
				//$password = CommonHelper::decrypt($checkUser->password);
				$urlLink = encrypt($email);
				
				//add entry in password reset table
				$passValue = ['email'=>$checkUser->email,
								'token'=>$urlLink,
								'created_at'=>Carbon::now(),
							  ];
				$addPassValue = UserPasswordReset::create($passValue);
			}
			
            $mailData = ['title' => $title,
                        'name'=>$checkUser->first_name,
                        'subject'   => env("SITE_NAME").' - Forgot Password',
                        'to'=> $email,
                        'url_link'=>$urlLink];
        	Mail::send('user.emails.send-password', $mailData , function ($message) use ($mailData){
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($mailData['to']);
                $message->subject($mailData['subject']);
            });
			
			Session::put('mycpa_message_success', 'Please check your mail inbox for your password!');
			return Redirect('/'); 
		}else{
			Session::put('mycpa_message_error', 'User not Exist OR Inactive. Please Check!');
			return Redirect::back(); 
		}
    }
	
	
	/**
     * Get update user password 
     * 
     * @param Email
     * 
     * @return email send   
     */
    public function userPasswordReset(Request $request,$url_link){
		if(!empty($url_link)){
			$encEmail = $url_link;
			$email = decrypt($url_link);
			//check if this email is valid or not
			$getData = UserPasswordReset::where('email','LIKE',$email)->orderBy('id','DESC')->first();
			if(!empty($getData)){
				$hourdiff = (strtotime(Carbon::now()) - strtotime($getData->created_at))/3600;
				if($hourdiff < 0 || $hourdiff > 24) {
					Session::put('mycpa_message_error', 'Your password change link are expired. please try again');
					return Redirect('register');	
				}else{
					return view('user.client.change-password',compact('encEmail'));     		
				}
    		}else{
				Session::put('mycpa_message_error', 'Your email is not valid.');
				return Redirect('/');		
			}
		}else{
			Session::put('mycpa_message_error', 'Please select valid data.');
			return Redirect('/'); 
		}
	}
	
	
	/**
     * post update user password 
     * 
     * @param Email
     * 
     * @return email send   
     */
    public function updateUserPassword(Request $request){
		$password = $request->input('password');
		$email = decrypt($request->input('data'));
		$getData = Users::where('email','LIKE',$email)->where('status','active')->first();
		if(!empty($getData)){
			$updateData = ['password'=>bcrypt($password),];
			$userUpdate = Users::where('id',$getData->id)->update($updateData);	
			Session::put('mycpa_message_success', 'Your password update succesfully');
			return Redirect('/');
		}else{
			Session::put('mycpa_message_error', 'something went wrong, please try again');
			return Redirect('/');	
		}
	}
	
	

	/**
     * Post After Registration Email Verification 
     * 
     * @param ID
     * 
     * @return email send   
     */
	 public function confirm($user_data){
	 	$clientID = decrypt($user_data);
		if(!empty($clientID) && is_numeric($clientID)){
			$checkUser = Users::where('id','=',$clientID)->where('status','=','active')->first();
			if(empty($checkUser)){
				$valueToClient = ['status'=>'active'];
				$client = Users::findOrFail($clientID);
				$client->update($valueToClient);
				Session::put('mycpa_message_success', 'Registration confirmed, please login.');
			}else{
				Session::put('mycpa_message_warning', 'Registration already confirmed.');
			}
			return Redirect('register');
		}else{
			Session::put('mycpa_message_error', 'Thare was a some issue in Registration.');
			return Redirect('/');
		}
	}
	/* Confermation mail send */
	 public function sendVerificationMail($id, $name, $email){
		 $clientID = encrypt($id);
		 $title = 'WELCOME TO '.env("SITE_NAME");
		 
		 $mailData = ['title'=>$title,
		 				'name'=>$name,
						'subject'=>env("SITE_NAME").' - CONFIRM REGISTRATION',
						'to'=>$email,
						'id'=>$clientID ];
						
		Mail::send('user.emails.register-confirmation', $mailData , function ($message) use ($mailData){
			$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
			$message->to($mailData['to']);
			$message->subject($mailData['subject']);	
		});
		return response()->json(['message' => 'Mail sent successfully']);
	 }
	 
	 
	 /**
     * Get Client logout 
     *
     * @param $request
     * 
     * @return view
     */
    public function logout(Request $request) {
        if(!empty(Session::get('mycpa_client_id'))):
            Session::flush();
        endif;
        return Redirect()->route('user.index');
    } 
}
