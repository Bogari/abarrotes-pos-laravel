<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'code')->ignore($product->id),
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'barcode')->ignore($product->id),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'brand_id' => [
                'nullable',
                'integer',
                'exists:brands,id',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
                'gte:purchase_price',
            ],

            'stock' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'numeric',
                'min:0',
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
            'code.required' => 'El código interno es obligatorio.',
            'code.unique' => 'Ya existe un producto con este código.',
            'barcode.unique' => 'Ya existe un producto con este código de barras.',
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.unique' => 'Ya existe un producto con este nombre.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'brand_id.exists' => 'La marca seleccionada no es válida.',
            'purchase_price.required' => 'El precio de compra es obligatorio.',
            'sale_price.required' => 'El precio de venta es obligatorio.',
            'sale_price.gte' => 'El precio de venta no puede ser menor al precio de compra.',
            'stock.required' => 'La existencia es obligatoria.',
            'minimum_stock.required' => 'El stock mínimo es obligatorio.',
        ];
    }
}