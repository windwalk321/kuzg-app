<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        return inertia('Cart', [
            'cart' => $this->formatCartData($cart),
        ]);
    }

    public function addItem(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $cart = $this->getCart();
        $this->addItemToCart($cart, $product, $request->quantity);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();
        $this->updateCartItem($cart, $itemId, $request->quantity);

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function removeItem($itemId)
    {
        $cart = $this->getCart();
        $this->removeItemFromCart($cart, $itemId);

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function getCart()
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }
        return $this->getSessionCart();
    }

    protected function getUserCart()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart->load('items.product');
        return $cart;
    }

    protected function getSessionCart()
    {
        return session()->get('cart', [
            'items' => [],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function addItemToCart(&$cart, Product $product, $quantity)
    {
        if (Auth::check()) {
            $this->addItemToUserCart($cart, $product, $quantity);
        } else {
            $this->addItemToSessionCart($cart, $product, $quantity);
        }
    }

    protected function addItemToUserCart(Cart $cart, Product $product, $quantity)
    {
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = min($product->stock, $cartItem->quantity + $quantity);
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => min($product->stock, $quantity),
            ]);
        }
    }

    protected function addItemToSessionCart(&$cart, Product $product, $quantity)
    {
        $existingItemIndex = $this->findSessionCartItemIndex($cart, $product->id);

        if ($existingItemIndex !== false) {
            $newQuantity = min($product->stock, $cart['items'][$existingItemIndex]['quantity'] + $quantity);
            $cart['items'][$existingItemIndex]['quantity'] = $newQuantity;
        } else {
            $cart['items'][] = [
                'id' => uniqid(),
                'product_id' => $product->id,
                'product' => $product->only(['id', 'name', 'price', 'image_url', 'stock']),
                'quantity' => min($product->stock, $quantity),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $cart['updated_at'] = now();
        session()->put('cart', $cart);
    }

    protected function updateCartItem(&$cart, $itemId, $quantity)
    {
        if (Auth::check()) {
            $this->updateUserCartItem($cart, $itemId, $quantity);
        } else {
            $this->updateSessionCartItem($cart, $itemId, $quantity);
        }
    }

    protected function updateUserCartItem(Cart $cart, $itemId, $quantity)
    {
        $cartItem = $cart->items()->findOrFail($itemId);
        $cartItem->update([
            'quantity' => min($cartItem->product->stock, $quantity),
        ]);
    }

    protected function updateSessionCartItem(&$cart, $itemId, $quantity)
    {
        $itemIndex = $this->findSessionCartItemIndex($cart, null, $itemId);

        if ($itemIndex !== false) {
            $productStock = $cart['items'][$itemIndex]['product']['stock'];
            $cart['items'][$itemIndex]['quantity'] = min($productStock, $quantity);
            $cart['items'][$itemIndex]['updated_at'] = now();
            $cart['updated_at'] = now();
            session()->put('cart', $cart);
        }
    }

    protected function removeItemFromCart(&$cart, $itemId)
    {
        if (Auth::check()) {
            $this->removeItemFromUserCart($cart, $itemId);
        } else {
            $this->removeItemFromSessionCart($cart, $itemId);
        }
    }

    protected function removeItemFromUserCart(Cart $cart, $itemId)
    {
        $cart->items()->where('id', $itemId)->delete();
    }

    protected function removeItemFromSessionCart(&$cart, $itemId)
    {
        $itemIndex = $this->findSessionCartItemIndex($cart, null, $itemId);

        if ($itemIndex !== false) {
            array_splice($cart['items'], $itemIndex, 1);
            $cart['updated_at'] = now();
            session()->put('cart', $cart);
        }
    }

    protected function findSessionCartItemIndex($cart, $productId = null, $itemId = null)
    {
        foreach ($cart['items'] as $index => $item) {
            if ($productId && $item['product_id'] == $productId) {
                return $index;
            }
            if ($itemId && $item['id'] == $itemId) {
                return $index;
            }
        }
        return false;
    }

    public function formatCartData($cart)
    {
        if (Auth::check()) {
            return [
                'id' => $cart->id,
                'user_id' => $cart->user_id,
                'items' => $cart->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'product' => $item->product,
                        'subtotal' => $item->product->price * $item->quantity,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
                }),
                'total' => $cart->items->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }),
                'created_at' => $cart->created_at,
                'updated_at' => $cart->updated_at,
            ];
        }

        return [
            'id' => null,
            'user_id' => null,
            'items' => collect($cart['items'])->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'product' => (object) $item['product'],
                    'subtotal' => $item['product']['price'] * $item['quantity'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ];
            })->all(),
            'total' => collect($cart['items'])->sum(function ($item) {
                return $item['product']['price'] * $item['quantity'];
            }),
            'created_at' => $cart['created_at'],
            'updated_at' => $cart['updated_at'],
        ];
    }

    public function mergeCarts()
    {
        if (!Auth::check()) {
            return;
        }

        $sessionCart = session()->get('cart', ['items' => []]);
        $userCart = $this->getUserCart();

        foreach ($sessionCart['items'] as $sessionItem) {
            $product = Product::find($sessionItem['product_id']);
            if ($product) {
                $this->addItemToUserCart($userCart, $product, $sessionItem['quantity']);
            }
        }

        session()->forget('cart');
    }

    public function getCartItemCount($request)
    {
        if ($request->user()) {
            return $request->user()->cart?->items()->sum('quantity') ?? 0;
        }
        
        $sessionCart = $request->session()->get('cart', ['items' => []]);
        return array_reduce($sessionCart['items'], fn($carry, $item) => $carry + $item['quantity'], 0);
    }
}