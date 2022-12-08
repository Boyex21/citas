<?php

namespace App\Http\Requests\Patient;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientStoreRequest extends FormRequest
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
      'phone' => 'required|string|min:5|max:15',
      'email' => 'required|string|email|max:191|unique:users,email',
      'address' => 'required|string|min:2|max:191',
      'location_id' => 'required|'.Rule::in($locations),
      'password' => 'required|string|min:8|confirmed'
    ];
  }
}
