<?php

namespace App\Models;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    public const DAYS_PROTECTED = 9;

    public const STATUS_BASKET = "basket";
    public const STATUS_PAID = "paid";
    // Ce statut vient s'appliquer pour les 9 jours qui suivent la fin de la location.
    public const STATUS_PROTECTED = "protected";
    public const STATUS_TERMINATED = "terminated";
    public const STATUS_WAITING_PAYMENT = "waiting_payment";
    public const STATUS_PROTECTED_WAITING_PAYMENT = "protected_waiting_payment";

    public const MIN_DAYS_BEFORE_RESERVATION_STARTS = 5;
    public const MAX_RESERVATION_DAYS = 20;

    // AMOUNT MUST BE LIKE THIS 15€99 => 1599

    protected $fillable = ["product_size_color_id", "date", "status", "user_id", "price", "transaction_id", "reservation_common_uuid"];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ProductSizeColor::class, 'product_size_color_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Il faut bien que le $endDate arrive avec un modfify de +1 jour
     * $ignoreUser = si jamais on le coche on va ignorer toutes les réservations de l'utilisateur pour savoir si il peut réserver
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param ProductSizeColor $item
     * @return array
     */
    public static function canReserve(DateTime $startDate, DateTime $endDate, ProductSizeColor $item, $ignoreUser = false): array
    {
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($startDate, $interval, $endDate);

        $reservedDays = [];
        foreach ($period as $date) {
            $reservedDays[] = $date;
        }

        $period = new DatePeriod(clone $endDate, $interval, (clone $endDate)->modify('+' . Reservation::DAYS_PROTECTED . ' day'));

        $protectedDays = [];
        foreach ($period as $date) {
            $protectedDays[] = $date;
        }

        // On va chercher l'item avec ses réservations
        $item =
            ProductSizeColor::
            find($item->id)
            ->load([
                'product',
                'reservations' => function ($q) use ($startDate, $endDate) {
                    $q
                        ->where(function ($query) {
                            $query
                                ->whereIn('status', [
                                    Reservation::STATUS_PAID,
                                    Reservation::STATUS_PROTECTED,
                                    Reservation::STATUS_PROTECTED_WAITING_PAYMENT,
                                    Reservation::STATUS_WAITING_PAYMENT,
                                ])
                                ->orWhere('user_id', auth()->id());
                        })
                        ->where('date', '>=', $startDate->format('Y-m-d'))
                        ->where('date', '<=', $endDate->format('Y-m-d'));
                }
            ]);

        if ($ignoreUser) {
            $item =
                ProductSizeColor::
                find($item->id)
                ->load([
                    'product',
                    'reservations' => function ($q) use ($startDate, $endDate) {
                        $q
                            ->whereIn('status', [
                                Reservation::STATUS_PAID,
                                Reservation::STATUS_PROTECTED,
                                Reservation::STATUS_PROTECTED_WAITING_PAYMENT,
                                Reservation::STATUS_WAITING_PAYMENT,
                            ])
                            ->where('date', '>=', $startDate->format('Y-m-d'))
                            ->where('date', '<=', $endDate->format('Y-m-d'));
                    }
                ]);
        }

        // On crée un tableau: "2023-05-15" => "nombre de réservations ce jour là en int"
        $unavailableDays = [];
        foreach ($item->reservations as $reservation) {
            if (! isset($unavailableDays[$reservation->date])) {
                $unavailableDays[$reservation->date] = 1;
                continue;
            }

            $unavailableDays[$reservation->date]++;
        }

        // On check si un des jours est en stock plein
        // Il faut que tous les jours soient STRICTEMENT inférieurs au stock
        // On ne garde que les jours qui posent problème pour pouvoir les remonter à l'utilisateur
        foreach ($unavailableDays as $unavailableDay => $quantity) {
            if ($quantity < $item->quantity) {
                unset($unavailableDays[$unavailableDay]);
            }
        }

        $success = count($unavailableDays) === 0;

        return [
            "success" => $success,
            "unavailableDays" => array_keys($unavailableDays)
        ];
    }

    public static function canReserveAllBasket(User $user)
    {
        $reservations =
            self::
            where('user_id', $user->id)
            ->whereIn('status', [self::STATUS_BASKET, self::STATUS_WAITING_PAYMENT])
            ->groupBy(['product_size_color_id', 'reservation_common_uuid'])
            ->select(['product_size_color_id', 'user_id', 'reservation_common_uuid'])
            ->selectRaw('MAX(date) as latest_date')
            ->selectRaw('MIN(date) as earliest_date')
            ->get();

        $response = [
            "success" => true,
            "unavailable_days_of_reservation" => []
        ];

        foreach ($reservations as $reservation) {
            $startDate = new DateTime($reservation->earliest_date);
            $endDate = (new DateTime($reservation->latest_date))->modify('+1 day');

            $item = ProductSizeColor::findOrFail($reservation->product_size_color_id);

            $canReserve = self::canReserve($startDate, $endDate, $item, true);

            if (! $canReserve["success"]) {
                $response["success"] = false;
                $response["unavailable_days_of_reservation"][$reservation->reservation_common_uuid] = $canReserve["unavailableDays"];

                $deleteReservations = Reservation::where('reservation_common_uuid', $reservation->reservation_common_uuid)->get();

                foreach ($deleteReservations as $deleteReservation) {
                    $deleteReservation->delete();
                }
            }
        }

        return $response;
    }

    public static function reserveWaitingPayment(User $user): void
    {
        $reservations =
            self::
            where('status', self::STATUS_BASKET)
            ->where('user_id', $user->id)
            ->groupBy(['product_size_color_id', 'reservation_common_uuid'])
            ->select(['product_size_color_id', 'user_id', 'reservation_common_uuid'])
            // ->selectRaw('id, COUNT(*) as count')
            ->selectRaw('MAX(date) as latest_date')
            ->selectRaw('MIN(date) as earliest_date')
            ->get();

        foreach ($reservations as $reservation) {
            $startProtectedDate = (new DateTime($reservation->latest_date))->modify('+1 day');
            $endProtectedDate = (clone $startProtectedDate)->modify('+' . self::DAYS_PROTECTED . 'days');
    
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($startProtectedDate, $interval, $endProtectedDate);
    
            foreach ($period as $date) {
                Reservation::create([
                    'product_size_color_id' => $reservation->product_size_color_id,
                    'date' => $date->format('Y-m-d'),
                    'status' => Reservation::STATUS_PROTECTED_WAITING_PAYMENT,
                    'user_id' => auth()->id(),
                    'price' => 0,
                    'reservation_common_uuid' => $reservation->reservation_common_uuid
                ]);
            }
        }

        $reservations = 
            self::
            where('status', self::STATUS_BASKET)
            ->where('user_id', $user->id)
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->status = Reservation::STATUS_WAITING_PAYMENT;
            $reservation->save();
        }
    }

    public static function getAllBasketReservations(User $user)
    {
        $reservations =
            self::
            whereIn('status', [self::STATUS_BASKET, self::STATUS_WAITING_PAYMENT])
            ->where('user_id', $user->id)
            ->groupBy(['product_size_color_id', 'reservation_common_uuid'])
            ->select(['product_size_color_id', 'user_id', 'reservation_common_uuid'])
            // ->selectRaw('id, COUNT(*) as count')
            ->selectRaw('MAX(date) as latest_date')
            ->selectRaw('MIN(date) as earliest_date')
            ->selectRaw('SUM(price) as total_price')
            ->with([
                "item",
                "item.product:id,brand_id,name",
                "item.product.brand:id,name"
            ])
            ->get();

        return $reservations;
    }

    public static function getAllPaidTransactions(User $user)
    {
        return
            Transaction::
            where('user_id', $user->id)
            ->where('status', Transaction::STATUS_SUCCESS)
            ->with([
                "reservations" => function ($q) {
                    $q->where('status', self::STATUS_PAID)
                        ->groupBy(['product_size_color_id', 'reservation_common_uuid'])
                        ->select(['product_size_color_id', 'user_id', 'reservation_common_uuid', 'transaction_id'])
                        ->selectRaw('MAX(date) as latest_date')
                        ->selectRaw('MIN(date) as earliest_date')
                        ->selectRaw('COUNT(*) as count')
                        ->with([
                            "item.product.brand",
                            "item.primaryColor"
                        ]);
                }
            ])
            ->orderBy('paid_at', 'desc')
            ->get();
    }
}
