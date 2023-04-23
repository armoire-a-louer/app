<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('updated_at', 'desc')->get();
        return Inertia::render('Admin/Brands', [
            'brands' => $brands
        ]);
    }

    public function store(StoreBrandRequest $request)
    {
        $newBrand = Brand::create($request->only(['name', 'active', 'description']));
        $newBrand->addMediaFromRequest('image')->toMediaCollection('brands');

        $brands = Brand::orderBy('updated_at', 'desc')->get();
        return response()->json($brands);
    }

    public function update(UpdateBrandRequest $request, int $id)
    {
        $brand = Brand::find($id);
        $brand->name = $request->get('name');
        $brand->active = $request->get('active');

        if ($request->hasFile('image')) {
            $brand->media()->delete();
            $brand->addMediaFromRequest('image')->toMediaCollection('brands');
        }
        $brand->save();

        $brands = Brand::orderBy('updated_at', 'desc')->get();

        return response()->json($brands);
    }

    public function delete(Request $request, int $id)
    {
        $brand = Brand::find($id);
        $brand->delete();

        $brands = Brand::orderBy('updated_at', 'desc')->get();
        return response()->json($brands);
    }
}
