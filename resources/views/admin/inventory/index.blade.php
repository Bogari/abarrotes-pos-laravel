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

{{-- Tabla Kardex --}}
<div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">

    <table class="w-full min-w-[920px] table-fixed">

        <thead class="bg-gray-50">
    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">

        <th class="w-32 px-4 py-3">Fecha</th>
        <th class="w-48 px-4 py-3">Producto</th>
        <th class="w-20 px-4 py-3 text-center">Tipo</th>
        <th class="w-20 px-4 py-3 text-right">Cantidad</th>
        <th class="w-16 px-4 py-3 text-right">Antes</th>
        <th class="w-16 px-4 py-3 text-right">Después</th>
        <th class="w-28 px-4 py-3">Usuario</th>
        <th class="w-28 px-4 py-3">Referencia</th>
        <th class="w-40 px-4 py-3">Motivo</th>

    </tr>
</thead>

        <tbody class="divide-y divide-gray-100 bg-white">

            @forelse($movements as $movement)

                <tr class="hover:bg-gray-50">

                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $movement->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900">
                            {{ $movement->product->name }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ $movement->product->code }}
                        </div>
                    </td>

                    <td class="px-4 py-3 text-center">

                        @switch($movement->type)

                            @case('entry')
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Entrada
                                </span>
                                @break

                            @case('exit')
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Salida
                                </span>
                                @break

                            @case('adjustment')
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Ajuste
                                </span>
                                @break

                        @endswitch

                    </td>

<td class="px-4 py-3 text-right font-semibold">

    @if ($movement->type === 'entry')

        <span class="text-green-600">
            +{{ number_format($movement->quantity, 2) }}
        </span>

    @elseif ($movement->type === 'exit')

        <span class="text-red-600">
            -{{ number_format($movement->quantity, 2) }}
        </span>

    @else

        @php
            $difference = (float) $movement->stock_after
                - (float) $movement->stock_before;
        @endphp

        <span class="{{ $difference >= 0 ? 'text-amber-600' : 'text-red-600' }}">
            {{ $difference >= 0 ? '+' : '' }}{{ number_format($difference, 2) }}
        </span>

    @endif

</td>

                    <td class="px-4 py-3 text-right">
                        {{ number_format($movement->stock_before, 2) }}
                    </td>

                    <td class="px-4 py-3 text-right">
                        {{ number_format($movement->stock_after, 2) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $movement->user?->name ?? 'Sistema' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $movement->reference ?? '-' }}
                    </td>
<td class="px-4 py-3">
    <div class="max-w-[220px] truncate"
         title="{{ $movement->reason }}">
        {{ $movement->reason }}
    </div>
</td>

                </tr>

            @empty

                <tr>

                    <td colspan="9"
                        class="px-6 py-12 text-center text-gray-500">

                        No hay movimientos registrados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">
    {{ $movements->links() }}
</div>
@endsection