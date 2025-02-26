<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderReq extends FormRequest
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
            'payment_status' => 'string',
            'total_budget' => 'nullable|numeric',
            'total_price' => 'nullable|numeric',
            'bukti_bayar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'max' => ':attribute terlalu panjang',
            'numeric' => ':attribute harus berupa angka',
            'image' => ':attribute harus berupa gambar',
            'bukti_bayar.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
        ];
    }

    public function attributes(): array
    {
        return [
            'payment_status' => 'Status pembayaran',
            'total_budget' => 'Total budget',
            'total_price' => 'Total price',
            'bukti_bayar' => 'Bukti bayar',
        ];
    }  
}
