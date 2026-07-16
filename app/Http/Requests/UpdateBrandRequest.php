<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brand = $this->route('brand');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($brand->id),
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
            'active.required' => 'El estado de la marca es obligatorio.',
            'active.boolean' => 'El estado de la marca no es válido.',
        ];
    }
}