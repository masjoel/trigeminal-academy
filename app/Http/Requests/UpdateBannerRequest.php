<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:200',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'max' => ':attribute terlalu panjang',
            'image.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
            'image' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
            'mimes' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Title',
            'deskripsi' => 'Deskripsi',
            'image' => 'Foto',
        ];
    }
}
