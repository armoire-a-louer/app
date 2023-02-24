<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->get();
        return Inertia::render('Admin/Products', [
            'products' => $products
        ]);
    }
}
