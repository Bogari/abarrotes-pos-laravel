@extends('layouts.admin')

@section('title', 'Productos')
@section('page-title', 'Productos')

@section('content')

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 mb-8">

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Productos</p>
        <h2 class="mt-2 text-3xl font-bold">{{ $stats['total'] }}</h2>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Activos</p>
        <h2 class="mt-2 text-3xl font-bold text-green-600">
            {{ $stats['active'] }}
        </h2>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Stock bajo</p>
        <h2 class="mt-2 text-3xl font-bold text-yellow-600">
            {{ $stats['low_stock'] }}
        </h2>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <p class="text-sm text-gray-500">Agotados</p>
        <h2 class="mt-2 text-3xl font-bold text-red-600">
            {{ $stats['out_stock'] }}
        </h2>
    </div>

</div>

<div class="rounded-xl bg-white p-6 shadow-sm">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-4 border-b border-gray-100 pb-6 md:flex-row md:items-center md:justify-between">

        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Catálogo de productos
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Productos encontrados: {{ $products->total() }}
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white hover:bg-emerald-700">

            <i data-lucide="plus" class="h-5 w-5"></i>

            Registrar producto
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET"
          action="{{ route('admin.products.index') }}"
          class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">

        {{-- Buscar --}}
        <div class="xl:col-span-2">
            <label for="search"
                   class="mb-2 block text-sm font-medium text-gray-700">
                Buscar
            </label>

            <input type="text"
                   id="search"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Nombre, código o código de barras"
                   class="w-full rounded-lg border-gray-300">
        </div>

        {{-- Categoría --}}
        <div>
            <label for="category"
                   class="mb-2 block text-sm font-medium text-gray-700">
                Categoría
            </label>

            <select id="category"
                    name="category"
                    class="w-full rounded-lg border-gray-300">

                <option value="">Todas</option>

                @foreach ($categories as $categoryOption)
                    <option value="{{ $categoryOption->id }}"
                        @selected((int) $category === $categoryOption->id)>

                        {{ $categoryOption->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Marca --}}
        <div>
            <label for="brand"
                   class="mb-2 block text-sm font-medium text-gray-700">
                Marca
            </label>

            <select id="brand"
                    name="brand"
                    class="w-full rounded-lg border-gray-300">

                <option value="">Todas</option>

                @foreach ($brands as $brandOption)
                    <option value="{{ $brandOption->id }}"
                        @selected((int) $brand === $brandOption->id)>

                        {{ $brandOption->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Estado --}}
        <div>
            <label for="status"
                   class="mb-2 block text-sm font-medium text-gray-700">
                Estado
            </label>

            <select id="status"
                    name="status"
                    class="w-full rounded-lg border-gray-300">

                <option value="">Todos</option>

                <option value="active"
                    @selected($status === 'active')}>
                    Activos
                </option>

                <option value="inactive"
                    @selected($status === 'inactive')}>
                    Inactivos
                </option>
            </select>
        </div>

        {{-- Existencias --}}
        <div>
            <label for="stock_status"
                   class="mb-2 block text-sm font-medium text-gray-700">
                Existencias
            </label>

            <select id="stock_status"
                    name="stock_status"
                    class="w-full rounded-lg border-gray-300">

                <option value="">Todas</option>

                <option value="available"
                    @selected($stockStatus === 'available')}>
                    Disponibles
                </option>

                <option value="low"
                    @selected($stockStatus === 'low')}>
                    Stock bajo
                </option>

                <option value="out"
                    @selected($stockStatus === 'out')}>
                    Agotados
                </option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex flex-wrap gap-3 md:col-span-2 xl:col-span-6">

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 font-medium text-white hover:bg-slate-700">

                <i data-lucide="search" class="h-4 w-4"></i>

                Aplicar filtros
            </button>

            @if ($search || $category || $brand || $status || $stockStatus)
                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50">

                    <i data-lucide="x" class="h-4 w-4"></i>

                    Limpiar
                </a>
            @endif

        </div>

    </form>

    {{-- La tabla se agregará aquí --}}
@include('admin.products.partials.table')

</div>

@endsection