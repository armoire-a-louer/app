<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductSizeColor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = Product::query()->scopes('active')->with(["brand"]);

        if ($request->query('search')) {
            $products =
                $products
                ->where(function ($q) use ($request){
                    $q->where('name', 'LIKE', '%' . $request->query('search') . '%');
                });
        }

        if ($request->query('brands')) {
            $products = $products->whereIn('brand_id', $request->query('brands'));
        }

        if ($request->query('colors')) {
            $products = $products->whereHas('items', function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->whereIn('primary_color_id', $request->query('colors'))
                        ->orWhereIn('secondary_color_id', $request->query('colors'));
                });
            });
        }

        if ($request->query('sexes')) {
            $products = $products->whereHas('category', function ($query) use ($request) {
                $query->whereIn('categories.sex', $request->query('sexes'));
            });
        }

        if ($request->query('categories')) {
            $products = $products->whereIn('category_id', $request->query('categories'));
        }

        if ($request->query('sort')) {
            $sort = explode(',', $request->query('sort'));
            $column = $sort[0];
            $direction = $sort[1];

            $products = $products->orderBy($column, $direction);
        } else {
            $products = $products->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(6);

        $categories = Category::all();
        $colors = Color::all();
        $sexes = [Category::HOMME, Category::FEMME];
        $brands = Brand::all();

        return Inertia::render('Search', [
            "products" => $products,
            "categories" => $categories,
            "colors" => $colors,
            "sexes" => $sexes,
            "brands" => $brands,
            "queryParams" => $request->query()
        ]);
    }
}
