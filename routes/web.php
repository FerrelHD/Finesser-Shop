<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProdukController as FrontendProdukController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\AdminOrderController;

// =======================
// PUBLIC ROUTES
// =======================

// Gunakan middleware web secara default
Route::middleware(['web'])->group(function () {
    Route::get('/', [FrontendProdukController::class, 'index'])->name('home');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/produk/{id}', [FrontendProdukController::class, 'show'])->name('produk.show');

    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/ajax', [SearchController::class, 'ajaxSearch'])->name('search.ajax');
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
});

// =======================
// AUTHENTICATED USER ROUTES
// =======================

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Checkout
    Route::get('/checkout/{produk}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{produk}', [CheckoutController::class, 'store'])->name('checkout.store');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{order}/status', [PaymentController::class, 'status'])->name('payment.status');

    // Orders
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/download', [OrderController::class, 'download'])->name('orders.download');
    Route::get('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    // File Download (Verified Only)
    Route::get('/download/{order}', function (App\Models\Order $order) {
        if (auth()->id() !== $order->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if ($order->status !== 'verified') {
            return redirect()->back()->with('error', 'Pembayaran belum terverifikasi');
        }

        $filePath = $order->product->file_path;

        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return Storage::download($filePath, $order->product->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    })->name('download.file');
});

// =======================
// AUTH
// =======================
require __DIR__.'/auth.php';

// =======================
// ADMIN ROUTES
// =======================

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::post('/orders/{order}/verify', [AdminOrderController::class, 'verify'])->name('admin.orders.verify');
});