{{-- Tabla de productos --}}
<div class="mt-8 overflow-x-auto rounded-xl border border-gray-200">

    <table class="w-full min-w-[1100px] border-collapse text-left">

        <thead class="bg-gray-50">
            <tr class="border-b border-gray-200 text-xs font-semibold uppercase tracking-wide text-gray-500">
                <th class="px-5 py-4">Producto</th>
                <th class="px-5 py-4">Categoría y marca</th>
                <th class="px-5 py-4 text-right">Compra</th>
                <th class="px-5 py-4 text-right">Venta</th>
                <th class="px-5 py-4 text-right">Utilidad</th>
                <th class="px-5 py-4 text-center">Existencia</th>
                <th class="px-5 py-4 text-center">Estado</th>
                <th class="px-5 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse ($products as $product)

                @php
                    $purchasePrice = (float) $product->purchase_price;
                    $salePrice = (float) $product->sale_price;
                    $profit = $salePrice - $purchasePrice;

                    $profitPercentage = $purchasePrice > 0
                        ? ($profit / $purchasePrice) * 100
                        : 0;

                    $stock = (float) $product->stock;
                    $minimumStock = (float) $product->minimum_stock;
                @endphp

                <tr class="bg-white transition hover:bg-gray-50">

                    {{-- Producto --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <i data-lucide="package" class="h-5 w-5"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900">
                                    {{ $product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Código: {{ $product->code }}
                                </p>

                                @if ($product->barcode)
                                    <p class="text-xs text-gray-500">
                                        Barras: {{ $product->barcode }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </td>

                    {{-- Categoría y marca --}}
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-800">
                            {{ $product->category?->name ?? 'Sin categoría' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $product->brand?->name ?? 'Sin marca' }}
                        </p>
                    </td>

                    {{-- Precio de compra --}}
                    <td class="px-5 py-4 text-right text-gray-600">
                        ${{ number_format($purchasePrice, 2) }}
                    </td>

                    {{-- Precio de venta --}}
                    <td class="px-5 py-4 text-right font-semibold text-gray-900">
                        ${{ number_format($salePrice, 2) }}
                    </td>

                    {{-- Utilidad --}}
                    <td class="px-5 py-4 text-right">
                        <p class="font-semibold {{ $profit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                            ${{ number_format($profit, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ number_format($profitPercentage, 1) }}%
                        </p>
                    </td>

                    {{-- Existencia --}}
                    <td class="px-5 py-4 text-center">

                        @if ($stock <= 0)

                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Agotado
                            </span>

                        @elseif ($stock <= $minimumStock)

                            <div>
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    {{ number_format($stock, 2) }}
                                </span>

                                <p class="mt-1 text-xs text-amber-700">
                                    Stock bajo
                                </p>
                            </div>

                        @else

                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ number_format($stock, 2) }}
                            </span>

                        @endif

                    </td>

                    {{-- Estado --}}
                    <td class="px-5 py-4 text-center">

                        @if ($product->active)

                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Activo
                            </span>

                        @else

                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                Inactivo
                            </span>

                        @endif

                    </td>

                    {{-- Acciones --}}
                    <td class="px-5 py-4">
                        <div class="flex justify-end gap-2">

                            <x-admin.action-link
    :href="route('admin.products.edit', $product)"
    title="Editar producto"
    variant="primary">

    <i data-lucide="pencil" class="h-4 w-4"></i>

</x-admin.action-link>
                            <x-admin.action-link
    :href="route('admin.inventory.create', ['product' => $product->id])"
    title="Registrar movimiento de inventario"
    variant="success">

    <i data-lucide="package-plus" class="h-4 w-4"></i>

</x-admin.action-link>

                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        title="Eliminar producto"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50">

                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                            <i data-lucide="package-search" class="h-7 w-7"></i>
                        </div>

                        <p class="mt-4 font-semibold text-gray-700">
                            No se encontraron productos
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Cambia los filtros o registra un nuevo producto.
                        </p>

                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

{{-- Paginación --}}
<div class="mt-6">
    {{ $products->links() }}
</div>