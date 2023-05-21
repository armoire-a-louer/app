<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $mostRentedProducts = [];

        $reservations =
            Reservation::
            where('status', Reservation::STATUS_PAID)
            ->selectRaw('id, product_size_color_id, COUNT(*) as count')
            ->groupBy('product_size_color_id')
            ->with([
                "item.product.brand"
            ])
            ->get();

        foreach ($reservations as $reservation) {
            if (! isset($mostRentedProducts[$reservation->item->product->id])) {
                $mostRentedProducts[$reservation->item->product->id]["product"] = $reservation->item->product;
                $mostRentedProducts[$reservation->item->product->id]["count"] = $reservation->count;
                continue;
            }

            $mostRentedProducts[$reservation->item->product->id]["count"] += $reservation->count;
        }

        usort($mostRentedProducts, function ($a, $b) {
            return $a["count"] > $b["count"];
        });

        $mostRentedProducts = array_map(function ($product) {
            return $product["product"];
        }, $mostRentedProducts);

        return Inertia::render('Index', [
            "openBasket" => $request->query('openBasket') ?? false,
            "mostRentedProducts" => $mostRentedProducts
        ]);
    }

    public function concept()
    {
        return Inertia::render('Concept', [

        ]);
    }
}
