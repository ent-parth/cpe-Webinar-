<?php

namespace App\Http\Controllers\CompanyAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Repositories\CompanyPasswordReset;
use App\Repositories\CompanyUser;
use App\Models\Companies;
use Session;
use Carbon\Carbon;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

	use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     * Add the Speakers auth
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company-guest');
    }

    /**
     * Define the password broker for reset the password
     * 
     * @return type
     */
    public function broker()
    {
        return Password::broker('company');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {	config(['app.name' => 'Company Forgot password | Forgot Password']);

        return view('backEnd.auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {	
        $this->validateEmail($request);
		
        $companyStatus = Companies::select('status','name')->active()->where('email', '=', $request->email)->first();
        // dd($companyStatus);
		Session::put('email', $request->email);
        if(empty($companyStatus)) {
			return back()->with('status', __('Your email is block, Please contact to administrator.'));
        }
		
		
		//custom code to manage entry in database
		$urlLink = encrypt($request->email);
		
		//add entry in password reset table
		$passValue = ['email'=>$request->email,
					  'token'=>$urlLink,
					  'created_at'=>Carbon::now(),
					  ];
		$addPassValue = CompanyPasswordReset::create($passValue);
		
		$mailData = ['title' => 'Forgot Password',
					'name'=> $companyStatus->name != '' ? $companyStatus->name : 'user',
					'subject'   => env("SITE_NAME").' - Forgot Password',
					'to'=> $request->email,
					'url_link'=>$urlLink];
		Mail::send('company.emails.send-password', $mailData , function ($message) use ($mailData){
			$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
			$message->to($mailData['to']);
			$message->subject($mailData['subject']);
		});
		$request->session()->flash('success', 'Please check your mail inbox for your password!');
		return back()->with('status', __('Please check your mail inbox for your password!')); 
		
		// We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        //$response = $this->broker()->sendResetLink($request->only('email'));
		//dd($request->only('email'));
		
		
        //return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($request, $response) : $this->sendResetLinkFailedResponse($request, $response);
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
			$getData = CompanyPasswordReset::where('email','LIKE',$email)->orderBy('id','DESC')->first();
			if(!empty($getData)){
				$hourdiff = (strtotime(Carbon::now()) - strtotime($getData->created_at))/3600;
				if($hourdiff < 0 || $hourdiff > 24) {
					$request->session()->flash('error', 'Your password change link are expired. please try again');
					return Redirect('forgot-password');	
				}else{
					return view('company.auth.passwords.change-password',compact('encEmail'));     		
				}
    		}else{
				$request->session()->flash('error', 'Your email is not valid.');
				return Redirect('forgot-password');	
			}
		}else{
			$request->session()->flash('error', 'Please select valid data.');
			return Redirect('forgot-password');	
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
		$getData = CompanyUser::where('email','LIKE',$email)->where('status','active')->first();
		if(!empty($getData)){
			$updateData = ['password'=>bcrypt($password),];
			$userUpdate = CompanyUser::where('id',$getData->id)->update($updateData);	
			$request->session()->flash('success', 'Your password update succesfully.');
			return Redirect('login');	
		}else{
			$request->session()->flash('error', 'something went wrong, please try again.');
			return Redirect('login');	
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        $request->session()->flash('success', 'We have e-mailed your password reset link!');

        return redirect()->route('show-admin-login-form');
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $request->session()->flash('error', 'Your password reset link does not sent.');

        return redirect()->route('company.email.reset.form');
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request){
        $this->validate($request, ['email' => 'required|email'], ['email.required' => 'Please enter email.','email.email' => 'Please enter valid email.']);
    }

    /**
     * Check the active email
     * 
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function checkEmail(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $data = Companies::active()->where('email', '=', $request->email)->get();
        $flag = ($data->count() > 0) ? 'true' : 'false';

        return $flag;
    }
}
