<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH');
        $presence = $isPatch ? 'sometimes' : 'required';

        return [
            'title' => [
                $presence,
                'string',
                'max:255',
                $isPatch
                    ? Rule::unique('media', 'title')->ignore($this->route('media'))
                    : 'unique:media,title',
            ],
            'type' => [$presence, 'string', 'max:50'],
            'genre' => [$presence, 'string', 'max:100'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.string' => 'Judul media harus berupa teks.',
            'title.max' => 'Judul media maksimal 255 karakter.',
            'title.unique' => 'Judul media sudah terdaftar.',
            'type.required' => 'Tipe media wajib diisi.',
            'type.string' => 'Tipe media harus berupa teks.',
            'type.max' => 'Tipe media maksimal 50 karakter.',
            'genre.required' => 'Genre media wajib diisi.',
            'genre.string' => 'Genre media harus berupa teks.',
            'genre.max' => 'Genre media maksimal 100 karakter.',
            'duration_minutes.integer' => 'Durasi harus berupa angka bulat.',
            'duration_minutes.min' => 'Durasi minimal 1 menit.',
        ];
    }
}
