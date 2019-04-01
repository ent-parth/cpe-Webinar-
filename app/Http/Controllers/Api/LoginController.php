<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LogoutRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;
//use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\UserPasswordReset;
use App\Models\Device;
use Mail;
use Illuminate\html;
use Carbon\Carbon;


class LoginController extends Controller
{

    /**
     * Define the Administrator auth
     * 
     * @return type
     */
    protected function guard()
    {
        return Auth::guard('api');
    }
    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    public function login(LoginRequest $request)
    {
        try {
            $input = $request->only('email', 'password');
            $input['status'] = config('constants.ADMIN_CONST.STATUS_ACTIVE');


            if (auth('api')->validate($this->credentials($request))) {
                $user = auth('api')->getLastAttempted();
            }
            if (isset($user->status) && $user->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $jwtToken = auth('api')->attempt($input);
                $requestData = $request->all();
                unset($requestData['email']);
                unset($requestData['password']);
                $requestData['user_id'] = auth('api')->user()->id;
                $requestData['is_login'] = config('constants.USER.LOGIN');
                Device::updateOrCreate(
                    ['user_id' => auth('api')->user()->id,
                    'device_id' => $request->device_id, 'device_token' => $request->device_token
                        ], $requestData);

                $user = User::notDeleted()->select('users.id', 'first_name', 'last_name', 'email', 'contact_no', 'firm_name', 'country_id', 'state_id', 'city_id', 'zipcode', 'user_type_id', 'designation', 'ptin_number', 'credit')
                            ->with('tags:tags.id,tag', 'country:id,name', 'state:id,name', 'city:id,name', 'userType:id,name')
                            ->where('id', '=', auth('api')->user()->id)
                            ->first()->toArray();
                if (!empty($user)) {
                    foreach($user as $key => $row) {
                        $user[$key] = !empty($row) ? $row : "";
                    }
                }
                $user['country'] = !empty($user['country']['name']) ? $user['country']['name'] : "";
                $user['state'] = !empty($user['state']['name']) ? $user['state']['name'] : "";
                $user['city'] = !empty($user['city']['name']) ? $user['city']['name'] : "";
                $user['user_type'] = !empty($user['user_type']['name']) ? $user['user_type']['name'] : "";
                if (!empty($user['tags'])) {
                    foreach ($user['tags'] as $key => $tag) {
                        unset($user['tags'][$key]['pivot']);
                    }
                }
                $user['token'] = $jwtToken;
                $user['tags'] = !empty($user['tags']) ? $user['tags'] : [];

                return $this->APIResponse->respondWithMessageAndPayload($user, 'Login Successfully');
            } else if (isset($user->status) && $user->status == config('constants.STATUS.STATUS_INACTIVE')) {
                return $this->APIResponse->respondUnauthorized(__('Please activate your account.'));
            } else {
                return $this->APIResponse->respondUnauthorized(__('Invalid login details.'));
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Check the active data
     * 
     * @param Request $request
     * @return type
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only('email', 'password'));
    }
    /**
     * Register the customer
     * 
     * @param Request $request
     * @return type
     */
    public function register(RegisterRequest $request)
    {
        try {
            //$client = new \App\Http\Controller\User\ClientController();
            //exit;
            $requestData = $request->all();
            $requestData['status'] ='inactive';
            $user = User::Create($requestData);
            $tags = $request->tags;
            if (empty($tags)) {
                $tags = [];
            }
            $user->tags()->sync($tags);
            if ($user) {
                // $user['user_type'] = \App\Helpers\UserTypeHelper::getUserType($user['user_type']);
                //$client = new User\ClientController();
                app('App\Http\Controllers\User\ClientController')->sendVerificationMail($user->id, $user->first_name, $user->email);
                return $this->APIResponse->respondWithMessageAndPayload([
                            'user' => $user,
                            ], "Registration has been successfully.");
            }else{
                return $this->APIResponse->respondResourceConflict('Registration has been not successfully.');
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Logout the customer
     * 
     * @param Request $request
     * @return type
     */
    public function logout(LogoutRequest $request)
    {
        try {
            $deviceId = !empty($request->device_id) ? $request->device_id : '';
            $deviceToken = !empty($request->device_token) ? $request->device_token : '';
            $deviceUpdate = Device::where('user_id', '=', auth('api')->user()->id)
                    ->where('device_id', '=', $deviceId)
                    ->where('device_token', '=', $deviceToken)
                    ->where('is_login', '=', config('constants.USER.LOGIN'))
                    ->update(['is_login' => config('constants.USER.LOGOUT')]);
        
            if ($deviceUpdate) {
                return $this->APIResponse->respondWithMessage(__('Logout Successfully'));
            }

            return $this->APIResponse->respondUnauthorized(__('Logout Failed'));
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Change the password
     * 
     * @param ChangePasswordRequest $request
     * @return type
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            if (!empty($request->new_password) && !empty($request->current_password)) {
                if (Hash::check($request->current_password, auth('api')->user()->password)) {
                    $changePassword = auth('api')->user()->update(['password' => $request->new_password]);
                    if ($changePassword) {
                        return $this->APIResponse->respondWithMessage(__('Password has been changed successfully.'));
                    }
                } else {
                    return $this->APIResponse->respondUnauthorized(__('current password is wrong.'));                    
                }
            }

            return $this->APIResponse->respondUnauthorized(__('Password has been not changed successfully.'));
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Get Email for forgot password 
     * 
     * @param Email
     * 
     * @return email send   
     */

    public function resetPassword(Request $request) {
        $email = $request->input('email');
        $checkUser = User::where('email','LIKE',$email)->notDeleted()->first();
        if(!empty($checkUser)) {
            $title = 'Forgot Password';
            
            $urlLink = encrypt($email);
            
            //add entry in password reset table
            $passValue = ['email'=>$checkUser->email,
                            'token'=>$urlLink,
                            'created_at'=>Carbon::now(),
                          ];
            $addPassValue = UserPasswordReset::create($passValue);
            
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

            return $this->APIResponse->respondWithMessage(__('Please check your mail inbox for your password!'));
        }else{
            return $this->APIResponse->respondUnauthorized(__('The email address provided is not registered. Please try again with registered email'));
        }
    }
}
