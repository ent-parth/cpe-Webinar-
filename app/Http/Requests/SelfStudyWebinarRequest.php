<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class SelfStudyWebinarRequest extends FormRequest
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
            'recorded_date' => 'required',
            'offered_date' => 'required',
            'time' => 'required',
            'webinar_type' => 'required',
            'refund_and_cancellations_policy' => 'required',
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
            'recorded_date.required' => 'Please enter recorded date.',
            'time.required' => 'Please enter time.',
            'webinar_type.required' => 'Please enter webinar type.',
            'refund_and_cancellations_policy.required' => 'Please enter refund and cancellations policy.',
            'offered_date.required' => 'Please enter offered date.',
            'cpe_credit.required' => 'Please enter cpe credit.',
            'status.required' => 'Please select status.',
        ];
    }
}
