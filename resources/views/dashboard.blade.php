@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Productos</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Categorías</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Productos con poco stock</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Ventas de hoy</p>
            <p class="mt-2 text-3xl font-bold">$0.00</p>
        </div>

    </div>

    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold">Bienvenido al sistema</h2>

        <p class="mt-2 text-gray-600">
            Desde este panel podrás administrar productos, inventario,
            compras, ventas, clientes y pedidos en línea.
        </p>
    </div>

@endsection