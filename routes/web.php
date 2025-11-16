<?php

use App\Http\Controllers\Admin\StoreApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\OrderPaymentController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\Seller\PaymentApprovalController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Storefront\StoreApplicationController;
use App\Http\Controllers\Storefront\CartController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::prefix('produk')->group(function () {
    Route::get('/', [StorefrontProductController::class, 'index'])->name('products.index');
    Route::get('{slug}', [StorefrontProductController::class, 'show'])->name('products.show');
    Route::post('{product}/add-to-cart', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
});

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::get('/checkout', [\App\Http\Controllers\Storefront\CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [\App\Http\Controllers\Storefront\CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/ajukan-toko', [StoreApplicationController::class, 'show'])->name('store.apply.public');
Route::post('/ajukan-toko', [StoreApplicationController::class, 'submit'])
    ->middleware('auth')
    ->name('store.apply.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('orders/{order}/payment', [OrderPaymentController::class, 'create'])->name('orders.payment.create');
    Route::post('orders/{order}/payment', [OrderPaymentController::class, 'store'])->name('orders.payment.store');

    Route::middleware('role:vendor')->prefix('seller')->name('seller.')->group(function () {
        Route::get('store', [SellerStoreController::class, 'index'])->name('store.index');
        Route::get('store/create', [SellerStoreController::class, 'create'])->name('store.create');
        Route::post('store', [SellerStoreController::class, 'store'])->name('store.store');
        Route::get('store/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
        Route::put('store', [SellerStoreController::class, 'update'])->name('store.update');

        Route::resource('products', SellerProductController::class)->except(['show']);

        Route::get('payments', [PaymentApprovalController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [PaymentApprovalController::class, 'show'])->name('payments.show');
        Route::patch('payments/{payment}/approve', [PaymentApprovalController::class, 'approve'])->name('payments.approve');
        Route::patch('payments/{payment}/reject', [PaymentApprovalController::class, 'reject'])->name('payments.reject');

        Route::get('orders/{order}/report', [OrderReportController::class, 'download'])->name('orders.report');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('stores', [StoreApprovalController::class, 'index'])->name('stores.index');
        Route::get('stores/{store}', [StoreApprovalController::class, 'show'])->name('stores.show');
        Route::patch('stores/{store}/approve', [StoreApprovalController::class, 'approve'])->name('stores.approve');
        Route::patch('stores/{store}/reject', [StoreApprovalController::class, 'reject'])->name('stores.reject');

        Route::get('orders/{order}/report', [OrderReportController::class, 'download'])->name('orders.report.admin');
    });
});
