<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],

            'tax_id' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('suppliers', 'tax_id')
                    ->ignore($this->route('supplier')),
            ],

            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'business_name' => 'nombre comercial',
            'contact_name' => 'nombre de contacto',
            'tax_id' => 'RFC',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'address' => 'dirección',
            'city' => 'ciudad',
            'state' => 'estado',
            'postal_code' => 'código postal',
            'notes' => 'notas',
            'active' => 'estado',
        ];
    }
}