<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function show(Request $request, User $user)
    {
        return Inertia::render('Admin/User', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only(['firstname', 'lastname', 'email', 'phone', 'role']));
        $user->save();

        return response()->json([
            "user" => $user
        ]);
    }
}
