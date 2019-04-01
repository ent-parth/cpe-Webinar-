<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\UsesCustomErrorMessage;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $rule['first_name'] = 'required';
        $rule['last_name'] = 'required';
        $rule['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('status', "<>" ,'delete');
                }),
            ];
        $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).(?=.*[1-9]).{6,20}$/';
        $rule['confirm_password'] = 'required|same:password';
        $rule['contact_no'] = 'required|numeric|regex:/^[0-9]{7,14}$/';
        $rule['firm_name'] = 'required';
        // $rule['country_id'] = 'required';
        // $rule['state_id'] = 'required';
        // $rule['city_id'] = 'required';
        // $rule['zipcode'] = 'required';

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
            'first_name.required' => __('Please enter first name.'),
            'last_name.required' => __('Please enter last name.'),
            'email.email' => __('Please enter valid email.'),
            'email.required' => __('Please enter email.'),
            'email.unique' => __('Email already exists.'),
            'password.required' => __('Please enter password.'),
            'password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'password.same' => __('Password and confirm password do not match.'),
            'firm_name.required' => __('Please enter firm name.'),
            'country_id.required' => __('Please select country.'),
            'state_id.required' => __('Please select state.'),
            'city_id.required' => __('Please select city.'),
            'zipcode.required' => __('Please enter zip code.'),
            'contact_no.required' => __('Please enter contact no.'),
            'contact_no.regex' => __('Please enter minimum 7 and maximum 14 digits.'),
            'contact_no.numeric' => __('Only number are allowed.'),
        ];
    }
}
