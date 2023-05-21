<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Models;
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
        $models = Models::select(['name', 'id'])->get()->toArray();
        
        return Inertia::render('Admin/Products', [
            'products' => $products,
            'menCategories' => $menCategories,
            'womenCategories' => $womenCategories,
            'brands' => $brands,
            'seasons' => Product::SEASONS,
            'materials' => $materials,
            'sizes' => $sizes,
            'colors' => $colors,
            'models' => $models
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

    public function getProductsWithRelations()
    {
        return Product::orderBy('updated_at', 'desc')->with(['brand', 'category', 'materials', 'items.primaryColor', 'items.secondaryColor', 'items.model'])->get();
    }

    public function deleteItem(Request $request, ProductSizeColor $item)
    {
        $item->delete();

        return response()->json($this->getProductsWithRelations());
    }

    public function storeItem(Request $request)
    {
        $item = ProductSizeColor::create($request->only(['product_id', 'primary_color_id', 'secondary_color_id', 'size', 'quantity', 'model_id', 'model_size', 'active']));

        $item->addMediaFromRequest('image_1')->toMediaCollection('image_1');
        $item->addMediaFromRequest('image_2')->toMediaCollection('image_2');
        $item->addMediaFromRequest('image_3')->toMediaCollection('image_3');
        if ($request->hasFile('image_4')) {
            $item->addMediaFromRequest('image_4')->toMediaCollection('image_4');
        }

        $products = $this->getProductsWithRelations();

        $item = ProductSizeColor::with(['primaryColor', 'secondaryColor', 'model'])->find($item->id);

        return response()->json([
            'item' => $item,
            'products' => $products
        ]);
    }

    public function updateItem(Request $request, ProductSizeColor $item)
    {
        $item->update($request->only(['primary_color_id', 'secondary_color_id', 'size', 'quantity', 'model_id', 'model_size', 'active']));
        $item->save();

        if ($request->hasFile('image_1')) {
            $item->clearMediaCollection('image_1');
            $item->addMediaFromRequest('image_1')->toMediaCollection('image_1');
        }
        if ($request->hasFile('image_2')) {
            $item->clearMediaCollection('image_2');
            $item->addMediaFromRequest('image_2')->toMediaCollection('image_2');
        }
        if ($request->hasFile('image_3')) {
            $item->clearMediaCollection('image_3');
            $item->addMediaFromRequest('image_3')->toMediaCollection('image_3');
        }
        if ($request->hasFile('image_4')) {
            $item->clearMediaCollection('image_4');
            $item->addMediaFromRequest('image_4')->toMediaCollection('image_4');
        }

        $items = ProductSizeColor::where('product_id', $item->product_id)->with(['primaryColor', 'secondaryColor', 'model'])->get();
        
        return response()->json($items);
    }
}
