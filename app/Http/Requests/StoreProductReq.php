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
            'category_id' => 'required',
            'instructor_id' => 'required',
            'instructor' => 'nullable|string',
            'excerpt' => 'nullable|string:max:250',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'level' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'storage_type' => 'nullable|string',
            'video_url' => 'nullable|string',
            'video_duration' => 'required|integer',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mp3,wav,flv,mov,avi,mkv,wmv,vob,3gp|max:204800',
            'publish' => 'nullable',
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
            'excerpt.string' => 'Ecxcerpt harus berupa string.',
            'excerpt.max' => 'Ecxcerpt tidak boleh lebih dari 250 char.',
            'description.string' => 'Deskripsi harus berupa string.',
            'budget.numeric' => 'Budget harus berupa angka.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'discount.numeric' => 'Diskon harus berupa angka.',
            'level.string' => 'Level harus berupa string.',
            'video_url.required' => 'URL video harus diisi.',
            'video_url.string' => 'URL video harus berupa string.',
            'video_duration.required' => 'Durasi video harus diisi.',
            'video_duration.integer' => 'Durasi video harus berupa angka.',
            'image_url.max' => ':attribute ukuran file terlalu besar, max. 2 MB',
            'category_id.required' => 'Kategori harus diisi.',
            'instructor_id.required' => 'Instruktur harus diisi.',
            'video_file.max' => ':attribute ukuran file terlalu besar, max. 200 MB',
        ];
    }

}
