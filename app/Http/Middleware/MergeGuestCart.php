<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CartController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MergeGuestCart
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only merge carts if the user just logged in
        if (Auth::check() && session()->get('cart')) {
            app(CartController::class)->mergeCarts();
        }

        return $response;
    }
}
