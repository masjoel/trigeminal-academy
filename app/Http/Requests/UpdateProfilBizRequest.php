<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilBizRequest extends FormRequest
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
            'nama_client' => 'required|string|max:50',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'desc_app' => 'string|max:200',
            'alamat_client' => 'string|max:200',
            'signature' => 'string|max:50',
            'email' => 'string|max:100',
            'endpoint' => 'nullable|string',
            'peta' => 'nullable|string',
            'endpoint_kecamatan' => 'nullable|string',
            'apikey' => 'nullable|string',
            'apikey_kecamatan' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'image_icon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1024',
            'bank' => 'nullable|string|max:150',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'max' => ':attribute terlalu panjang',
            'logo.max' => 'Logo ukuran file terlalu besar, max. 2 MB',
            'image_icon.max' => 'Favicon file terlalu besar, max. 1 MB',
            'image' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
            'mimes' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'nama_client' => 'Nama',
            'logo' => 'Logo',
            'image_icon' => 'Favicon',
            'peta' => 'Peta',
            'endpoint' => 'Endpoint',
            'endpoint_kecamatan' => 'Endpoint Kecamatan',
            'apikey' => 'Apikey',
            'apikey_kecamatan' => 'Apikey Kecamatan',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}
