<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerangkatReq extends FormRequest
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
            'nik' => 'required|string|max:255|unique:perangkat_desas,nik,' . $this->route('admin_penguru')->id,
            'id_ktp' => 'nullable',
            'nama' => 'required|string|max:100',
            'urut' => 'required|numeric|min:1',
            'nip' => 'nullable|numeric',
            'password' => 'nullable|string|max:100|min:8',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'jabatan' => 'nullable',
            'jabatan_tipe' => 'nullable',
            'status' => 'nullable',
            'deskripsi' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus bertipe string',
            'unique' => ':attribute tersebut sudah digunakan',
            'numeric' => ':attribute harus bertipe angka',
            'max' => ':attribute terlalu panjang',
            'min' => ':attribute minimal :min',
            'avatar.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
            'image' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
            'mimes' => ':attribute harus bertipe gambar (jpg, png, jpeg, gif, svg, webp)',
        ];
    }

    public function attributes(): array
    {
        return [
            'nik' => 'NIK',
            'nama' => 'Title',
            'urut' => 'Nomor Urut',
            'nip' => 'NIP',
            'password' => 'Password',
            'avatar' => 'Foto',
            'id_ktp' => 'ID KTP',
        ];
    }
}
