<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDesaReq extends FormRequest
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
            'nama_client' => 'required|max:150',
            'kodedesa' => 'required|numeric',
            'alamat_client' => 'required|max:255',
            'kades' => 'nullable|max:150',
            'sekretaris' => 'nullable|max:150',
            'bendahara' => 'nullable|max:150',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'web' => 'nullable|max:255',
            'peta' => 'nullable',
            'kelurahan_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'apikey' => 'required|string|max:255',
            'urlserver' => 'nullable|string|max:255',
            'image_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'bank' => 'nullable|string|max:255',
            'footnot' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'max' => ':attribute tidak boleh lebih dari :max karakter',
            'numeric' => ':attribute harus berupa angka',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar (.jpeg, .png, .jpg, .gif, .svg, .webp)',
            'logo.max' => ':attribute tidak boleh lebih dari 2 MB',
            'photo.max' => ':attribute tidak boleh lebih dari 2 MB',
            'string' => ':attribute harus berupa string',
            'email' => ':attribute harus berupa email',
            'file' => ':attribute harus berupa file',
        ];
    }

    public function attributes()
    {
        return [
            'nama_client' => 'Nama Desa',
            'kodedesa' => 'Kode Desa',
            'alamat_client' => 'Alamat Desa',
            'kades' => 'Kepala Desa',
            'sekretaris' => 'Sekretaris Desa',
            'bendahara' => 'Bendahara Desa',
            'logo' => 'Logo Desa',
            'photo' => 'Photo Desa',
            'web' => 'Website Desa',
            'phone' => 'Telepon',
            'email' => 'Email',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'youtube' => 'Youtube',
            'instagram' => 'Instagram',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'apikey' => 'API Key',
            'urlserver' => 'URL Server',
        ];
    }
}
