<?php

namespace App\Http\Requests\Appointment;

use App\Models\Schedule\Schedule;
use App\Models\Specialty\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppointmentUpdateRequest extends FormRequest
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
        $schedules=Schedule::where('state', '1')->get()->pluck('id');
        $specialties=Specialty::where('state', '1')->get()->pluck('slug');
        return [
            'specialty_id' => 'required|'.Rule::in($specialties),
            'date' => 'required|date_format:d-m-Y|after_or_equal:'.date('d-m-Y'),
            'schedule_id' => 'required|'.Rule::in($schedules),
            'type' => 'required|'.Rule::in(['1', '2'])
        ];
    }
}
