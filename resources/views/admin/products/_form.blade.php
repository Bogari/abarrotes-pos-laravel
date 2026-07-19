<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    <div>
        <label for="code" class="mb-2 block font-medium">
            Código interno
        </label>

        <input type="text"
               id="code"
               name="code"
               value="{{ old('code', $product?->code) }}"
               class="w-full rounded-lg border-gray-300"
               required>

        @error('code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="barcode" class="mb-2 block font-medium">
            Código de barras
        </label>

        <input type="text"
               id="barcode"
               name="barcode"
               value="{{ old('barcode', $product?->barcode) }}"
               class="w-full rounded-lg border-gray-300">

        @error('barcode')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="name" class="mb-2 block font-medium">
            Nombre del producto
        </label>

        <input type="text"
               id="name"
               name="name"
               value="{{ old('name', $product?->name) }}"
               class="w-full rounded-lg border-gray-300"
               required>

        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="mb-2 block font-medium">
            Categoría
        </label>

        <select id="category_id"
                name="category_id"
                class="w-full rounded-lg border-gray-300"
                required>

            <option value="">Selecciona una categoría</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected((string) old(
                        'category_id',
                        $product?->category_id
                    ) === (string) $category->id)>

                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="brand_id" class="mb-2 block font-medium">
            Marca
        </label>

        <select id="brand_id"
                name="brand_id"
                class="w-full rounded-lg border-gray-300">

            <option value="">Sin marca</option>

            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}"
                    @selected((string) old(
                        'brand_id',
                        $product?->brand_id
                    ) === (string) $brand->id)>

                    {{ $brand->name }}
                </option>
            @endforeach
        </select>

        @error('brand_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="purchase_price" class="mb-2 block font-medium">
            Precio de compra
        </label>

        <input type="number"
               id="purchase_price"
               name="purchase_price"
               value="{{ old('purchase_price', $product?->purchase_price) }}"
               min="0"
               step="0.01"
               class="w-full rounded-lg border-gray-300"
               required>

        @error('purchase_price')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="sale_price" class="mb-2 block font-medium">
            Precio de venta
        </label>

        <input type="number"
               id="sale_price"
               name="sale_price"
               value="{{ old('sale_price', $product?->sale_price) }}"
               min="0"
               step="0.01"
               class="w-full rounded-lg border-gray-300"
               required>

        @error('sale_price')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
    <label for="stock" class="block text-sm font-medium text-gray-700">
        Existencia actual
    </label>

    <input
        id="stock"
        type="number"
        value="{{ $product->stock ?? 0 }}"
        class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 text-gray-600 shadow-sm"
        readonly
    >

    <p class="mt-2 text-xs text-gray-500">
        La existencia se actualiza únicamente mediante movimientos de inventario.
    </p>
</div>

    <div>
        <label for="minimum_stock" class="mb-2 block font-medium">
            Stock mínimo
        </label>

        <input type="number"
               id="minimum_stock"
               name="minimum_stock"
               value="{{ old('minimum_stock', $product?->minimum_stock ?? 0) }}"
               min="0"
               step="0.01"
               class="w-full rounded-lg border-gray-300"
               required>

        @error('minimum_stock')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="mb-2 block font-medium">
            Descripción
        </label>

        <textarea id="description"
                  name="description"
                  rows="4"
                  class="w-full rounded-lg border-gray-300">{{ old('description', $product?->description) }}</textarea>

        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6 flex items-center gap-3">
    <input type="hidden" name="active" value="0">

    <input type="checkbox"
           id="active"
           name="active"
           value="1"
           class="rounded border-gray-300"
           @checked((bool) old('active', $product?->active ?? true))>

    <label for="active">
        Producto activo
    </label>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('admin.products.index') }}"
       class="rounded-lg border border-gray-300 px-4 py-2 hover:bg-gray-50">
        Cancelar
    </a>

    <button type="submit"
            class="rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white hover:bg-emerald-700">
        {{ $buttonText }}
    </button>
</div>