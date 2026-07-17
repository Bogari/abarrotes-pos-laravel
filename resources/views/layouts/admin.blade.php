<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Panel administrativo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen md:flex">

    {{-- Menú lateral --}}
    <aside class="hidden w-72 flex-col bg-slate-950 text-white md:flex">

        {{-- Logotipo --}}
        <div class="flex h-20 items-center border-b border-slate-800 px-6">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500">
                <i data-lucide="shopping-basket" class="h-6 w-6"></i>
            </div>

            <div class="ml-3">
                <p class="font-bold">Abarrotes POS</p>
                <p class="text-xs text-slate-400">Panel administrativo</p>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                General
            </p>

            <a href="{{ route('dashboard') }}"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3
               {{ request()->routeIs('dashboard')
                    ? 'bg-emerald-500 text-white'
                    : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
                <span>Dashboard</span>
            </a>

            <p class="mb-3 mt-7 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Inventario
            </p>

            <a href="{{ route('admin.products.index') }}"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3
               {{ request()->routeIs('admin.products.*')
                    ? 'bg-emerald-500 text-white'
                    : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

                <i data-lucide="package" class="h-5 w-5"></i>
                <span>Productos</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3
               {{ request()->routeIs('admin.categories.*')
                    ? 'bg-emerald-500 text-white'
                    : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

                <i data-lucide="folder-tree" class="h-5 w-5"></i>
                <span>Categorías</span>
            </a>

            <a href="{{ route('admin.brands.index') }}"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3
               {{ request()->routeIs('admin.brands.*')
                    ? 'bg-emerald-500 text-white'
                    : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

                <i data-lucide="tags" class="h-5 w-5"></i>
                <span>Marcas</span>
            </a>

            <a href="{{ route('admin.inventory.index') }}"
   class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 transition
   {{ request()->routeIs('admin.inventory.*')
       ? 'bg-emerald-500 text-white'
       : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">

    <i data-lucide="boxes" class="h-5 w-5"></i>

    <span>Existencias</span>
</a>

            <p class="mb-3 mt-7 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Operaciones
            </p>

            <a href="#"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-slate-300 hover:bg-slate-900 hover:text-white">

                <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                <span>Ventas</span>
            </a>

            <a href="#"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-slate-300 hover:bg-slate-900 hover:text-white">

                <i data-lucide="truck" class="h-5 w-5"></i>
                <span>Compras</span>
            </a>

            <a href="#"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-slate-300 hover:bg-slate-900 hover:text-white">

                <i data-lucide="users" class="h-5 w-5"></i>
                <span>Clientes</span>
            </a>

            <a href="#"
               class="mb-1 flex items-center gap-3 rounded-lg px-3 py-3 text-slate-300 hover:bg-slate-900 hover:text-white">

                <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                <span>Reportes</span>
            </a>

        </nav>

        {{-- Usuario --}}
        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-slate-900 p-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate text-xs text-slate-400">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>

    </aside>

    {{-- Área principal --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Encabezado --}}
        <header class="flex h-20 items-center justify-between border-b bg-white px-6 shadow-sm">

            <div>
                <p class="text-sm text-gray-500">Administración</p>

                <h1 class="text-xl font-bold text-gray-900">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-4">

                <button type="button"
                        class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">

                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </header>

        {{-- Contenido --}}
        <main class="flex-1 p-6 lg:p-8">

            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    <i data-lucide="circle-check" class="h-5 w-5"></i>

                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')

        </main>

        {{-- Pie --}}
        <footer class="border-t bg-white px-6 py-4 text-center text-sm text-gray-500">
            Abarrotes POS © {{ date('Y') }}
        </footer>

    </div>
</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>