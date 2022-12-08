<?php

namespace App\Http\Requests\Appointment;

use App\Models\User;
use App\Models\Schedule\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppointmentStoreRequest extends FormRequest
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
        $patients=User::role(['Paciente'])->where('state', '1')->get()->pluck('slug');
        $schedules=Schedule::where('state', '1')->get()->pluck('id');
        return [
            'doctor_id' => 'required|'.Rule::in($doctors),
            'patient_id' => 'required|'.Rule::in($patients),
            'day' => 'required|'.Rule::in(['1', '2', '3', '4', '5', '6', '7']),
            'date' => 'required|date_format:d-m-Y|after_or_equal:'.date('d-m-Y'),
            'schedule_id' => 'required|'.Rule::in($schedules),
            'type' => 'required|'.Rule::in(['1', '2'])
        ];
    }
}
