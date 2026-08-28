<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament; // ← ini penting!

class FilamentServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Filament::serving(function () {
            // Izinkan akses ke halaman login admin untuk semua user
            // Jika user sudah login dan bukan admin, blokir akses ke panel admin
            $isLoginPage = str_contains(request()->path(), 'login');
            
            if (!$isLoginPage && auth()->check() && auth()->user()->role !== 'admin') {
                abort(403, 'Hanya administrator yang dapat mengakses area ini');
            }
        });
    }
}