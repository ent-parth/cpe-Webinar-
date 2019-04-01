<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Administrator;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     * Define the administrator auth
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin_guest');
    }

    /**
     * Display the password reset view for the given token.
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        //print_r(urldecode(request()->get('email')));exit;
        config(['app.name' => __('LMS | Change Password')]);
        return view('backEnd.auth.passwords.reset')->with(
                        ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'password.required' => 'Please enter password.',
            'password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'password_confirmation.required' => 'Please enter confirm password.',
            'password_confirmation.same' => 'The confirm password and password must match.',
        ];
    }

    /**
     * Define the password broker
     * 
     * @return type
     */
    public function broker()
    {
        return Password::broker('administrators');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $administratorStatus = Administrator::select('status')->active()->where('email', '=', $request->email)->first();

        if (empty($administratorStatus)) {
            return back()->with('status', __('Your email is block, Please contact to administrator.'));
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                    //print_r($user);exit;
            $this->resetPassword($user, $password);
        }
        );
        //print_r($request->all());exit;
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET ? $this->sendResetResponse($request, $response) : $this->sendResetFailedResponse($request, $response);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = $password;

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        $request->session()->flash('success', 'Password reset successfully.');

        return redirect()->route('show-admin-login-form');
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $request->session()->flash('error', 'Password does not reset successfully.');

        return redirect()->route('administrator.reset.form');
    }

    /**
     * Check the active users
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
        $data = Administrator::active()->where('email', '=', $request->email)->get();

        $flag = ($data->count() > 0) ? 'true' : 'false';

        return $flag;
    }
}
