<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialsController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('updated_at', 'desc')->get();

        return Inertia::render('Admin/Materials', [
            'materials' => $materials
        ]);
    }

    public function store(Request $request)
    {
        $material = Material::create($request->only(['name']));

        $materials = Material::orderBy('updated_at', 'desc')->get();
        return response()->json($materials);
    }

    public function update(Request $request, Material $material)
    {
        $material->update($request->only('name'));

        $materials = Material::orderBy('updated_at', 'desc')->get();
        return response()->json($materials);
    }

    public function delete(Request $request, Material $material)
    {
        $material->delete();

        $materials = Material::orderBy('updated_at', 'desc')->get();
        return response()->json($materials);
    }
}
