<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends FormRequest
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
//        echo '<pre>'; print_r('Here'); die;
//        $avatarSize = $request->file('avatar')->getSize();
//        if ($avatarSize > 2048) {
//            $request->session()->flash('error', 'Avatar size must 2mb or below.');
//        }

        $admin = Administrator::findOrFail(Auth::guard('administrator')->user()->id);
        $rule = [];

        switch (trim($request->form_type)) {
            case "edit-profile":
                $rule['first_name'] = 'required|regex:/^[\pL\s\-]+$/u|max:255';
                $rule['last_name'] = 'required|regex:/^[\pL\s\-]+$/u|max:255';
                $rule['email'] = 'required|email|max:255|unique:administrators,email,' . $admin->id;
                break;

            case "edit-avatar":
                $rule['avatar'] = 'required|image|max:2048|mimes:jpeg,bmp,png,jpg,gif';
                break;

            case "edit-change-password":
                $rule['current_password'] = 'required|min:6|max:20';
                $rule['new_password'] = 'required|regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
                $rule['confirm_password'] = 'required|same:new_password';
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
            'first_name.required' => 'Please enter first name.',
            'first_name.regex' => 'Please enter valid first name.',
            'last_name.required' => 'Please enter last name.',
            'last_name.regex' => 'Please enter valid last name.',
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'email.unique' => 'Please enter valid email.',
            'new_password.required' => 'Please enter new password.',
            'new_password.required' => 'Please enter new password.',
            'new_password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'new_password.regex' => 'Password must be 6 to 20 characters with 1 uppercase and 1 lowercase letter.',
            'current_password.required' => 'Please enter current password.',
            'confirm_password.required' => 'Please enter confirm password.',
            'confirm_password.same' => 'The confirm password and new password must match.',
            'permission.required' => 'Please select atleast one permission for user.', // Role and permission.
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, bmp, png, jpg.',
            'avatar.max' => 'Avatar size must 2mb or below.',
            'avatar.image' => 'The avatar must be a file of type: jpeg, bmp, png, jpg.',
            'avatar.required' => 'Please select avatar.',
        ];
    }
}
