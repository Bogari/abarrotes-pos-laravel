@extends('layouts.admin')

@section('title', 'Editar producto')
@section('page-title', 'Editar producto')

@section('content')

<div class="mx-auto max-w-5xl rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-6">
        <h2 class="text-xl font-semibold">
            Editar {{ $product->name }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Modifica la información del producto seleccionado.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.products.update', $product) }}">

        @csrf
        @method('PUT')

        @include('admin.products._form', [
            'product' => $product,
            'buttonText' => 'Actualizar producto',
        ])
    </form>

</div>

@endsection