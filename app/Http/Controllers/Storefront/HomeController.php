<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('store')
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
}
