<?php
namespace App\Http\Controllers\ComingSoon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\CompanyUser;
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
		return View('comingSoon.client.register', compact(''));
		
	}
	
	/**
     * Get registration store
     *
     * @param $request
     * @return view
     */
	 public function store(Request $request){
		$email = $request->input('email');
		$password = $request->input('password');
		$company_name = $request->input('company_name');
		$created_at = Carbon::now();
		
		$checkEmail = CompanyUser::where('email', 'LIKE', $email)->first();
		if(empty($checkEmail)){
			$value = ['email'=>$email,
					  'password'=>bcrypt($password),
					  'company_name'=>$company_name,
					  'status'=>'inactive',
					  'created_at'=>$created_at
					  ];
			$ClientDetails = CompanyUser::create($value);
			$clientID = $ClientDetails->id;
			$this->sendVerificationMail($clientID,$company_name,$email);
			
			Session::put('mycpa_message_success', 'Thank you for registering! Please check your email to confirm your registration.');
			return Redirect::back();
		}else{
			Session::put('mycpa_message_error', "Email already exists.");
			return Redirect::back();
		}
	 }
	 
	 
	 
	 /**
     * Send Email Verification for register user 
     * 
     * @param ID
     * 
     * @return email send   
     */
	 public function sendVerificationMail($id, $company_name, $email){
		 $clientID = encrypt($id);
		 $title = 'WELCOME TO '.env("SITE_NAME");
		 
		 $mailData = ['title'=>$title,
					 'subject'=>env("SITE_NAME").' - CONFIRM REGISTRATION',
					 'to'=>$email,
					 'company_name'=>$company_name,
					 'string'=>$clientID ];
						
		Mail::send('comingSoon.emails.register-confirmation', $mailData , function ($message) use ($mailData){
			$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
			$message->to($mailData['to']);
			$message->subject($mailData['subject']);	
		});
		return response()->json(['message' => 'Mail sent successfully']);
	 }
	
	
	

	/**
     * Post After Registration Email Verification 
     * 
     * @param ID
     * 
     * @return email send   
     */
	 public function confirm($string){
	 	$clientID = decrypt($string);
		if(!empty($clientID) && is_numeric($clientID)){
			$checkUser = CompanyUser::where('id','=',$clientID)->where('status','=','active')->first();
			if(empty($checkUser)){
				$valueToClient = ['status'=>'active'];
				$client = CompanyUser::findOrFail($clientID);
				$client->update($valueToClient);
				Session::put('mycpa_message_success', 'Registration confirmed, please login.');
				return Redirect(env('COMPANY_URL').'/login?message=Registration confirmed, Please login.');
			}else{
				Session::put('mycpa_message_warning', 'Registration already confirmed.');
			}
			return Redirect('comingsoon-register');
		}else{
			Session::put('mycpa_message_error', 'Thare was a some issue in Registration.');
			return Redirect('/');
		}
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
