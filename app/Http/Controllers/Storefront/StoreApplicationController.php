<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreApplicationController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $categories = StoreCategory::where('is_active', true)->orderBy('name')->get();
        $store = $user?->store;

        return view('storefront.apply-store', [
            'user' => $user,
            'categories' => $categories,
            'store' => $store,
        ]);
    }

    public function submit(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $store = $user->store;
        if ($store && in_array($store->status, ['pending', 'approved'])) {
            return redirect()->route('store.apply.public')->with('status', 'Pengajuan toko Anda sedang diproses atau sudah disetujui.');
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
            ->route('store.apply.public')
            ->with('status', 'Pengajuan toko dikirim. Admin akan meninjau dan mengubah role Anda menjadi vendor saat disetujui.');
    }
}
