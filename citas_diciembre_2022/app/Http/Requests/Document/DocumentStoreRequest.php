<?php

namespace App\Http\Requests\Document;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

class DocumentStoreRequest extends FormRequest
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
        $doctors=Appointment::with(['doctor'])->where('user_id', Auth::id())->groupBy('doctor_id')->get()->pluck('doctor')->where('state', 'Activo')->pluck('slug');
        return [
            'doctor_id' => 'required|'.Rule::in($doctors),
            'description' => 'required|string|min:2|max:1000',
            'files' => 'required|array',
            'files.*' => 'required|string|min:2|max:191'
        ];
    }
}
