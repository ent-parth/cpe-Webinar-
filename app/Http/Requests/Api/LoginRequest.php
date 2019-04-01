<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\UsesCustomErrorMessage;

class LoginRequest extends FormRequest
{

    use UsesCustomErrorMessage;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule['email'] = 'required|email';
//        $rule['email'] = 'required|email';
        $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).(?=.*[1-9]).{6,20}$/';
        $rule['device_id'] = 'required';
        $rule['device_token'] = 'required';
        $rule['device_type'] = 'required';

        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.email' => __('Please enter valid email.'),
            'email.required' => __('Please enter email.'),
//            'email.required' => __('messages.required_email_validation'),
//            'email.email' => __('messages.required_email_valid_validation'),
            'password.required' => __('Please enter password.'),
            'password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'device_id.required' => __('Device is required.'),
            'device_token.required' => __('Device token is required.'),
            'device_type.required' => __('Device type is required')
        ];
    }
}
