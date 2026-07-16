@extends('layouts.admin')

@section('title', 'Nueva marca')
@section('page-title', 'Nueva marca')

@section('content')

<div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            Registrar marca
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Agrega una marca para asociarla posteriormente con los productos.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.brands.store') }}">
        @csrf

        @include('admin.brands._form', [
            'brand' => null,
            'buttonText' => 'Guardar marca',
        ])
    </form>

</div>

@endsection