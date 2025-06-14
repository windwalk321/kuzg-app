<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = (new CartController)->getCart();
        $formattedCart = (new CartController)->formatCartData($cart);

        return inertia('Checkout', [
            'cart' => $formattedCart,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_address.first_name' => 'required|string|max:255',
            'billing_address.last_name' => 'required|string|max:255',
            'billing_address.email' => 'required|email|max:255',
            'billing_address.phone' => 'required|string|max:255',
            'billing_address.address' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.zip_code' => 'required|string|max:255',
            'billing_address.country' => 'required|string|max:255',
            'shipping_address.first_name' => 'required|string|max:255',
            'shipping_address.last_name' => 'required|string|max:255',
            'shipping_address.email' => 'required|email|max:255',
            'shipping_address.phone' => 'required|string|max:255',
            'shipping_address.address' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.zip_code' => 'required|string|max:255',
            'shipping_address.country' => 'required|string|max:255',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer,cash_on_delivery',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cart = (new CartController)->getCart();
        $formattedCart = (new CartController)->formatCartData($cart);

        if (count($formattedCart['items']) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        return DB::transaction(function () use ($request, $formattedCart) {
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $formattedCart['total'],
                'tax' => 0, // You can add tax calculation logic here
                'shipping' => 0, // You can add shipping calculation logic here
                'total' => $formattedCart['total'],
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'billing_address' => $request->billing_address,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($formattedCart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product']['price'],
                ]);

                // Update product stock
                Product::where('id', $item['product_id'])
                    ->decrement('stock', $item['quantity']);
            }

            // Clear the cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->first()->items()->delete();
            } else {
                session()->forget('cart');
            }

            return redirect()->route('order.confirmation', $order->id) 
                ->with('success', 'Order placed successfully!');
        });
    }

    public function confirmation(Order $order)
    {
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return inertia('OrderConfirmation', [
            'order' => $order->load('items.product'),
        ]);
    }
}
