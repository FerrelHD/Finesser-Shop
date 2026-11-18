<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRevenue extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $verifiedQuery = Order::where('status', 'verified');
        $totalRevenue = (clone $verifiedQuery)->sum('total_price');
        $totalVerifiedOrders = (clone $verifiedQuery)->count();

        $monthlyRevenue = Order::where('status', 'verified')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $pendingQuery = Order::where('status', 'pending_verification');
        $pendingRevenue = (clone $pendingQuery)->sum('total_price');
        $pendingCount = (clone $pendingQuery)->count();

        $activeProducts = Produk::where('is_active', true)->count();
        $totalUsers = User::count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description("{$totalVerifiedOrders} transaksi terverifikasi")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            Stat::make('Menunggu Verifikasi', 'Rp ' . number_format($pendingRevenue, 0, ',', '.'))
                ->description("{$pendingCount} pesanan perlu ditinjau")
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('Katalog & Pengguna', "{$activeProducts} Produk")
                ->description("{$totalUsers} pengguna terdaftar")
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('gray'),
        ];
    }
}
