<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingRequest;
use App\Http\Requests\ShippingRequest;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $billingAddress = BillingAddress::where('user_id', $user->id)->first();
        $shippingAddress = ShippingAddress::where('user_id', $user->id)->first();

        return Inertia::render('Profile/Addresses/Index', [
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    public function saveShippingAddress(ShippingRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        $shipping = ShippingAddress::updateOrCreate(
            ['user_id' => $userId],
            [
                'country' => $data['country'],
                'zip' => $data['zip'],
                'city' => $data['city'],
                'address' => $data['address'],
                'same_address' => $data['same_address'],
            ]
        );

        if (!empty($data['same_address']) && $data['same_address']) {
            $billing = BillingAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'country' => $data['country'],
                    'zip' => $data['zip'],
                    'city' => $data['city'],
                    'address' => $data['address'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Address saved successfully');
    }


    public function saveBillingAddress(BillingRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        BillingAddress::updateOrCreate(
            ['user_id' => $userId],
            [
                'country' => $data['country'],
                'zip' => $data['zip'],
                'city' => $data['city'],
                'address' => $data['address'],
            ]
        );

        return redirect()->back()->with('success', 'Address saved successfully');
    }
}
