<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ProductSizeColor;
use Illuminate\Support\Facades\Date;

class ReservationsController extends Controller
{
    public function addToBasket(Request $request)
    {
        $startDate = new DateTime($request->get('start_date'));
        $endDate = new DateTime($request->get('end_date'));
        // Trick pour que le DatePeriod prenne en compte le dernier jour (option qui ne fonctionne pas)
        $endDate->modify('+1 day');

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($startDate, $interval, $endDate);

        $reservedDays = [];
        foreach ($period as $date) {
            $reservedDays[] = $date;
        }

        $item = ProductSizeColor::where('id', $request->get('product_size_color_id'))->with("product")->first();

        $canReserve = Reservation::canReserve($startDate, $endDate, $item);

        $price = intval($item->product->price_per_day * 100);

        if ($canReserve["success"]) {
            foreach ($reservedDays as $day) {
                Reservation::create([
                    'product_size_color_id' => $item->id,
                    'date' => $day->format('Y-m-d'),
                    'status' => Reservation::STATUS_BASKET,
                    'user_id' => auth()->id(),
                    'price' => $price
                ]);
            }

            // Ca faut le mettre au moment du paiement !!
            // Il faut créer toutes ces réservations au moment du paiement aussi avec un statut waiting paiement
            // Peut-être mettre ça au moment ou la page checkout se rafraichit ou alors on ecoute un event stripe comme quoi la page de paiement est ouverte ou alors on ecoute quand on clique sur le bouton pour payer et on le fait à ce moment là ...
            // tâche cron aussi pour clean toutes les réservaitons en waiting payment. (toutes les 5 minutes je dirais)

            // foreach ($protectedDays as $day) {
            //     Reservation::create([
            //         'product_size_color_id' => $item->id,
            //         'date' => $day->format('Y-m-d'),
            //         'status' => Reservation::STATUS_PROTECTED,
            //         'user_id' => auth()->id(),
            //         'price' => 0
            //     ]);
            // }
        }

        return response()->json($canReserve);
    }
}
