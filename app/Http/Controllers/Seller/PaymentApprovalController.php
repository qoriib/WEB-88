<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\TransactionReport;
use App\Mail\OrderReportMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        $orderStatus = $payment->method === 'cod' ? 'completed' : 'paid';
        $payment->order->update(['status' => $orderStatus]);

        $this->generateReportAndEmail($payment->order);

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

        $payment->order->update(['status' => $payment->method === 'cod' ? 'cancelled' : 'pending']);

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

    protected function generateReportAndEmail($order): void
    {
        $order->load(['items', 'user', 'store', 'payment']);

        $pdf = Pdf::loadView('reports.order', ['order' => $order]);
        $filename = 'reports/' . $order->order_number . '.pdf';

        Storage::disk('public')->put($filename, $pdf->output());

        TransactionReport::updateOrCreate(
            ['order_id' => $order->id],
            [
                'report_path' => $filename,
                'emailed_to' => $order->user->email,
                'emailed_at' => now(),
                'generated_at' => now(),
                'meta' => [
                    'generated_by' => auth()->user()->name ?? 'vendor',
                ],
            ]
        );

        try {
            Mail::to($order->user->email)->send(new OrderReportMail($order, storage_path('app/public/' . $filename)));
            info('OrderReportMail terkirim ke ' . $order->user->email . ' untuk order ' . $order->order_number);
        } catch (\Throwable $e) {
            // log silently; sharing file for download still works
            report($e);
        }
    }
}
