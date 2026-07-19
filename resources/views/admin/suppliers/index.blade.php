@extends('layouts.admin')

@section('title', 'Proveedores')

@section('content')

<div class="space-y-6">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Proveedores
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Administra las empresas y personas que abastecen mercancía.
            </p>
        </div>

        <a
            href="{{ route('admin.suppliers.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Nuevo proveedor
        </a>

    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- KPIs --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total de proveedores</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">
                {{ $totalSuppliers }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Proveedores activos</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600">
                {{ $activeSuppliers }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Proveedores inactivos</p>
            <p class="mt-2 text-2xl font-bold text-gray-500">
                {{ $inactiveSuppliers }}
            </p>
        </div>

    </div>

    {{-- Filtros --}}
    <form
        method="GET"
        action="{{ route('admin.suppliers.index') }}"
        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
    >
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700">
                    Buscar proveedor
                </label>

                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nombre, RFC, teléfono, correo..."
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                >
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Estado
                </label>

                <select
                    id="status"
                    name="status"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                >
                    <option value="">Todos</option>
                    <option value="active" @selected(request('status') === 'active')>
                        Activos
                    </option>
                    <option value="inactive" @selected(request('status') === 'inactive')>
                        Inactivos
                    </option>
                </select>
            </div>

        </div>

        <div class="mt-4 flex flex-wrap justify-end gap-3">

            <a
                href="{{ route('admin.suppliers.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Limpiar
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
            >
                <i data-lucide="search" class="h-4 w-4"></i>
                Buscar
            </button>

        </div>
    </form>

    {{-- Tabla --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Proveedor
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Contacto
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            RFC
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Estado
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($suppliers as $supplier)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-900">
                                    {{ $supplier->business_name }}
                                </p>

                                @if ($supplier->email)
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $supplier->email }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p>{{ $supplier->contact_name ?: 'Sin contacto' }}</p>
                                <p class="mt-1 text-gray-500">
                                    {{ $supplier->phone ?: 'Sin teléfono' }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $supplier->tax_id ?: 'Sin RFC' }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($supplier->active)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">

                                    <x-admin.action-link
                                        :href="route('admin.suppliers.edit', $supplier)"
                                        title="Editar proveedor"
                                        variant="primary"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </x-admin.action-link>

                                    <form
                                        action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar este proveedor?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Eliminar proveedor"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i data-lucide="truck" class="mx-auto h-10 w-10 text-gray-300"></i>

                                <p class="mt-3 font-medium text-gray-700">
                                    No se encontraron proveedores
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Registra el primer proveedor para comenzar.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($suppliers->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $suppliers->links() }}
            </div>
        @endif

    </div>

</div>

@endsection