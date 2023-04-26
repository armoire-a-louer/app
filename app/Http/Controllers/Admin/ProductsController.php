<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductSizeColor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        $products = $this->getProductsWithRelations();
        $menCategories = Category::where('sex', Category::HOMME)->get();
        $womenCategories = Category::where('sex', Category::FEMME)->get();
        $brands = Brand::get();
        $materials = Material::get();
        $sizes = ProductSizeColor::SIZES;
        $colors = Color::get();
        
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'menCategories' => $menCategories,
            'womenCategories' => $womenCategories,
            'brands' => $brands,
            'seasons' => Product::SEASONS,
            'materials' => $materials,
            'sizes' => $sizes,
            'colors' => $colors
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only(['name', 'price_per_day', 'category_id', 'brand_id', 'description', 'active', 'season']));
        $product->addMediaFromRequest('image')->toMediaCollection('products');
        $product->materials()->sync($request->input('materials_ids'));

        return response()->json($this->getProductsWithRelations());
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only(['name', 'price_per_day', 'category_id', 'brand_id', 'description', 'active', 'season']));
        if ($request->hasFile('image')) {
            $product->media()->delete();
            $product->addMediaFromRequest('image')->toMediaCollection('products');
        }
        $product->materials()->sync($request->input('materials_ids'));
        $product->save();

        return response()->json($this->getProductsWithRelations());
    }

    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return response()->json($this->getProductsWithRelations());
    }

    public function addArticle()
    {
        // Ajoute dans la table products_sizes_colors
        // Retourne juste success et modale reste ouverte
    }

    public function getProductsWithRelations()
    {
        return Product::orderBy('updated_at', 'desc')->with(['brand', 'category', 'materials', 'items.primaryColor', 'items.secondaryColor'])->get();
    }

    public function deleteItem(Request $request, ProductSizeColor $item)
    {
        $item->delete();

        return response()->json($this->getProductsWithRelations());
    }

    public function storeItem(Request $request)
    {
        dd($request);
        $item = ProductSizeColor::create($request->only(['product_id', 'primary_color_id', 'secondary_color_id', 'size', 'quantity', 'model_size', 'active']));

        // Une photo principale et 3 photos secondaires (min 1, max 3)
    }
}
