<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
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
                $role = [
                    'name' => 'required',
                ];
                break;
            case "edit":
                $role = [
                    'name' => 'required',
                ];
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
            'name.required' => 'Please enter role name.',
        ];
    }
}
