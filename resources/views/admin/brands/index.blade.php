@extends('layouts.admin')

@section('title', 'Marcas')
@section('page-title', 'Marcas')

@section('content')

<div class="rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Listado de marcas
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Administra las marcas disponibles para los productos.
            </p>
        </div>

        <a href="{{ route('admin.brands.create') }}"
           class="rounded-lg bg-emerald-600 px-4 py-2 text-center font-medium text-white hover:bg-emerald-700">
            Nueva marca
        </a>
    </div>

    <form method="GET"
          action="{{ route('admin.brands.index') }}"
          class="mb-6 grid grid-cols-1 gap-3 md:grid-cols-4">

        <input type="text"
               name="search"
               value="{{ $search }}"
               placeholder="Buscar marca..."
               class="rounded-lg border-gray-300 md:col-span-2">

        <select name="status"
                class="rounded-lg border-gray-300">

            <option value="">Todos los estados</option>

            <option value="active" @selected($status === 'active')>
                Activas
            </option>

            <option value="inactive" @selected($status === 'inactive')>
                Inactivas
            </option>
        </select>

        <div class="flex gap-2">
            <button type="submit"
                    class="flex-1 rounded-lg bg-slate-900 px-4 py-2 font-medium text-white hover:bg-slate-700">
                Filtrar
            </button>

            @if ($search || $status)
                <a href="{{ route('admin.brands.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 hover:bg-gray-50">
                    Limpiar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="border-b bg-gray-50 text-sm text-gray-600">
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($brands as $brand)
                    <tr class="border-b">
                        <td class="px-4 py-4 font-medium">
                            {{ $brand->name }}
                        </td>

                        <td class="px-4 py-4 text-gray-600">
                            {{ $brand->description ?: 'Sin descripción' }}
                        </td>

                        <td class="px-4 py-4">
                            @if ($brand->active)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Activa
                                </span>
                            @else
                                <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700">
                                    Inactiva
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('admin.brands.edit', $brand) }}"
                               class="font-medium text-blue-600 hover:text-blue-800">
                                Editar
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.brands.destroy', $brand) }}"
                                  class="ml-3 inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta marca?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="font-medium text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-4 py-10 text-center text-gray-500">
                            No hay marcas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $brands->links() }}
    </div>

</div>

@endsection