<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdministratorRequest extends FormRequest
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
                $rule['email'] = 'required|email|max:255|unique:administrators';
                $rule['password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
                $rule['confirm_password'] = 'required|same:password';
                $rule['contact_no'] = 'required|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/';
                $rule['role_id'] = 'required';
                break;
            case "edit":
                $rule['first_name'] = 'required|max:255';
                $rule['last_name'] = 'required|max:255';
                //                $rule['username'] = 'required|max:255|min:6|regex:/^[0-9A-Za-z\s\-\_\.]+$/|unique:administrators,username,' . $request->id;
                $rule['email'] = 'required|email|max:255|unique:administrators,email,' . $request->id;
                $rule['contact_no'] = 'required|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/';
                $rule['role_id'] = 'required';
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
            'role_id.required' => __('Please select role.'),
            'contact_no.required' => __('Please enter contact no.'),
            'contact_no.regex' => __('Please enter valid no.'),
        ];
    }

}
