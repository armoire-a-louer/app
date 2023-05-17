<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class wipeOldWaitingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wipe-old-waiting-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations =
            Reservation::
            whereIn('status', [
                Reservation::STATUS_WAITING_PAYMENT,
                Reservation::STATUS_PROTECTED_WAITING_PAYMENT
            ])
            ->where('updated_at', '<', Carbon::now())
            ->get();

        foreach ($reservations as $reservation) {
            if ($reservation->status === Reservation::STATUS_WAITING_PAYMENT) {
                $reservation->status = Reservation::STATUS_BASKET;
                $reservation->save();
            }

            if ($reservation->status === Reservation::STATUS_PROTECTED_WAITING_PAYMENT) {
                $reservation->delete();
            }
        }

        return Command::SUCCESS;
    }
}
