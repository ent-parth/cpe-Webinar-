<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TeamRequest extends FormRequest
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
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', 'max:255', 
                    Rule::unique('teams')->ignore($request->id ?? null)->where(function ($query) {
                        $query->where('status', "<>", 'delete');
                    })],
            'designation' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter first name.',
            'last_name.required' => 'Please enter last name.',
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'email.unique' => 'Email already exists.',
            'designation.required' => 'Please enter designation.',
            'status.required' => 'Please select status.',
        ];
    }
}
