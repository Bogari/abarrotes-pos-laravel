<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->toString();

        $brands = Brand::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($status === 'active', function ($query) {
                $query->where('active', true);
            })
            ->when($status === 'inactive', function ($query) {
                $query->where('active', false);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.brands.index', compact(
            'brands',
            'search',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Brand::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'active' => $request->boolean('active'),
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Marca creada correctamente.');
    }

    public function show(Brand $brand): RedirectResponse
    {
        return redirect()->route('admin.brands.edit', $brand);
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

public function update(
    UpdateBrandRequest $request,
    Brand $brand
): RedirectResponse {
    $data = $request->validated();

    $brand->update([
        'name' => $data['name'],
        'slug' => Str::slug($data['name']),
        'description' => $data['description'] ?? null,
        'active' => $request->boolean('active'),
    ]);

    return redirect()
        ->route('admin.brands.index')
        ->with('success', 'Marca actualizada correctamente.');
}

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Marca eliminada correctamente.');
    }
}