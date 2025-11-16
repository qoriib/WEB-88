<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderPaymentController extends Controller
{
    public function create(Order $order)
    {
        $this->authorizeOrder($order);

        $payment = $order->payment;

        if (! $payment) {
            $payment = $order->payment()->create([
                'amount' => $order->total_amount,
                'method' => $order->payment_method,
                'status' => 'pending',
            ]);
        }

        $order->load('store');

        return view('customer.payments.upload', compact('order', 'payment'));
    }

    public function store(Request $request, Order $order)
    {
        $this->authorizeOrder($order);
        $payment = $order->payment ?? $order->payment()->create([
            'amount' => $order->total_amount,
            'method' => $order->payment_method,
            'status' => 'pending',
        ]);

        $data = $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($payment->proof_path) {
            Storage::disk('public')->delete($payment->proof_path);
        }

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $meta = $payment->meta ?? [];
        if (! empty($data['notes'])) {
            $meta['customer_note'] = $data['notes'];
        }

        $payment->update([
            'proof_path' => $path,
            'meta' => $meta,
            'status' => 'pending',
            'verified_by' => null,
            'verified_at' => null,
            'verification_note' => null,
            'paid_at' => null,
        ]);

        $order->update(['status' => 'pending']);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi toko.');
    }

    protected function authorizeOrder(Order $order): void
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
