<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('orders.items.product');
        $user = auth()->user()->load('orders.items.product');
        
        return Inertia::render('Profile', [
            'orders' => $user->orders,
        ]);
    }
}
