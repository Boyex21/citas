<?php

namespace App\Http\Requests\Prescription;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrescriptionMedicineDeleteRequest extends FormRequest
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
    $appointment=Appointment::with(['prescriptions'])->where('id', $this->appointment->id)->first();
    $items=[];
    if (!is_null($appointment)) {
      $items=$appointment['prescriptions']->pluck('id');
    }
    return [
      'code' => 'required|'.Rule::in($items)
    ];
  }
}
