<?php

namespace App\Http\Requests\Doctor;

use App\Models\Location;
USE App\Models\Specialty\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorUpdateRequest extends FormRequest
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
        $locations=Location::where('state', '1')->get()->pluck('slug');
        $specialties=Specialty::where('state', '1')->get()->pluck('slug');
        return [
            'photo' => 'nullable|file|mimetypes:image/*',
            'name' => 'required|string|min:2|max:191',
            'lastname' => 'required|string|min:2|max:191',
            'phone' => 'required|string|min:5|max:15',
            'address' => 'required|string|min:2|max:191',
            'location_id' => 'required|'.Rule::in($locations),
            'specialty_id' => 'required|array',
            'specialty_id.*' => 'required|'.Rule::in($specialties),
            'state' => 'required|'.Rule::in(['0', '1'])
        ];
    }
}
