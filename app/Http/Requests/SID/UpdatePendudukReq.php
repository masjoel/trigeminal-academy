<?php

namespace App\Http\Requests\SID;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendudukReq extends FormRequest
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
        $wargaId = $this->route('admin_anggotum');
        return [
            'nama' => 'required',
            'nik' => 'required|numeric|unique:adpdd_induks,nik,'. $wargaId->id,
            'id_ktp' => 'nullable|unique:adpdd_induks,id_ktp,'. $wargaId->id,
            'kk' => 'nullable|numeric',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required',
            'telpon' => 'nullable|numeric',
            'alamat' => 'required',
            'rt' => 'nullable|numeric',
            'rw' => 'nullable|numeric',
            'agama' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'nullable',
            'status_kawin' => 'nullable',
            'hubungan' => 'nullable',
            'warganegara' => 'nullable',
            'ayah' => 'nullable',
            'ibu' => 'nullable',
            'keterangan' => 'nullable',
            'gol_darah' => 'nullable',
            'gender' => 'nullable',
            'pekerjaan_lain' => 'nullable',
            'slug' => 'nullable',
            'bacahuruf' => 'nullable',
            'mutasi' => 'nullable',
            'paspor' => 'nullable',
            'kitas' => 'nullable',
            'akte_kelahiran' => 'nullable',
            'tgl_catat' => 'nullable',
            'akseptor_kb' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'iduser' => 'nullable',
            'iddesa' => 'nullable',
            'idkec' => 'nullable',
            'kcds' => 'nullable',
            'hash_id_ktp' => 'nullable',
            'hash_nik' => 'nullable',
            'hash_kk' => 'nullable',
            'email' => 'nullable',
            'wakil_dpp' => 'nullable',
            'wakil_dpw' => 'nullable',
            'wakil_dpd' => 'nullable',
            'wakil_dpc' => 'nullable',
            'wakil_dpac' => 'nullable',
            'status' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi.',
            'nama.string' => 'Nama harus diisi.',
            'nik.unique' => 'NIK sudah digunakan.',
            'nik.required' => 'NIK harus diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'kk.required' => 'Nomor KK harus diisi.',
            'kk.numeric' => 'Nomor KK harus berupa angka.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus diisi.',
            'telpon.required' => 'No. HP harus diisi.',
            'telpon.numeric' => 'No. HP harus berupa angka.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus diisi.',
            'rt.required' => 'RT harus diisi.',
            'rt.numeric' => 'RT harus berupa angka.',
            'rw.required' => 'RW harus diisi.',
            'rw.numeric' => 'RW harus berupa angka.',
            'agama.required' => 'Agama harus diisi.',
            'pendidikan.required' => 'Pendidikan harus diisi.',
            'pekerjaan.required' => 'Pekerjaan harus diisi.',
            'status_kawin.required' => 'Status Kawin harus diisi.',
            'hubungan.required' => 'Hubungan Keluarga harus diisi.',
            'warganegara.required' => 'Warga Negara harus diisi.',
            'ayah.required' => 'Nama Ayah harus diisi.',
            'ibu.required' => 'Nama Ibu harus diisi.',
            'id_ktp.required' => 'ID KTP harus diisi.',
            'id_ktp.unique' => 'ID KTP sudah digunakan.',
        ];
    }
}
