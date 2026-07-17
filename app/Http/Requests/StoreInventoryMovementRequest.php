<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'type' => [
                'required',
                Rule::in([
                    'entry',
                    'exit',
                    'adjustment',
                ]),
            ],

            'quantity' => [
                'required_unless:type,adjustment',
                'nullable',
                'numeric',
                'gt:0',
            ],

            'new_stock' => [
                'required_if:type,adjustment',
                'nullable',
                'numeric',
                'min:0',
            ],

            'unit_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Debes seleccionar un producto.',
            'product_id.exists' => 'El producto seleccionado no es válido.',
            'type.required' => 'Debes seleccionar un tipo de movimiento.',
            'type.in' => 'El tipo de movimiento no es válido.',
            'quantity.required_unless' => 'La cantidad es obligatoria.',
            'quantity.gt' => 'La cantidad debe ser mayor que cero.',
            'new_stock.required_if' => 'Debes indicar la nueva existencia.',
            'new_stock.min' => 'La existencia no puede ser negativa.',
            'reason.required' => 'Debes indicar el motivo del movimiento.',
        ];
    }
}