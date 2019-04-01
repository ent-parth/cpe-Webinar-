<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SpeakerRequest extends FormRequest
{

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
    public function rules(Request $request)
    {
        $formType = $request->form_type;
        $rule = [];

        switch ($formType) {
            case "add":
                $rule['first_name'] = 'required|max:255';
                $rule['last_name'] = 'required|max:255';
                $rule['email'] = 'required|email|max:255|unique:speakers';
                $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
                $rule['confirm_password'] = 'required|same:password';
                $rule['contact_no'] = 'required|numeric|regex:/^[0-9]{7,14}$/';
                $rule['country_id'] = 'required';
                $rule['state_id'] = 'required';
                $rule['city_id'] = 'required';
                $rule['zipcode'] = 'required';
                $rule['status'] = 'required';
                break;
            case "edit":
                $rule['first_name'] = 'required|max:255';
                $rule['last_name'] = 'required|max:255';
                $rule['email'] = 'required|email|max:255|unique:speakers,email,' . $request->id;
                $rule['contact_no'] = 'required|numeric|regex:/^[0-9]{7,14}$/';
                 $rule['country_id'] = 'required';
                $rule['state_id'] = 'required';
                $rule['city_id'] = 'required';
                $rule['zipcode'] = 'required';
                $rule['status'] = 'required';
                break;
        }
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
            'email.required' => __('Please enter email.'),
            'email.email' => __('Please enter valid email.'),
            'email.unique' => __('Email already exists.'),
            'password.required' => __('Please enter password.'),
            'password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'new_password.regex' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'current_password.required' => __('Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.'),
            'confirm_password.required' => __('Please enter confirm password.'),
            'confirm_password.same' => __('Password and confirm password do not match.'),
            'country_id.required' => __('Please select country.'),
            'state_id.required' => __('Please select state.'),
            'city_id.required' => __('Please select city.'),
            'zipcode.required' => __('Please enter zip code.'),
            'status.required' => __('Please select status.'),
            'contact_no.required' => __('Please enter contact no.'),
            'contact_no.regex' => __('Please enter minimum 7 and maximum 14 digits.'),
            'contact_no.numeric' => __('Only number are allowed.'),
        ];
    }

}
