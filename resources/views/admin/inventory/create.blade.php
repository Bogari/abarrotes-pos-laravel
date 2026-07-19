@extends('layouts.admin')

@section('title', 'Nuevo movimiento de inventario')

@section('content')

<div class="mx-auto max-w-4xl">

    {{-- Encabezado --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Nuevo movimiento de inventario
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Registra una entrada, salida o ajuste de existencias.
            </p>
        </div>

        <a href="{{ route('admin.inventory.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

            <i data-lucide="arrow-left" class="h-4 w-4"></i>

            Volver al inventario
        </a>

    </div>

    {{-- Errores --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex items-start gap-3">

                <i data-lucide="circle-alert"
                   class="mt-0.5 h-5 w-5 text-red-600"></i>

                <div>
                    <p class="font-semibold text-red-800">
                        Revisa la información ingresada
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

        </div>

    @endif

    {{-- Formulario --}}
    <form method="POST"
          action="{{ route('admin.inventory.store') }}"
          class="rounded-xl border border-gray-200 bg-white shadow-sm">

        @csrf

        <div class="grid gap-6 p-6 md:grid-cols-2">

            {{-- Producto --}}
            <div class="md:col-span-2">

                <label for="product_id"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Producto
                </label>

                <select id="product_id"
                        name="product_id"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                    <option value="">
                        Selecciona un producto
                    </option>

@foreach ($products as $product)

    <option value="{{ $product->id }}"
        @selected(
            old('product_id', $selectedProduct?->id) == $product->id
        )>

        {{ $product->name }}
        — Código: {{ $product->code }}
        — Stock: {{ number_format($product->stock, 2) }}

    </option>

@endforeach

                </select>

                @error('product_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Tipo --}}
            <div>

                <label for="type"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Tipo de movimiento
                </label>

                <select id="type"
                        name="type"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                    <option value="">
                        Selecciona una opción
                    </option>

                    <option value="entry" @selected(old('type') === 'entry')>
                        Entrada
                    </option>

                    <option value="exit" @selected(old('type') === 'exit')>
                        Salida
                    </option>

                    <option value="adjustment" @selected(old('type') === 'adjustment')>
                        Ajuste
                    </option>

                </select>

                @error('type')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Cantidad --}}
            <div id="quantity-container">

                <label for="quantity"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Cantidad
                </label>

                <input type="number"
                       id="quantity"
                       name="quantity"
                       value="{{ old('quantity') }}"
                       step="0.01"
                       min="0.01"
                       placeholder="Ejemplo: 10"
                       class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Nueva existencia --}}
            <div id="new-stock-container"
                 class="hidden">

                <label for="new_stock"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Nueva existencia
                </label>

                <input type="number"
                       id="new_stock"
                       name="new_stock"
                       value="{{ old('new_stock') }}"
                       step="0.01"
                       min="0"
                       placeholder="Ejemplo: 25"
                       class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                @error('new_stock')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Costo unitario --}}
            <div id="unit-cost-container">

                <label for="unit_cost"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Costo unitario
                </label>

                <input type="number"
                       id="unit_cost"
                       name="unit_cost"
                       value="{{ old('unit_cost') }}"
                       step="0.01"
                       min="0"
                       placeholder="Ejemplo: 15.50"
                       class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                <p class="mt-1 text-xs text-gray-500">
                    Opcional. Se utiliza principalmente en entradas.
                </p>

                @error('unit_cost')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Referencia --}}
            <div>

                <label for="reference"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Referencia
                </label>

                <input type="text"
                       id="reference"
                       name="reference"
                       value="{{ old('reference') }}"
                       maxlength="255"
                       placeholder="Ejemplo: Factura 1025"
                       class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                <p class="mt-1 text-xs text-gray-500">
                    Puede ser una factura, nota, folio o documento.
                </p>

                @error('reference')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Motivo --}}
            <div class="md:col-span-2">

                <label for="reason"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Motivo
                </label>

                <textarea id="reason"
                          name="reason"
                          rows="4"
                          required
                          maxlength="1000"
                          placeholder="Describe por qué se realiza este movimiento"
                          class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('reason') }}</textarea>

                @error('reason')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>

        {{-- Botones --}}
        <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.inventory.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">

                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">

                <i data-lucide="save" class="h-4 w-4"></i>

                Registrar movimiento
            </button>

        </div>

    </form>

</div>

{{-- Cambio dinámico de campos --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const quantityContainer = document.getElementById('quantity-container');
        const newStockContainer = document.getElementById('new-stock-container');
        const unitCostContainer = document.getElementById('unit-cost-container');

        const quantityInput = document.getElementById('quantity');
        const newStockInput = document.getElementById('new_stock');

        function updateFields() {
            const type = typeSelect.value;

            if (type === 'adjustment') {
                quantityContainer.classList.add('hidden');
                newStockContainer.classList.remove('hidden');
                unitCostContainer.classList.add('hidden');

                quantityInput.required = false;
                newStockInput.required = true;
            } else {
                quantityContainer.classList.remove('hidden');
                newStockContainer.classList.add('hidden');

                quantityInput.required = true;
                newStockInput.required = false;

                if (type === 'entry') {
                    unitCostContainer.classList.remove('hidden');
                } else {
                    unitCostContainer.classList.add('hidden');
                }
            }
        }

        typeSelect.addEventListener('change', updateFields);

        updateFields();
    });
</script>

@endsection