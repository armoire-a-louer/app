<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Models;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModelsController extends Controller
{
    public function index()
    {
        $models = Models::orderBy('updated_at', 'desc')->get();

        return Inertia::render('Admin/Models', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $model = Models::create($request->only(['name', 'size']));
        $model->addMediaFromRequest('image')->toMediaCollection('image');

        $models = Models::orderBy('updated_at', 'desc')->get();
        return response()->json($models);
    }

    public function update(Request $request, Models $model)
    {
        $model->update($request->only(['name', 'size']));
        if ($request->hasFile('image')) {
            $model->media()->delete();
            $model->addMediaFromRequest('image')->toMediaCollection('image');
        }

        $models = Models::orderBy('updated_at', 'desc')->get();
        return response()->json($models);
    }

    public function delete(Request $request, Models $model)
    {
        $model->delete();

        $models = Models::orderBy('updated_at', 'desc')->get();
        return response()->json($models);
    }
}
