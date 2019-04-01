<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
        $rules = [];
        $rules['country_id'] = 'required';
        $rules['state_id'] = 'required';
        $rules['name'] = 'required';
        $rules['status'] = 'required';

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        $messages['country_id.required'] = __('Please select country.');
        $messages['state_id.required'] = __('Please select state.');
        $messages['name.required'] = __('Enter city name.');
        $messages['status.required'] = __('Please select status.');

        return $messages;
    }
}
