@csrf

{{-- Errores generales --}}
@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">
            Revisa la información del formulario.
        </p>

        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">

    {{-- Información general --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="font-semibold text-gray-900">
                Información de la compra
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Selecciona el proveedor y captura los datos generales.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

            {{-- Proveedor --}}
            <div>
                <label
                    for="supplier_id"
                    class="block text-sm font-medium text-gray-700"
                >
                    Proveedor *
                </label>

                <select
                    id="supplier_id"
                    name="supplier_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    required
                >
                    <option value="">Selecciona un proveedor</option>

                    @foreach ($suppliers as $supplier)
                        <option
                            value="{{ $supplier->id }}"
                            @selected(old('supplier_id') == $supplier->id)
                        >
                            {{ $supplier->business_name }}
                        </option>
                    @endforeach
                </select>

                @error('supplier_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Fecha --}}
            <div>
                <label
                    for="purchase_date"
                    class="block text-sm font-medium text-gray-700"
                >
                    Fecha de compra *
                </label>

                <input
                    id="purchase_date"
                    type="date"
                    name="purchase_date"
                    value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    required
                >

                @error('purchase_date')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Factura --}}
            <div>
                <label
                    for="invoice_number"
                    class="block text-sm font-medium text-gray-700"
                >
                    Factura o referencia del proveedor
                </label>

                <input
                    id="invoice_number"
                    type="text"
                    name="invoice_number"
                    value="{{ old('invoice_number') }}"
                    placeholder="Ej. FAC-28451"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                >

                @error('invoice_number')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Impuestos --}}
            <div>
                <label
                    for="tax"
                    class="block text-sm font-medium text-gray-700"
                >
                    Impuestos
                </label>

                <input
                    id="tax"
                    type="number"
                    name="tax"
                    value="{{ old('tax', 0) }}"
                    min="0"
                    step="0.01"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                >

                @error('tax')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Observaciones --}}
            <div class="md:col-span-2">
                <label
                    for="notes"
                    class="block text-sm font-medium text-gray-700"
                >
                    Observaciones
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    placeholder="Información adicional de la compra..."
                >{{ old('notes') }}</textarea>

                @error('notes')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

    </div>

    {{-- Productos --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-gray-900">
                    Productos comprados
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Agrega los productos recibidos, sus cantidades y costos.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">

    <button
        type="button"
        id="open-product-modal-button"
        class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
    >
        <i data-lucide="package-plus" class="h-4 w-4"></i>
        Nuevo producto
    </button>

    <button
        type="button"
        id="add-item-button"
        class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
    >
        <i data-lucide="plus" class="h-4 w-4"></i>
        Agregar producto
    </button>

</div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-[900px] w-full">

                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Producto
                        </th>

                        <th class="w-36 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Cantidad
                        </th>

                        <th class="w-40 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Costo unitario
                        </th>

                        <th class="w-40 px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Subtotal
                        </th>

                        <th class="w-20 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Acción
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="purchase-items"
                    class="divide-y divide-gray-100"
                ></tbody>

            </table>

        </div>

        <div
            id="empty-items-message"
            class="px-6 py-12 text-center"
        >
            <i
                data-lucide="package-plus"
                class="mx-auto h-10 w-10 text-gray-300"
            ></i>

            <p class="mt-3 font-medium text-gray-700">
                No has agregado productos
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Presiona “Agregar producto” para crear la primera línea.
            </p>
        </div>

        {{-- Totales --}}
        <div class="border-t border-gray-200 bg-gray-50 px-6 py-5">

            <div class="ml-auto max-w-sm space-y-3">

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>

                    <span
                        id="purchase-subtotal"
                        class="font-semibold text-gray-900"
                    >
                        $0.00
                    </span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Impuestos</span>

                    <span
                        id="purchase-tax"
                        class="font-semibold text-gray-900"
                    >
                        $0.00
                    </span>
                </div>

                <div class="flex items-center justify-between border-t border-gray-300 pt-3">
                    <span class="font-semibold text-gray-900">
                        Total
                    </span>

                    <span
                        id="purchase-total"
                        class="text-xl font-bold text-gray-900"
                    >
                        $0.00
                    </span>
                </div>

            </div>

        </div>

    </div>

    {{-- Botones --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('admin.purchases.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
        >
            Cancelar
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
        >
            <i data-lucide="save" class="h-4 w-4"></i>
            Registrar compra
        </button>

    </div>

</div>

{{-- Plantilla de una fila --}}
<template id="purchase-item-template">

    <tr class="purchase-item-row">

        <td class="px-4 py-4">

    <select
        data-field="product_id"
        class="product-select block w-full rounded-lg border-gray-300 text-sm shadow-sm"
        required
    >
        <option value="">Selecciona un producto</option>

        @foreach ($products as $product)
            <option
                value="{{ $product->id }}"
                data-cost="{{ $product->purchase_price }}"
                data-stock="{{ $product->stock }}"
            >
                {{ $product->code }} — {{ $product->name }}
            </option>
        @endforeach
    </select>

    <p class="product-stock mt-2 text-xs text-gray-500">
        Existencia actual: —
    </p>

    <p class="duplicate-product-error mt-1 hidden text-xs font-medium text-red-600">
        Este producto ya fue agregado.
    </p>

</td>

        <td class="px-4 py-4">

            <input
                data-field="quantity"
                type="number"
                min="0.001"
                step="0.001"
                value="1"
                class="quantity-input block w-full rounded-lg border-gray-300 text-sm shadow-sm"
                required
            >

        </td>

        <td class="px-4 py-4">

            <input
                data-field="unit_cost"
                type="number"
                min="0"
                step="0.01"
                value="0"
                class="unit-cost-input block w-full rounded-lg border-gray-300 text-sm shadow-sm"
                required
            >

        </td>

        <td class="px-4 py-4 text-right">

            <span class="line-subtotal font-semibold text-gray-900">
                $0.00
            </span>

        </td>

        <td class="px-4 py-4 text-center">

            <button
                type="button"
                class="remove-item-button inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50"
                title="Eliminar producto"
            >
                <i data-lucide="trash-2" class="h-4 w-4"></i>
            </button>

        </td>

    </tr>

</template>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const itemsContainer = document.getElementById('purchase-items');
    const template = document.getElementById('purchase-item-template');
    const addButton = document.getElementById('add-item-button');
    const emptyMessage = document.getElementById('empty-items-message');
    const taxInput = document.getElementById('tax');

    const subtotalElement = document.getElementById('purchase-subtotal');
    const taxElement = document.getElementById('purchase-tax');
    const totalElement = document.getElementById('purchase-total');
    const productModal = document.getElementById('product-modal');
const openProductModalButton =
    document.getElementById('open-product-modal-button');
const closeProductModalButton =
    document.getElementById('close-product-modal-button');
const cancelProductModalButton =
    document.getElementById('cancel-product-modal-button');
const quickProductForm =
    document.getElementById('quick-product-form');
const quickProductErrors =
    document.getElementById('quick-product-errors');
const saveQuickProductButton =
    document.getElementById('save-quick-product-button');

    const currencyFormatter = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
    });

    function updateFieldNames() {
        const rows = itemsContainer.querySelectorAll('.purchase-item-row');

        rows.forEach((row, index) => {
            row.querySelector('[data-field="product_id"]').name =
                `items[${index}][product_id]`;

            row.querySelector('[data-field="quantity"]').name =
                `items[${index}][quantity]`;

            row.querySelector('[data-field="unit_cost"]').name =
                `items[${index}][unit_cost]`;
        });

        emptyMessage.classList.toggle('hidden', rows.length > 0);
    }

    function calculateTotals() {
        let subtotal = 0;

        itemsContainer
            .querySelectorAll('.purchase-item-row')
            .forEach((row) => {
                const quantity =
                    parseFloat(row.querySelector('.quantity-input').value) || 0;

                const unitCost =
                    parseFloat(row.querySelector('.unit-cost-input').value) || 0;

                const lineSubtotal = quantity * unitCost;

                row.querySelector('.line-subtotal').textContent =
                    currencyFormatter.format(lineSubtotal);

                subtotal += lineSubtotal;
            });

        const tax = parseFloat(taxInput.value) || 0;
        const total = subtotal + tax;

        subtotalElement.textContent = currencyFormatter.format(subtotal);
        taxElement.textContent = currencyFormatter.format(tax);
        totalElement.textContent = currencyFormatter.format(total);
    }

    function productAlreadySelected(productId, currentSelect) {
    if (!productId) {
        return false;
    }

    return Array.from(
        itemsContainer.querySelectorAll('.product-select')
    ).some((select) => {
        return select !== currentSelect && select.value === productId;
    });
}
    function addItem(item = null) {
        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('.purchase-item-row');

        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const unitCostInput = row.querySelector('.unit-cost-input');
        const removeButton = row.querySelector('.remove-item-button');
        const stockText = row.querySelector('.product-stock');
        const duplicateError = row.querySelector('.duplicate-product-error');

        if (item) {
    productSelect.value = item.product_id ?? '';
    quantityInput.value = item.quantity ?? 1;
    unitCostInput.value = item.unit_cost ?? 0;

    const selectedOption =
        productSelect.options[productSelect.selectedIndex];

    if (selectedOption && productSelect.value) {
        const stock = parseFloat(selectedOption.dataset.stock || 0);

        stockText.textContent =
            `Existencia actual: ${stock.toLocaleString('es-MX')}`;
    }
}

        productSelect.addEventListener('change', () => {
    const selectedProductId = productSelect.value;
    const selectedOption =
        productSelect.options[productSelect.selectedIndex];

    duplicateError.classList.add('hidden');

    if (productAlreadySelected(selectedProductId, productSelect)) {
        duplicateError.classList.remove('hidden');

        productSelect.value = '';
        unitCostInput.value = '0.00';
        stockText.textContent = 'Existencia actual: —';

        calculateTotals();
        return;
    }

    if (selectedOption && selectedProductId) {
        const cost = parseFloat(selectedOption.dataset.cost || 0);
        const stock = parseFloat(selectedOption.dataset.stock || 0);

        unitCostInput.value = cost.toFixed(2);
        stockText.textContent =
            `Existencia actual: ${stock.toLocaleString('es-MX')}`;
    } else {
        unitCostInput.value = '0.00';
        stockText.textContent = 'Existencia actual: —';
    }

    calculateTotals();
});

        quantityInput.addEventListener('input', calculateTotals);
        unitCostInput.addEventListener('input', calculateTotals);

        removeButton.addEventListener('click', () => {
            row.remove();
            updateFieldNames();
            calculateTotals();
        });

        itemsContainer.appendChild(fragment);

        updateFieldNames();
        calculateTotals();

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    addButton.addEventListener('click', () => addItem());

    function openProductModal() {
    quickProductErrors.classList.add('hidden');
    quickProductErrors.innerHTML = '';

    productModal.classList.remove('hidden');
    productModal.classList.add('flex');
    productModal.setAttribute('aria-hidden', 'false');

    document.body.classList.add('overflow-hidden');
}

function closeProductModal() {
    productModal.classList.add('hidden');
    productModal.classList.remove('flex');
    productModal.setAttribute('aria-hidden', 'true');

    document.body.classList.remove('overflow-hidden');
}

function addProductToAllSelects(product) {
    const optionText = `${product.code} — ${product.name}`;

    document
        .querySelectorAll('.product-select')
        .forEach((select) => {
            const option = new Option(optionText, product.id);

            option.dataset.cost = product.purchase_price ?? 0;
            option.dataset.stock = product.stock ?? 0;

            select.add(option);
        });
}

function selectProductInLastRow(product) {
    let rows =
        itemsContainer.querySelectorAll('.purchase-item-row');

    if (rows.length === 0) {
        addItem();
        rows = itemsContainer.querySelectorAll('.purchase-item-row');
    }

    const lastRow = rows[rows.length - 1];
    const productSelect =
        lastRow.querySelector('.product-select');

    productSelect.value = String(product.id);
    productSelect.dispatchEvent(new Event('change'));
}

    taxInput.addEventListener('input', calculateTotals);

    const oldItems = @json(old('items', []));

    if (oldItems.length > 0) {
        oldItems.forEach((item) => addItem(item));
    } else {
        addItem();
    }

    openProductModalButton.addEventListener(
    'click',
    openProductModal
);

closeProductModalButton.addEventListener(
    'click',
    closeProductModal
);

cancelProductModalButton.addEventListener(
    'click',
    closeProductModal
);

productModal.addEventListener('click', (event) => {
    if (event.target === productModal) {
        closeProductModal();
    }
});

document.addEventListener('keydown', (event) => {
    if (
        event.key === 'Escape'
        && !productModal.classList.contains('hidden')
    ) {
        closeProductModal();
    }
});

    quickProductForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    quickProductErrors.classList.add('hidden');
    quickProductErrors.innerHTML = '';

    saveQuickProductButton.disabled = true;

    const originalButtonContent =
        saveQuickProductButton.innerHTML;

    saveQuickProductButton.textContent = 'Guardando...';

    try {
        const response = await fetch(
            @json(route('admin.products.quick-store')),
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN':
                        quickProductForm.querySelector(
                            'input[name="_token"]'
                        ).value,
                },
                body: new FormData(quickProductForm),
            }
        );

        const result = await response.json();

        if (!response.ok) {
            if (response.status === 422 && result.errors) {
                const messages = Object.values(result.errors).flat();

                quickProductErrors.innerHTML = `
                    <p class="font-semibold">
                        Revisa la información del producto:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        ${messages
                            .map((message) => `<li>${message}</li>`)
                            .join('')}
                    </ul>
                `;

                quickProductErrors.classList.remove('hidden');
                return;
            }

            throw new Error(
                result.message
                || 'No fue posible guardar el producto.'
            );
        }

        addProductToAllSelects(result.product);
        selectProductInLastRow(result.product);

        quickProductForm.reset();

        const activeCheckbox =
            quickProductForm.querySelector('input[name="active"]');

        if (activeCheckbox) {
            activeCheckbox.checked = true;
        }

        closeProductModal();
    } catch (error) {
        quickProductErrors.textContent =
            error.message
            || 'Ocurrió un error inesperado.';

        quickProductErrors.classList.remove('hidden');
    } finally {
        saveQuickProductButton.disabled = false;
        saveQuickProductButton.innerHTML = originalButtonContent;

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
});

});
</script>