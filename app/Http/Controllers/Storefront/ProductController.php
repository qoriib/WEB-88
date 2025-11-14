<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product listing with optional filters.
     */
    public function index(Request $request)
    {
        $categories = StoreCategory::query()->where('is_active', true)->orderBy('name')->get();
        $stores = Store::query()->where('status', 'approved')->orderBy('name')->get();

        $products = Product::query()
            ->with(['store', 'store.category'])
            ->where('is_active', true)
            ->when($request->filled('q'), fn ($query) => $query->where(function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('sku', 'like', '%' . $request->q . '%');
            }))
            ->when($request->filled('category'), fn ($query) => $query->whereHas('store.category', function ($category) use ($request) {
                $category->where('slug', $request->category);
            }))
            ->when($request->filled('store'), fn ($query) => $query->whereHas('store', function ($store) use ($request) {
                $store->where('slug', $request->store);
            }))
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('storefront.products.index', [
            'products' => $products,
            'categories' => $categories,
            'stores' => $stores,
        ]);
    }

    /**
     * Display product detail page.
     */
    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['store', 'store.category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('storefront.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
