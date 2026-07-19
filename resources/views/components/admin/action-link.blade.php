@props([
    'href',
    'title',
    'variant' => 'default',
])

@php
    $variants = [
        'default' => 'border-gray-200 text-gray-600 hover:bg-gray-50',
        'primary' => 'border-blue-200 text-blue-600 hover:bg-blue-50',
        'success' => 'border-emerald-200 text-emerald-600 hover:bg-emerald-50',
        'warning' => 'border-amber-200 text-amber-600 hover:bg-amber-50',
        'danger' => 'border-red-200 text-red-600 hover:bg-red-50',
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];
@endphp

<a href="{{ $href }}"
   title="{{ $title }}"
   {{ $attributes->class([
       'inline-flex h-9 w-9 items-center justify-center rounded-lg border transition',
       $variantClasses,
   ]) }}>

    {{ $slot }}

</a>