<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CompaniesRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', 'max:255', 
                    Rule::unique('companies')->ignore($request->id ?? null)->where(function ($query) {
                        $query->where('status', "<>", config('constants.STATUS.STATUS_DELETE'));
                    })],
            'contact_number' => 'required|numeric|regex:/^[0-9]{7,14}$/',
            'website' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter company name.',
            'email.required' => __('Please enter email.'),
            'email.email' => __('Please enter valid email.'),
            'email.unique' => __('Email already exists.'),
            'status.required' => 'Please select status.',
            'website.required' => 'Please enter website.',
            'contact_number.required' => __('Please enter contact no.'),
            'contact_number.regex' => __('Please enter minimum 7 and maximum 14 digits.'),
            'contact_number.numeric' => __('Only number are allowed.'),
        ];
    }
}
