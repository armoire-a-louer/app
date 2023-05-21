<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::where('status', Transaction::STATUS_SUCCESS)->with(["user"])->get();

        return Inertia::render('Admin/Transactions', [
            'transactions' => $transactions
        ]);
    }

    public function show(Request $request, Transaction $transaction)
    {
        $transaction->load([
            'user',
            'address',
            'reservations' => function ($q) {
                $q
                    ->groupBy(['reservation_common_uuid'])
                    ->select(['reservation_common_uuid', 'transaction_id', 'product_size_color_id'])
                    ->selectRaw('MAX(date) as latest_date')
                    ->selectRaw('MIN(date) as earliest_date')
                    ->selectRaw('SUM(price) as total_price')
                    ->with([
                        "item.product:id,brand_id,name",
                        "item.product.brand:id,name",
                        "item.primaryColor"
                    ]);
            }
        ]);

        return Inertia::render('Admin/Transaction', [
            'transaction' => $transaction,
        ]);
    }
}
