<?php

namespace App\Http\Requests\Patient;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientUpdateRequest extends FormRequest
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
        return [
            'photo' => 'nullable|file|mimetypes:image/*',
            'name' => 'required|string|min:2|max:191',
            'lastname' => 'required|string|min:2|max:191',
            'dni' => 'required|string|min:1|max:11',
            'phone' => 'required|string|min:5|max:15',
            'address' => 'required|string|min:2|max:191',
            'gender' => 'required|'.Rule::in(['1', '2', '3']),
            'birthday' => 'required|date_format:d-m-Y|before_or_equal:'.date('d-m-Y'),
            'weight' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'location_id' => 'required|'.Rule::in($locations),
            'state' => 'required|'.Rule::in(['0', '1'])
        ];
    }
}
