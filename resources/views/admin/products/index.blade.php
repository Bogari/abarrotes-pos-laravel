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
{{-- Tabla de productos --}}
<div class="mt-8 overflow-x-auto rounded-xl border border-gray-200">

    <table class="w-full min-w-[1100px] border-collapse text-left">

        <thead class="bg-gray-50">
            <tr class="border-b border-gray-200 text-xs font-semibold uppercase tracking-wide text-gray-500">
                <th class="px-5 py-4">Producto</th>
                <th class="px-5 py-4">Categoría y marca</th>
                <th class="px-5 py-4 text-right">Compra</th>
                <th class="px-5 py-4 text-right">Venta</th>
                <th class="px-5 py-4 text-right">Utilidad</th>
                <th class="px-5 py-4 text-center">Existencia</th>
                <th class="px-5 py-4 text-center">Estado</th>
                <th class="px-5 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse ($products as $product)

                @php
                    $purchasePrice = (float) $product->purchase_price;
                    $salePrice = (float) $product->sale_price;
                    $profit = $salePrice - $purchasePrice;

                    $profitPercentage = $purchasePrice > 0
                        ? ($profit / $purchasePrice) * 100
                        : 0;

                    $stock = (float) $product->stock;
                    $minimumStock = (float) $product->minimum_stock;
                @endphp

                <tr class="bg-white transition hover:bg-gray-50">

                    {{-- Producto --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <i data-lucide="package" class="h-5 w-5"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900">
                                    {{ $product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Código: {{ $product->code }}
                                </p>

                                @if ($product->barcode)
                                    <p class="text-xs text-gray-500">
                                        Barras: {{ $product->barcode }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </td>

                    {{-- Categoría y marca --}}
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-800">
                            {{ $product->category?->name ?? 'Sin categoría' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $product->brand?->name ?? 'Sin marca' }}
                        </p>
                    </td>

                    {{-- Precio de compra --}}
                    <td class="px-5 py-4 text-right text-gray-600">
                        ${{ number_format($purchasePrice, 2) }}
                    </td>

                    {{-- Precio de venta --}}
                    <td class="px-5 py-4 text-right font-semibold text-gray-900">
                        ${{ number_format($salePrice, 2) }}
                    </td>

                    {{-- Utilidad --}}
                    <td class="px-5 py-4 text-right">
                        <p class="font-semibold {{ $profit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                            ${{ number_format($profit, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ number_format($profitPercentage, 1) }}%
                        </p>
                    </td>

                    {{-- Existencia --}}
                    <td class="px-5 py-4 text-center">

                        @if ($stock <= 0)

                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Agotado
                            </span>

                        @elseif ($stock <= $minimumStock)

                            <div>
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    {{ number_format($stock, 2) }}
                                </span>

                                <p class="mt-1 text-xs text-amber-700">
                                    Stock bajo
                                </p>
                            </div>

                        @else

                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ number_format($stock, 2) }}
                            </span>

                        @endif

                    </td>

                    {{-- Estado --}}
                    <td class="px-5 py-4 text-center">

                        @if ($product->active)

                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Activo
                            </span>

                        @else

                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                Inactivo
                            </span>

                        @endif

                    </td>

                    {{-- Acciones --}}
                    <td class="px-5 py-4">
                        <div class="flex justify-end gap-2">

                            <a href="{{ route('admin.products.edit', $product) }}"
                               title="Editar producto"
                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 text-blue-600 transition hover:bg-blue-50">

                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        title="Eliminar producto"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50">

                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                            <i data-lucide="package-search" class="h-7 w-7"></i>
                        </div>

                        <p class="mt-4 font-semibold text-gray-700">
                            No se encontraron productos
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Cambia los filtros o registra un nuevo producto.
                        </p>

                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

{{-- Paginación --}}
<div class="mt-6">
    {{ $products->links() }}
</div>

</div>

@endsection