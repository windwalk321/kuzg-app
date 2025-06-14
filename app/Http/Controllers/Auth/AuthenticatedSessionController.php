<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Cart;
use App\Models\Product;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $guestCart = session()->get('cart', ['items' => []]);

        session()->regenerate();
        
        $this->mergeCarts($guestCart);

        return redirect()->intended(route('products.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        

        return redirect('/');
    }

    protected function mergeCarts(array $guestCart)
    {
        if (empty($guestCart['items'])) return;

        $user = auth()->user();
        $userCart = $user->cart()->firstOrCreate();

        foreach ($guestCart['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;

            $existingItem = $userCart->items()
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existingItem) {
                $newQuantity = min(
                    $product->stock,
                    $existingItem->quantity + $item['quantity']
                );
                $existingItem->update(['quantity' => $newQuantity]);
            } else {
                $userCart->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => min($item['quantity'], $product->stock)
                ]);
            }
        }

        session()->forget('cart');
        $user->load('cart.items'); // Ensure the cart is reloaded
    }
}
