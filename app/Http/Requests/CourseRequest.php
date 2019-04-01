<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            //'course_level_id.required' => 'required',
            'name' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'course_level_id.required' => __('Please select course level.'),
            'name.required' => __('Please enter course name.'),
            'status.required' => __('Please select status'),
        ];
    }
}
