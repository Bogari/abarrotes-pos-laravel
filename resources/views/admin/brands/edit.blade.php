@extends('layouts.admin')

@section('title', 'Editar marca')
@section('page-title', 'Editar marca')

@section('content')

<div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            Editar {{ $brand->name }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Modifica la información de la marca seleccionada.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.brands.update', $brand) }}">

        @csrf
        @method('PUT')

        @include('admin.brands._form', [
            'brand' => $brand,
            'buttonText' => 'Actualizar marca',
        ])
    </form>

</div>

@endsection