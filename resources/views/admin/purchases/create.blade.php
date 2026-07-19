@extends('layouts.admin')

@section('title', 'Nueva compra')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Nueva compra
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Registra la recepción de mercancía de un proveedor.
            </p>
        </div>

        <a
            href="{{ route('admin.purchases.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
        >
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Volver
        </a>

    </div>

    <form
        action="{{ route('admin.purchases.store') }}"
        method="POST"
        id="purchase-form"
    >
        @include('admin.purchases.partials.form')
    </form>
    <div
    id="product-modal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
    aria-hidden="true"
>
    <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-xl bg-white shadow-xl">

        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">
                    Nuevo producto
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Registra el producto sin abandonar la compra.
                </p>
            </div>

            <button
                type="button"
                id="close-product-modal-button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                title="Cerrar"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form id="quick-product-form">
            @csrf

            <div
                id="quick-product-errors"
                class="mx-6 mt-5 hidden rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            ></div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Código interno *
                    </label>

                    <input
                        type="text"
                        name="code"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Código de barras
                    </label>

                    <input
                        type="text"
                        name="barcode"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Nombre del producto *
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Categoría *
                    </label>

                    <select
                        name="category_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                        <option value="">Selecciona una categoría</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Marca
                    </label>

                    <select
                        name="brand_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    >
                        <option value="">Sin marca</option>

                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Precio de compra *
                    </label>

                    <input
                        type="number"
                        name="purchase_price"
                        min="0"
                        step="0.01"
                        value="0"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Precio de venta *
                    </label>

                    <input
                        type="number"
                        name="sale_price"
                        min="0"
                        step="0.01"
                        value="0"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Stock mínimo *
                    </label>

                    <input
                        type="number"
                        name="minimum_stock"
                        min="0"
                        step="1"
                        value="0"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <div class="flex items-end">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="active"
                            value="1"
                            checked
                            class="rounded border-gray-300"
                        >

                        <span class="ml-2 text-sm text-gray-700">
                            Producto activo
                        </span>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Descripción
                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    ></textarea>
                </div>

            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    id="cancel-product-modal-button"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    id="save-quick-product-button"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Guardar producto
                </button>

            </div>
        </form>

    </div>
</div>

</div>

@endsection