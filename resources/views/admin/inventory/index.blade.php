@extends('layouts.admin')

@section('title', 'Inventario')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Inventario
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Consulta el historial de movimientos de existencias.
            </p>

        </div>

        <a href="{{ route('admin.inventory.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">

            <i data-lucide="plus"></i>

            Nuevo movimiento

        </a>

    </div>
{{-- KPIs --}}
<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-gray-500">Movimientos</p>
        <h2 class="mt-2 text-3xl font-bold text-gray-900">
            {{ $stats['total'] }}
        </h2>
    </div>

    <div class="rounded-xl border border-green-200 bg-green-50 p-5 shadow-sm">
        <p class="text-sm text-green-700">Entradas</p>
        <h2 class="mt-2 text-3xl font-bold text-green-700">
            {{ $stats['entries'] }}
        </h2>
    </div>

    <div class="rounded-xl border border-red-200 bg-red-50 p-5 shadow-sm">
        <p class="text-sm text-red-700">Salidas</p>
        <h2 class="mt-2 text-3xl font-bold text-red-700">
            {{ $stats['exits'] }}
        </h2>
    </div>

    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
        <p class="text-sm text-amber-700">Ajustes</p>
        <h2 class="mt-2 text-3xl font-bold text-amber-700">
            {{ $stats['adjustments'] }}
        </h2>
    </div>

</div>

{{-- Filtros --}}
<div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

    <form method="GET"
          action="{{ route('admin.inventory.index') }}"
          class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">

        {{-- Buscar --}}
        <div class="xl:col-span-2">

            <label class="mb-2 block text-sm font-medium text-gray-700">
                Buscar
            </label>

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Producto, código, referencia o motivo..."
                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

        </div>

        {{-- Producto --}}
        <div>

            <label class="mb-2 block text-sm font-medium text-gray-700">
                Producto
            </label>

            <select
                name="product"
                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                <option value="">Todos</option>

                @foreach($products as $product)

                    <option value="{{ $product->id }}"
                        @selected($productId == $product->id)>

                        {{ $product->name }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Tipo --}}
        <div>

            <label class="mb-2 block text-sm font-medium text-gray-700">
                Tipo
            </label>

            <select
                name="type"
                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                <option value="">Todos</option>

                <option value="entry"
                    @selected($type == 'entry')>

                    Entrada

                </option>

                <option value="exit"
                    @selected($type == 'exit')>

                    Salida

                </option>

                <option value="adjustment"
                    @selected($type == 'adjustment')>

                    Ajuste

                </option>

            </select>

        </div>

        {{-- Botones --}}
        <div class="flex items-end gap-2">

            <button
                type="submit"
                class="rounded-lg bg-emerald-600 px-5 py-2.5 font-medium text-white hover:bg-emerald-700">

                Buscar

            </button>

            <a href="{{ route('admin.inventory.index') }}"
               class="rounded-lg border border-gray-300 px-5 py-2.5 hover:bg-gray-100">

                Limpiar

            </a>

        </div>

    </form>

</div>
@endsection