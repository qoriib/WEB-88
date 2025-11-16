<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = $request->user();
        if (! $user) {
            return redirect()->route('login')->with('status', 'Login untuk menambahkan produk ke keranjang.');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            ['total_items' => 0, 'total_amount' => 0]
        );

        $quantity = (int) $request->quantity;
        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->unit_price = $product->price;
        $item->subtotal = $item->quantity * $product->price;
        $item->save();

        $this->recalculateCart($cart);

        return back()->with('status', 'Produk ditambahkan ke keranjang.');
    }

    public function index()
    {
        $cart = Cart::with('items.product.store')
            ->firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active'],
                ['total_items' => 0, 'total_amount' => 0]
            );

        return view('storefront.cart.index', compact('cart'));
    }

    public function updateItem(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->authorizeCartItem($item);

        $item->update([
            'quantity' => $request->quantity,
            'unit_price' => $item->product->price,
            'subtotal' => $request->quantity * $item->product->price,
        ]);

        $this->recalculateCart($cart);

        return back()->with('status', 'Keranjang diperbarui.');
    }

    public function destroyItem(CartItem $item)
    {
        $cart = $this->authorizeCartItem($item);
        $item->delete();
        $this->recalculateCart($cart);

        return back()->with('status', 'Item dihapus dari keranjang.');
    }

    protected function recalculateCart(Cart $cart): void
    {
        $items = $cart->items;
        $cart->total_items = $items->sum('quantity');
        $cart->total_amount = $items->sum('subtotal');
        $cart->save();
    }

    protected function authorizeCartItem(CartItem $item): Cart
    {
        $cart = $item->cart;
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        return $cart;
    }
}
