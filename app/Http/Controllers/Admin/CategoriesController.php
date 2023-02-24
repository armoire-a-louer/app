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
        $menCategories = Category::where('sex', Category::HOMME)->get();
        $womenCategories = Category::where('sex', Category::HOMME)->get();

        return Inertia::render('Admin/Categories', [
            'menCategories' => $menCategories,
            'womenCategories' => $womenCategories
        ]);
    }

    public function store()
    {
        
    }
}