<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Panel administrativo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        {{-- Menú lateral --}}
        <aside class="w-64 bg-slate-900 text-white hidden md:flex md:flex-col">
            <div class="h-16 flex items-center justify-center border-b border-slate-700">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                    Abarrotes POS
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">

                <a href="{{ route('dashboard') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Dashboard
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Categorías
                </a>

                <a href="{{ route('admin.brands.index') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Marcas
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Productos
                </a>

                <a href="#"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Inventario
                </a>

                <a href="#"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Ventas
                </a>

                <a href="#"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Compras
                </a>

                <a href="#"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-800">
                    Reportes
                </a>

            </nav>
        </aside>

        {{-- Contenido principal --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Barra superior --}}
            <header class="h-16 bg-white border-b flex items-center justify-between px-6">
                <div>
                    <h1 class="font-semibold text-lg">
                        @yield('page-title', 'Panel administrativo')
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="text-sm font-medium text-red-600 hover:text-red-800">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </header>

            {{-- Contenido de cada página --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            {{-- Pie de página --}}
            <footer class="bg-white border-t px-6 py-4 text-sm text-gray-500">
                Sistema de Abarrotes © {{ date('Y') }}
            </footer>

        </div>
    </div>

</body>
</html>