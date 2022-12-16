<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $usersCount = User::all()->count();

        return Inertia::render('Admin/Dashboard', [
            'usersCount' => $usersCount
        ]);
    }
}
