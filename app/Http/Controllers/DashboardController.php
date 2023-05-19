<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function reservations(Request $request)
    {
        $reservations = Reservation::getAllPaidTransactions(auth()->user());

        return Inertia::render('Dashboard/Dashboard', [
            "reservations" => $reservations
        ]);
    }
}
