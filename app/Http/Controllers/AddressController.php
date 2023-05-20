<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function addAddress(Request $request)
    {
        $address = Address::create([
            "user_id" => auth()->id(),
            "address" => $request->get("address"),
            "postal_code" => $request->get("postal_code"),
            "city" => $request->get("city"),
            "firstname" => $request->get("firstname"),
            "lastname" => $request->get("lastname"),
            "phone_number" => $request->get("phone_number")
        ]);

        $addresses = Address::where('user_id', auth()->id())->get();

        return response()->json([
            "address" => $address,
            "addresses" => $addresses
        ]);
    }

    public function index(Request $request)
    {
        $addresses = Address::where('user_id', auth()->id())->get();

        return Inertia::render('Dashboard/Addresses', [
            'addresses' => $addresses
        ]);
    }

    public function update(Request $request, Address $address)
    {
        $address->update($request->only(['address', 'postal_code', 'city', 'firstname', 'lastname', 'phone_number']));
        $address->save();

        $addresses = Address::where('user_id', auth()->id())->get();

        return response()->json([
            "addresses" => $addresses
        ]);
    }

    public function delete(Request $request, Address $address)
    {
        $address->delete();

        $addresses = Address::where('user_id', auth()->id())->get();

        return response()->json([
            "addresses" => $addresses
        ]);
    }
}
