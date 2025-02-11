<?php

namespace App\Http\Requests\SID;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkExternalReq extends FormRequest
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
            'keterangan' => 'required|max:255',
            'url_ext' => 'required',
            'tipe' => 'nullable',
            'icon' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
        ];
    }

    public function attributes()
    {
        return [
            'keterangan' => 'Nama',
            'url_ext' => 'URL link'
        ];
    }
}
