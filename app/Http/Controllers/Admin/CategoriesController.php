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
        $menCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::HOMME)->get();
        $womenCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::FEMME)->get();

        return Inertia::render('Admin/Categories', [
            'menCategories' => $menCategories,
            'womenCategories' => $womenCategories
        ]);
    }

    public function store(Request $request)
    {
        $newCategory = Category::create($request->only(['name', 'sex']));
        $newCategory->addMediaFromRequest('image')->toMediaCollection('categories');

        $womenCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::FEMME)->get();
        $menCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::HOMME)->get();
        return response()->json([
            'women_categories' => $womenCategories,
            'men_categories' => $menCategories
        ]);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        $womenCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::FEMME)->get();
        $menCategories = Category::orderBy('updated_at', 'desc')->where('sex', Category::HOMME)->get();
        return response()->json([
            'women_categories' => $womenCategories,
            'men_categories' => $menCategories
        ]);
    }
}