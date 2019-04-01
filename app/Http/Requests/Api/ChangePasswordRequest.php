<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\UsesCustomErrorMessage;

class ChangePasswordRequest extends FormRequest
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
        $rule['current_password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).(?=.*[1-9]).{6,20}$/';
        $rule['new_password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).(?=.*[1-9]).{6,20}$/';
        $rule['confirm_password'] = 'required|same:new_password';

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
            'current_password.required' => __('Please enter current password.'),
            'current_password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'new_password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'new_password.required' => __('Please enter new password.'),
            'confirm_password.required' => __('Please enter confirm password.'),
            'confirm_password.same' => __('Password and confirm password do not match.'),
        ];
    }
}
