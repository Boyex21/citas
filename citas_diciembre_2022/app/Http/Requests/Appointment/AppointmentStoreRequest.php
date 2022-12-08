<?php

namespace App\Http\Requests\Appointment;

use App\Models\User;
use App\Models\Schedule\Schedule;
use App\Models\Specialty\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

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
        $doctor=(Auth::user()->hasRole(['Doctor'])) ? true : false;
        $patient=(Auth::user()->hasRole(['Paciente'])) ? true : false;
        $doctors=User::role(['Doctor'])->where('state', '1')->get()->pluck('slug');
        $patients=User::role(['Paciente'])->where('state', '1')->get()->pluck('slug');
        $schedules=Schedule::where('state', '1')->get()->pluck('id');
        $specialties=Specialty::where('state', '1')->get()->pluck('slug');
        return [
            'patient_id' => Rule::requiredIf($patient).'|'.Rule::in($patients),
            'doctor_id' => Rule::requiredIf($doctor).'|'.Rule::in($doctors),
            'specialty_id' => 'required|'.Rule::in($specialties),
            'date' => 'required|date_format:d-m-Y|after_or_equal:'.date('d-m-Y'),
            'schedule_id' => 'required|'.Rule::in($schedules),
            'type' => 'required|'.Rule::in(['1', '2'])
        ];
    }
}
