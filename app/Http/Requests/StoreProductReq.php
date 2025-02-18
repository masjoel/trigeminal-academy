<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductReq extends FormRequest
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
            'name' => 'required|string|max:250',
            'instructor' => 'required|string|max:150',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'level' => 'nullable|string',
            'image_url' => 'nullable|string',
            'video_url' => 'required|string',
            'video_duration' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Nama sudah ada.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 250 char.',
            'instructor.required' => 'Instructor harus diisi.',
            'instructor.string' => 'Instructor harus berupa string.',
            'instructor.max' => 'Instructor tidak boleh lebih dari 150 char.',
            'description.string' => 'Deskripsi harus berupa string.',
            'budget.numeric' => 'Budget harus berupa angka.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'discount.numeric' => 'Diskon harus berupa angka.',
            'level.string' => 'Level harus berupa string.',
            'image_url.string' => 'URL gambar harus berupa string.',
            'video_url.required' => 'URL video harus diisi.',
            'video_url.string' => 'URL video harus berupa string.',
            'video_duration.required' => 'Durasi video harus diisi.',
            'video_duration.integer' => 'Durasi video harus berupa angka.',
        ];
    }

}
