<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'active' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la marca es obligatorio.',
            'name.unique' => 'Ya existe una marca con ese nombre.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'description.max' => 'La descripción no puede superar los 1000 caracteres.',
        ];
    }
}