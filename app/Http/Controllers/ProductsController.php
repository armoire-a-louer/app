<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductSizeColor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {

    }

    public function view(Product $product)
    {
        $product->load([
            "items.primaryColor",
            "items.model",
            "brand:id,name",
            "category:id,name",
            "ratings.user:id,firstname,lastname"
        ]);

        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }
}
