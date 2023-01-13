<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return Inertia::render('Admin/Brands', [
            'brands' => $brands
        ]);
    }
}
