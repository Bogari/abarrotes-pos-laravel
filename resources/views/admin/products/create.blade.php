@extends('layouts.admin')

@section('title', 'Nuevo producto')
@section('page-title', 'Nuevo producto')

@section('content')

<div class="mx-auto max-w-5xl rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-6">
        <h2 class="text-xl font-semibold">
            Registrar producto
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Captura la información comercial y las existencias iniciales.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        @include('admin.products._form', [
            'product' => null,
            'buttonText' => 'Guardar producto',
        ])
    </form>

</div>

@endsection