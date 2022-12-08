<?php

namespace App\Http\Requests\User;

use App\Models\Location;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $roles=Role::where([['name', '!=', 'Doctor'], ['name', '!=', 'Secretaria'], ['name', '!=', 'Paciente']])->get()->pluck('name');
        return [
            'photo' => 'nullable|file|mimetypes:image/*',
            'name' => 'required|string|min:2|max:191',
            'lastname' => 'required|string|min:2|max:191',
            'phone' => 'required|string|min:5|max:15',
            'address' => 'required|string|min:2|max:191',
            'location_id' => 'required|'.Rule::in($locations),
            'gender' => 'required|'.Rule::in(['1', '2', '3']),
            'type' => 'required|'.Rule::in($roles),
            'state' => 'required|'.Rule::in(['0', '1'])
        ];
    }
}
