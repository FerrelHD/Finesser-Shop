<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TotalRevenue extends BaseWidget
{
    protected function getCards(): array
    {
        $totalRevenue = Order::where('status', 'verified')
            ->sum('total_price');

        $monthlyRevenue = Order::where('status', 'verified')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $pendingRevenue = Order::where('status', 'pending_verification')
            ->sum('total_price');

            return [
                Card::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                    ->description('Total pendapatan dari semua penjualan')
                    ->descriptionIcon('heroicon-s-currency-dollar')
                    ->color('success'),
                
                Card::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                    ->description('Total pendapatan bulan ' . now()->format('F Y'))
                    ->descriptionIcon('heroicon-s-calendar')
                    ->color('primary'),
                
                Card::make('Menunggu Verifikasi', 'Rp ' . number_format($pendingRevenue, 0, ',', '.'))
                    ->description('Total pembayaran yang belum diverifikasi')
                    ->descriptionIcon('heroicon-s-clock')
                    ->color('warning'),
            ];            
    }
}