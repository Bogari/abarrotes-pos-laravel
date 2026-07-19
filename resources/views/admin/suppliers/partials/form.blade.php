@csrf

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Nombre comercial *
        </label>

        <input
            type="text"
            name="business_name"
            value="{{ old('business_name', $supplier->business_name ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
            required>

        @error('business_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Contacto
        </label>

        <input
            type="text"
            name="contact_name"
            value="{{ old('contact_name', $supplier->contact_name ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('contact_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            RFC
        </label>

        <input
            type="text"
            name="tax_id"
            value="{{ old('tax_id', $supplier->tax_id ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('tax_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Teléfono
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone', $supplier->phone ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Correo electrónico
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email', $supplier->email ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Estado
        </label>

        <input
            type="text"
            name="state"
            value="{{ old('state', $supplier->state ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('state')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">
            Dirección
        </label>

        <input
            type="text"
            name="address"
            value="{{ old('address', $supplier->address ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Ciudad
        </label>

        <input
            type="text"
            name="city"
            value="{{ old('city', $supplier->city ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('city')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Código postal
        </label>

        <input
            type="text"
            name="postal_code"
            value="{{ old('postal_code', $supplier->postal_code ?? '') }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">

        @error('postal_code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">
            Observaciones
        </label>

        <textarea
            name="notes"
            rows="4"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">{{ old('notes', $supplier->notes ?? '') }}</textarea>

        @error('notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center">

            <input
                type="checkbox"
                name="active"
                value="1"
                class="rounded border-gray-300"
                {{ old('active', $supplier->active ?? true) ? 'checked' : '' }}>

            <span class="ml-2">
                Proveedor activo
            </span>

        </label>
    </div>

</div>