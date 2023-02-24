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
}