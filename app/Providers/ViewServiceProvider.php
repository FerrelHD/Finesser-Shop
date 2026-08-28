<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share cart count with all views
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                try {
                    $cartCount = Cart::where('user_id', Auth::id())->count();
                } catch (\Exception $e) {
                    // Jika terjadi error (misal tabel carts belum ada), biarkan $cartCount tetap 0
                    $cartCount = 0;
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }

    public function register(): void
    {
        //
    }
}