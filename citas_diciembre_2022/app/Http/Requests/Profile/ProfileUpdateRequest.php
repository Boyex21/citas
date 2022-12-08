<?php

namespace App\Http\Requests\Profile;

use App\Models\Location;
use App\Models\Specialty\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

class ProfileUpdateRequest extends FormRequest
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
    $locations=Location::where('state', '1')->get()->pluck('slug');
    $specialties=Specialty::where('state', '1')->get()->pluck('slug');
    return [
      'photo' => 'nullable|file|mimetypes:image/*',
      'name' => 'required|string|min:2|max:191',
      'lastname' => 'required|string|min:2|max:191',
      'phone' => 'required|string|min:5|max:15',
      'address' => 'required|string|min:2|max:191',
      'location_id' => 'required|'.Rule::in($locations),
      'gender' => 'required|'.Rule::in(['1', '2', '3']),
      'birthday' => Rule::requiredIf($patient).'|date_format:d-m-Y|before_or_equal:'.date('d-m-Y'),
      'weight' => Rule::requiredIf($patient).'|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
      'designation' => Rule::requiredIf($doctor).'|string|min:2|max:191',
      'about' => Rule::requiredIf($doctor).'|string|min:2|max:1000',
      'education' => Rule::requiredIf($doctor).'|string|min:2|max:1000',
      'specialty_id' => Rule::requiredIf($doctor).'|array',
      'specialty_id.*' => Rule::requiredIf($doctor).'|'.Rule::in($specialties),
      'password' => 'nullable|string|min:8|confirmed'
    ];
  }
}
