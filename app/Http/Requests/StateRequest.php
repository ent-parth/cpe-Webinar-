<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'country_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required' => __('Please select country.'),
            'name.required' => __('Please enter state name.'),
            'status.required' => __('Please select status'),
        ];
    }
}
