<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        return view('seller.store.index', compact('store'));
    }

    public function create()
    {
        $user = auth()->user();
        $store = $user->store;

        if ($store && in_array($store->status, ['pending', 'approved'])) {
            return redirect()->route('seller.store.index')->with('status', 'Pengajuan toko Anda masih ' . $store->status . '.');
        }

        $categories = StoreCategory::where('is_active', true)->orderBy('name')->get();

        return view('seller.store.create', [
            'categories' => $categories,
            'store' => $store,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;

        if ($store && in_array($store->status, ['pending', 'approved'])) {
            return redirect()->route('seller.store.index');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'store_category_id' => ['required', 'exists:store_categories,id'],
            'description' => ['required', 'string'],
            'city' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:30'],
        ]);

        $payload = array_merge($data, [
            'user_id' => $user->id,
            'slug' => Str::slug($data['name'] . '-' . Str::random(5)),
            'status' => 'pending',
            'approved_at' => null,
        ]);

        if ($store) {
            $store->update($payload);
        } else {
            Store::create($payload);
        }

        return redirect()
            ->route('seller.store.index')
            ->with('status', 'Pengajuan toko berhasil dikirim. Tunggu persetujuan admin.');
    }

    public function edit()
    {
        $store = auth()->user()->store;

        if (! $store) {
            return redirect()->route('seller.store.create')->with('status', 'Silakan ajukan toko terlebih dahulu.');
        }

        $categories = StoreCategory::where('is_active', true)->orderBy('name')->get();

        return view('seller.store.edit', compact('store', 'categories'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;

        if (! $store) {
            return redirect()->route('seller.store.create');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'store_category_id' => ['required', 'exists:store_categories,id'],
            'description' => ['required', 'string'],
            'city' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:30'],
        ]);

        $store->update($data);

        return redirect()->route('seller.store.index')->with('status', 'Profil toko berhasil diperbarui.');
    }
}
