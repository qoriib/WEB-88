<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Store;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            'customer' => $this->customerDashboard($user),
            'vendor' => $this->vendorDashboard($user),
            'admin' => $this->adminDashboard($user),
            default => view('dashboard', ['user' => $user, 'orders' => collect()]),
        };
    }

    protected function customerDashboard($user)
    {
        $orders = Order::with(['store', 'payment'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dashboard.customer', compact('user', 'orders'));
    }

    protected function vendorDashboard($user)
    {
        $store = $user->store;

        $summary = [
            'storeStatus' => $store?->status ?? 'belum_ajukan',
            'products' => $store?->products()->count() ?? 0,
            'pendingPayments' => $store
                ? Payment::whereHas('order', fn ($q) => $q->where('store_id', $store->id))
                    ->where('status', 'pending')
                    ->count()
                : 0,
        ];

        $recentPayments = collect();
        if ($store) {
            $recentPayments = Payment::with(['order.user'])
                ->whereHas('order', fn ($q) => $q->where('store_id', $store->id))
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }

        return view('dashboard.vendor', compact('user', 'store', 'summary', 'recentPayments'));
    }

    protected function adminDashboard($user)
    {
        $pendingStores = Store::with('owner')->where('status', 'pending')->orderBy('created_at')->take(8)->get();
        $recentOrders = Order::with(['user', 'store'])->orderByDesc('created_at')->take(8)->get();

        return view('dashboard.admin', compact('user', 'pendingStores', 'recentOrders'));
    }
}
