<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('updated_at', 'desc')->get();
        return Inertia::render('Admin/Categories', [
            'categories' => $categories
        ]);
    }
}