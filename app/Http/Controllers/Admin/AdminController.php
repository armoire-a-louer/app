<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $usersCount = User::all()->count();

        $transactionsAmount30LastDays = Transaction::where('paid_at', '>=', Carbon::now()->subMonth())->sum('amount');

        $transactions30LastDays = Transaction::where('paid_at', '>=', Carbon::now()->subMonth())->count();

        $transactions = Transaction::where('status', Transaction::STATUS_SUCCESS)->with(["user"])->limit(10)->get();

        return Inertia::render('Admin/Dashboard', [
            'usersCount' => $usersCount,
            'transactionsAmount30LastDays' => $transactionsAmount30LastDays,
            'transactions30LastDays' => $transactions30LastDays,
            'transactions' => $transactions
        ]);
    }
}
