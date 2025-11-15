<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentApprovalController extends Controller
{
    public function index(Request $request)
    {
        $store = $this->ensureStoreReady();
        $filters = $request->only(['status']);

        $payments = Payment::with(['order.user'])
            ->whereHas('order', fn ($query) => $query->where('store_id', $store->id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($filters);

        return view('seller.payments.index', compact('payments', 'filters'));
    }

    public function show(Payment $payment)
    {
        $store = $this->ensureStoreReady();
        $this->authorizePayment($payment, $store);
        $payment->load(['order.user']);

        return view('seller.payments.show', compact('payment', 'store'));
    }

    public function approve(Request $request, Payment $payment)
    {
        $store = $this->ensureStoreReady();
        $this->authorizePayment($payment, $store);

        $data = $request->validate([
            'verification_note' => ['nullable', 'string', 'max:500'],
        ]);

        $payment->update([
            'status' => 'confirmed',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_note' => $data['verification_note'] ?? null,
            'paid_at' => $payment->paid_at ?? now(),
        ]);

        $payment->order->update(['status' => 'paid']);

        return redirect()->route('seller.payments.show', $payment)->with('status', 'Pembayaran dikonfirmasi.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $store = $this->ensureStoreReady();
        $this->authorizePayment($payment, $store);

        $data = $request->validate([
            'verification_note' => ['required', 'string', 'max:500'],
        ]);

        $payment->update([
            'status' => 'failed',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_note' => $data['verification_note'],
        ]);

        $payment->order->update(['status' => 'pending']);

        return redirect()->route('seller.payments.show', $payment)->with('status', 'Pembayaran ditandai tidak valid.');
    }

    protected function ensureStoreReady()
    {
        $store = auth()->user()->store;

        if (! $store || $store->status !== 'approved') {
            abort(403);
        }

        return $store;
    }

    protected function authorizePayment(Payment $payment, $store): void
    {
        if ($payment->order->store_id !== $store->id) {
            abort(403);
        }
    }
}
