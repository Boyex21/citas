<?php

namespace App\Http\Requests\Schedule;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ScheduleDoctorRequest extends FormRequest
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
        $doctors=User::role(['Doctor'])->where('state', '1')->get()->pluck('slug');
        return [
            'doctor_id' => 'required|'.Rule::in($doctors),
            'date' => 'required|date_format:d-m-Y|after_or_equal:'.date('d-m-Y')
        ];
    }
}
