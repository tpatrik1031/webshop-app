<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $billingAddress = BillingAddress::where('user_id', $user->id)->get();
        $shippingAddress = ShippingAddress::where('user_id', $user->id)->get();

        return Inertia::render('Profile/Addresses/Index', [
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress,
        ]);
    }
}
