<?php

namespace App\Http\Requests\Prescription;

use App\Models\Medicine;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrescriptionMedicineAddRequest extends FormRequest
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
    $medicines=Medicine::where('state', '1')->get()->pluck('slug');
    return [
      'medicine' => 'required|'.Rule::in($medicines),
      'dosage' => 'required|'.Rule::in(['1', '2', '3', '4', '5', '6', '7', '8']),
      'days' => 'required|integer|min:1',
      'time' => 'required|'.Rule::in(['1', '2']),
      'comments' => 'nullable|string|min:1|max:191'
    ];
  }
}
