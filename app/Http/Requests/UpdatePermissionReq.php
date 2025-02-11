<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionReq extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $permissionId = $this->route('permission');
        return [
            'name' => 'required|string|max:250|unique:permissions,name,' . $permissionId->id,
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Nama sudah ada.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 250 char.',
        ];
    }
}
