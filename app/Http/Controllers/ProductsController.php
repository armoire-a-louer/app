<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductSizeColor;
use App\Models\UserLike;
use Error;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $otherProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->take(6)->with(['brand'])->get();

        return Inertia::render('Product', [
            'product' => $product,
            'otherProducts' => $otherProducts
        ]);
    }

    public function isProductLiked($productId)
    {
        return response()->json([
            'liked' => UserLike::where('user_id', auth()->id())->where('product_id', $productId)->count() > 0
        ]);
    }

    /**
     * Une seule fonction pour like et dislike
     *
     * @return void
     */
    public function likeOrDislike($productId)
    {
        $like = UserLike::where('user_id', auth()->id())->where('product_id', $productId)->first();

        if ($like) {
            $like->delete();
        } else {
            $like = UserLike::create([
                'user_id' => auth()->id(),
                'product_id' => $productId
            ]);
        }
    }
}
