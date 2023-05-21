<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\User;
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

    public function likes()
    {
        $user =
            User::
            select(["id"])
            ->where('id', auth()->id())
            ->with(["likes.brand"])
            ->first();

        return Inertia::render('Dashboard/Likes', [
            "user" => $user
        ]);
    }
}
