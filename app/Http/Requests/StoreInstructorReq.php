<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorReq extends FormRequest
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
            'nama' => 'required|string|max:200',
            'alamat' => 'nullable',
            'telpon' => 'nullable',
            'ktp' => 'nullable',
            'keterangan' => 'nullable|string|max:250',
            'user_id' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'nama_usaha' => 'nullable|string|max:200',
            'izin_usaha' => 'nullable',
            'kegiatan_usaha' => 'nullable',
            'bentuk_usaha' => 'nullable',
            'approval' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute terlalu panjang',
            'photo.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
            'mimes' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
            'image' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telpon' => 'Telpon',
            'ktp' => 'NIK',
            'keterangan' => 'Keterangan',
            'photo' => 'Foto',
            'nama_usaha' => 'Nama Usaha/UMKM',
        ];
    }
}
