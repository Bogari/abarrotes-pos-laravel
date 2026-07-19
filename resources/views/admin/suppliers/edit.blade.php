@extends('layouts.admin')

@section('title', 'Editar proveedor')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Editar proveedor
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Actualiza la información comercial y de contacto del proveedor.
            </p>
        </div>

        <a
            href="{{ route('admin.suppliers.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
        >
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Volver
        </a>

    </div>

    {{-- Formulario --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <form
            action="{{ route('admin.suppliers.update', $supplier) }}"
            method="POST"
        >
            @method('PUT')

            <div class="p-6">

                @include('admin.suppliers.partials.form')

            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('admin.suppliers.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Guardar cambios
                </button>

            </div>
        </form>

    </div>

</div>

@endsection