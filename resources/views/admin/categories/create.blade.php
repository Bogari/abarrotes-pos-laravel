@extends('layouts.admin')

@section('title', 'Nueva categoría')
@section('page-title', 'Nueva categoría')

@section('content')

    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-sm">

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="mb-5">
                <label for="name" class="mb-2 block font-medium">
                    Nombre
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full rounded-lg border-gray-300"
                       required>

                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="mb-2 block font-medium">
                    Descripción
                </label>

                <textarea id="description"
                          name="description"
                          rows="4"
                          class="w-full rounded-lg border-gray-300">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center gap-3">
                <input type="checkbox"
                       id="active"
                       name="active"
                       value="1"
                       class="rounded border-gray-300"
                       @checked(old('active', true))>

                <label for="active">
                    Categoría activa
                </label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                        class="rounded-lg bg-slate-900 px-4 py-2 font-medium text-white hover:bg-slate-700">
                    Guardar categoría
                </button>
            </div>
        </form>

    </div>

@endsection