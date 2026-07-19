<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id')
                    ->where('active', true),
            ],

            'purchase_date' => [
                'required',
                'date',
            ],

            'invoice_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('products', 'id')
                    ->where('active', true),
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'items.*.unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Debes agregar al menos un producto.',
            'items.array' => 'Los productos enviados no son válidos.',
            'items.min' => 'Debes agregar al menos un producto.',

            'items.*.product_id.required' => 'Selecciona un producto.',
            'items.*.product_id.distinct' => 'No puedes repetir el mismo producto.',
            'items.*.product_id.exists' => 'El producto seleccionado no está disponible.',

            'items.*.quantity.required' => 'Captura la cantidad.',
            'items.*.quantity.gt' => 'La cantidad debe ser mayor que cero.',

            'items.*.unit_cost.required' => 'Captura el costo unitario.',
            'items.*.unit_cost.min' => 'El costo unitario no puede ser negativo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'supplier_id' => 'proveedor',
            'purchase_date' => 'fecha de compra',
            'invoice_number' => 'número de factura',
            'tax' => 'impuestos',
            'notes' => 'observaciones',
            'items' => 'productos',
            'items.*.product_id' => 'producto',
            'items.*.quantity' => 'cantidad',
            'items.*.unit_cost' => 'costo unitario',
        ];
    }
}