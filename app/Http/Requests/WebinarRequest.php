<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class WebinarRequest extends FormRequest
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
            'date' => 'required',
            'time' => 'required',
            'webinar_type' => 'required',
            'faq' => 'required',
            'description' => 'required',
            'cpe_credit' => 'required',
            'name' => ['required', 'max:255', 
                    Rule::unique('webinars')->ignore($request->id ?? null)->where(function ($query) {
                        $query->where('status', "<>", 'delete');
                    })],
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name.',
            'date.required' => 'Please enter date.',
            'time.required' => 'Please enter time.',
            'webinar_type.required' => 'Please enter webinar type.',
            'faq.required' => 'Please enter faq.',
            'description.required' => 'Please enter description.',
            'cpe_credit.required' => 'Please enter cpe credit.',
            'status.required' => 'Please select status.',
        ];
    }
}
