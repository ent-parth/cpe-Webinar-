<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\UsesCustomErrorMessage;

class LogoutRequest extends FormRequest
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
        $rule['device_id'] = 'required';
        $rule['device_token'] = 'required';

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
            'device_id.required' => __('Device is required.'),
            'device_token.required' => __('Device token is required.'),
        ];
    }
}
