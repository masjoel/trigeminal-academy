<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCatReq extends FormRequest
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
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:200',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'user_id' => 'nullable',
            'warna' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'max' => ':attribute terlalu panjang',
            'thumbnail.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Kategori',
            'description' => 'Deskripsi',
            'thumbnail' => 'Gambar',
            'user_id' => 'User ID',
        ];
    }
}
