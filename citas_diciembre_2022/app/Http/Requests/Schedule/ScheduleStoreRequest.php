<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ScheduleStoreRequest extends FormRequest
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
            'day' => 'required|'.Rule::in(['1', '2', '3', '4', '5', '6', '7']),
            'start' => 'required|date_format:H:i|before:end',
            'end' => 'required|date_format:H:i|after:start',
            'appointment_limit' => 'required|integer|min:1|max:100'
        ];
    }
}
