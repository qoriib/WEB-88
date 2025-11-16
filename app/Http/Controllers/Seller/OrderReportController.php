<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TransactionReport;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderReportController extends Controller
{
    public function download(Order $order)
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'vendor' || $order->store->user_id !== $user->id) {
            abort(403);
        }

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
                    'generated_by' => $user->name,
                ],
            ]
        );

        return response()->file(storage_path('app/public/' . $filename));
    }

    public function exportPayments()
    {
        $user = auth()->user();
        $store = $user->store;

        if (! $store || $store->status !== 'approved') {
            abort(403);
        }

        $payments = Payment::with(['order.user'])
            ->whereHas('order', fn ($q) => $q->where('store_id', $store->id))
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        $pdf = Pdf::loadView('reports.vendor-payments', [
            'store' => $store,
            'payments' => $payments,
        ]);

        $filename = 'reports/vendor-' . $store->slug . '-payments.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return response()->file(storage_path('app/public/' . $filename));
    }
}
