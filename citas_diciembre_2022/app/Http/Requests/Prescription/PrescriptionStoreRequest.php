<?php

namespace App\Http\Requests\Prescription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrescriptionStoreRequest extends FormRequest
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
        $covid=($this->covid=='1') ? true : false;
        return [
            'blood_pressure' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'pulse_rate' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'temperature' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'problem_description' => 'required|string|min:2|max:1000',
            'covid' => 'required|'.Rule::in(['0', '1']),
            'covid_date' => Rule::requiredIf($covid).'|date_format:d-m-Y|before_or_equal:'.date('d-m-Y'),
            'symptoms' => Rule::requiredIf($covid).'|array',
            'symptoms.*' => Rule::requiredIf($covid).'|'.Rule::in(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
            'uci' => Rule::requiredIf($covid).'|'.Rule::in(['0', '1']),
            'covid_state' => Rule::requiredIf($covid).'|'.Rule::in(['1', '2']),
            'test' => 'required|string|min:2|max:1000',
            'advice' => 'required|string|min:2|max:1000',
            'days' => 'required|integer|min:1',
            'time' => 'required|'.Rule::in(['1', '2', '3'])
        ];
    }
}
