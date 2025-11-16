<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreApprovalController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'q']);

        $stores = Store::with(['owner', 'category'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->q . '%')
                        ->orWhereHas('owner', fn ($owner) => $owner->where('name', 'like', '%' . $request->q . '%'));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->orderBy('created_at')
            ->paginate(10)
            ->appends($filters);

        $recent = Store::with('owner')
            ->orderByDesc('updated_at')
            ->take(8)
            ->get();

        return view('admin.stores.index', [
            'stores' => $stores,
            'recent' => $recent,
            'filters' => $filters,
        ]);
    }

    public function show(Store $store)
    {
        $store->load(['owner', 'category', 'products' => fn ($query) => $query->latest()->take(5)]);
        $store->loadCount('products');

        return view('admin.stores.show', [
            'store' => $store,
        ]);
    }

    public function approve(Store $store)
    {
        $store->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        if ($store->owner && $store->owner->role !== 'admin') {
            $store->owner->update(['role' => 'vendor']);
        }

        return redirect()->route('admin.stores.index')->with('status', 'Toko ' . $store->name . ' disetujui.');
    }

    public function reject(Store $store)
    {
        $store->update([
            'status' => 'rejected',
            'approved_at' => null,
        ]);

        return redirect()->route('admin.stores.index')->with('status', 'Toko ' . $store->name . ' ditolak.');
    }
}
