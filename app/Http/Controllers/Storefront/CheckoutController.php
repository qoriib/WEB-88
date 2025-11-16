<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = Cart::with('items.product.store')->where('user_id', auth()->id())->where('status', 'active')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang Anda kosong.');
        }

        return view('storefront.checkout.create', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = Cart::with('items.product.store')->where('user_id', auth()->id())->where('status', 'active')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang Anda kosong.');
        }

        $data = $request->validate([
            'city' => ['required', 'string', 'max:120'],
            'shipping_address' => ['required', 'string'],
            'payment_method' => ['required', 'in:prepaid,cod'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Untuk demo, biaya kirim flat
        $shippingCost = 25000;
        $subtotal = $cart->total_amount;
        $total = $subtotal + $shippingCost;

        $order = Order::create([
            'order_number' => 'OSS-' . now()->format('Ymd-His') . '-' . auth()->id(),
            'user_id' => auth()->id(),
            'store_id' => $cart->items->first()->product->store_id,
            'cart_id' => $cart->id,
            'status' => 'pending',
            'payment_method' => $data['payment_method'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total_amount' => $total,
            'city' => $data['city'],
            'shipping_address' => $data['shipping_address'],
            'notes' => $data['notes'] ?? null,
            'placed_at' => now(),
        ]);

        // Ubah status cart
        $cart->update(['status' => 'checked_out']);

        // Buat payment pending
        $order->payment()->create([
            'amount' => $total,
            'method' => $data['payment_method'],
            'status' => 'pending',
        ]);

        try {
            Mail::to($order->user->email)->send(new OrderCreatedMail($order));
            info('OrderCreatedMail terkirim ke ' . $order->user->email);
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('orders.payment.create', $order)->with('status', 'Order dibuat. Silakan lanjutkan pembayaran dengan unggah bukti transfer.');
    }
}
