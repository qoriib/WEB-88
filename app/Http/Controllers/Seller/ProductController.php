<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $store = $this->ensureStoreReady();
        $products = $store->products()->latest()->paginate(10);

        return view('seller.products.index', compact('products', 'store'));
    }

    public function create()
    {
        $store = $this->ensureStoreReady();

        return view('seller.products.create', compact('store'));
    }

    public function store(Request $request)
    {
        $store = $this->ensureStoreReady();

        $data = $this->validateProduct($request);

        $store->products()->create($data);

        return redirect()->route('seller.products.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $store = $this->ensureStoreReady();
        $this->authorizeOwnership($product, $store);

        return view('seller.products.edit', compact('product', 'store'));
    }

    public function update(Request $request, Product $product)
    {
        $store = $this->ensureStoreReady();
        $this->authorizeOwnership($product, $store);

        $data = $this->validateProduct($request, $product);

        $product->update($data);

        return redirect()->route('seller.products.index')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $store = $this->ensureStoreReady();
        $this->authorizeOwnership($product, $store);
        $product->delete();

        return redirect()->route('seller.products.index')->with('status', 'Produk telah dihapus.');
    }

    protected function validateProduct(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($product) {
            $data['slug'] = $product->slug;
        } else {
            $data['slug'] = Str::slug($data['name'] . '-' . Str::random(4));
        }
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }

    protected function ensureStoreReady()
    {
        $store = auth()->user()->store;

        if (! $store) {
            abort(403, 'Anda belum memiliki toko.');
        }

        if ($store->status !== 'approved') {
            abort(403, 'Toko belum disetujui.');
        }

        return $store;
    }

    protected function authorizeOwnership(Product $product, $store): void
    {
        if ($product->store_id !== $store->id) {
            abort(403);
        }
    }
}
