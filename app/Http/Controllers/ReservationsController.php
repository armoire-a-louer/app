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

        $minStartDate = now()->addDays(Reservation::MIN_DAYS_BEFORE_RESERVATION_STARTS)->setTime(0, 0, 0, 0);
        $maxEndDate = (clone $minStartDate)->addDays(Reservation::MAX_RESERVATION_DAYS);

        if ($startDate < $minStartDate) {
            return response()->json([
                "success" => false,
                "message" => "Date minimale de départ: " . $minStartDate->format('d/m/Y')
            ]);
        }

        if ($endDate > $maxEndDate) {
            return response()->json([
                "success" => false,
                "message" => "Avec la date de départ que vous avez choisi, la date maximale de retour est: " . $maxEndDate->format('d/m/Y')
            ]);
        }

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

            $canReserve["reservations"] = Reservation::getAllBasketReservations(auth()->user());
        }

        return response()->json($canReserve);
    }

    public function deleteReservation(Request $request, $reservationCommonUuid)
    {
        if (!$reservationCommonUuid ) {
            return response()->json([
                "success" => false
            ], 500);
        }

        $reservations =
            Reservation::
            where('reservation_common_uuid', $reservationCommonUuid)
            ->where('user_id', auth()->id())
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->delete();
        }

        $reservations = Reservation::getAllBasketReservations(auth()->user());

        if ($reservations->count() === 0) {
            // return redirect(route('indexopenbasket'));
        }

        return response()->json([
            "reservations" => $reservations,
            "success" => true
        ]);
    }
}
