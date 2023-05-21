<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColorsController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('updated_at', 'desc')->get();
        return Inertia::render('Admin/Colors', [
            'colors' => $colors
        ]);
    }

    public function store(Request $request)
    {
        $color = Color::create($request->only(['name', 'hex_code']));

        $colors = Color::orderBy('updated_at', 'desc')->get();
        return response()->json($colors);
    }

    public function delete(Request $request, Color $color)
    {
        $color->delete();

        $colors = Color::orderBy('updated_at', 'desc')->get();
        return response()->json($colors);
    }

    public function update(Request $request, Color $color)
    {
        $color->update($request->only('name', 'hex_code'));

        $colors = Color::orderBy('updated_at', 'desc')->get();
        return response()->json($colors);
    }
}