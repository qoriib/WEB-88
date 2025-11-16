<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TransactionReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderReportController extends Controller
{
    public function download(Order $order)
    {
        $user = auth()->user();

        if ($user->role === 'vendor' && $order->store->user_id !== $user->id) {
            abort(403);
        } elseif ($user->role === 'customer' || ($user->role !== 'admin' && $user->role !== 'vendor')) {
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
}
