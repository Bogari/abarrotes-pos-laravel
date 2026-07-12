@extends('layouts.admin')

@section('title', 'Categorías')
@section('page-title', 'Categorías')

@section('content')

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold">Listado de categorías</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Administra las categorías utilizadas para organizar los productos.
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
               class="rounded-lg bg-slate-900 px-4 py-2 text-center font-medium text-white hover:bg-slate-700">
                Nueva categoría
            </a>
        </div>

        <form method="GET"
              action="{{ route('admin.categories.index') }}"
              class="mb-6 flex flex-col gap-3 sm:flex-row">

            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Buscar categoría..."
                   class="w-full rounded-lg border-gray-300 sm:max-w-md">

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                Buscar
            </button>

            @if ($search)
                <a href="{{ route('admin.categories.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 text-center hover:bg-gray-50">
                    Limpiar
                </a>
            @endif
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
                    @forelse ($categories as $category)
                        <tr class="border-b">
                            <td class="px-4 py-4 font-medium">
                                {{ $category->name }}
                            </td>

                            <td class="px-4 py-4 text-gray-600">
                                {{ $category->description ?: 'Sin descripción' }}
                            </td>

                            <td class="px-4 py-4">
                                @if ($category->active)
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
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="font-medium text-blue-600 hover:text-blue-800">
                                    Editar
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      class="ml-3 inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">

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
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                No hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>

    </div>

@endsection