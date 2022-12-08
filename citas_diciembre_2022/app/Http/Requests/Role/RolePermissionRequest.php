<?php

namespace App\Http\Requests\Role;

use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
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
        $permissions=Permission::get()->pluck('name');
        return [
            'permission_id' => 'required|array',
            'permission_id.*' => 'required|'.Rule::in($permissions)
        ];
    }
}
