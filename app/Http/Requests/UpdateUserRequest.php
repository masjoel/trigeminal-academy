<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'name' => 'required|string|max:80',
            'username' => 'required|string|unique:users,username,' . $userId->id,
            'email' => 'required|email|unique:users,email,' . $userId->id,
            'phone' => 'nullable|numeric',
        ];
    }
    // message
    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah digunakan, ganti yang lain.',
            'phone.numeric' => 'Email harus diisi.',
        ];
    }
}
