<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Support\Str;
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
            $reservationCommonUuid = Str::uuid();

            foreach ($reservedDays as $day) {
                Reservation::create([
                    'product_size_color_id' => $item->id,
                    'date' => $day->format('Y-m-d'),
                    'status' => Reservation::STATUS_BASKET,
                    'user_id' => auth()->id(),
                    'price' => $price,
                    'reservation_common_uuid' => $reservationCommonUuid
                ]);
            }
        }

        return response()->json($canReserve);
    }
}
