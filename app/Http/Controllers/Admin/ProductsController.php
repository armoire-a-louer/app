<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->get();
        $menCategories = Category::where('sex', Category::HOMME)->get();
        $womenCategories = Category::where('sex', Category::FEMME)->get();
        $brands = Brand::get();
        
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'menCategories' => $menCategories,
            'womenCategories' => $womenCategories,
            'brands' => $brands
        ]);
    }
}
