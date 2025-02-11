<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceProsesRequest extends FormRequest
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
        return [
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Kolom :attribute wajib diisi.',
            'password.required' => 'Kolom :attribute wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => 'Password',
        ];
    }




}
