<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
        ];
    }

    protected function getStats(): array
    {
        return [
            Card::make('Total Pendapatan', 'Rp ' . number_format($this->getTotalRevenue(), 0, ',', '.')),
            Card::make('Pendapatan Bulan Ini', 'Rp ' . number_format($this->getCurrentMonthRevenue(), 0, ',', '.')),
            Card::make('Menunggu Verifikasi', 'Rp ' . number_format($this->getPendingVerification(), 0, ',', '.')),
            Card::make('Total Pengguna', User::count()),
            Card::make('Total Produk', Product::count()),
            Card::make('Total Pesanan', Order::count()),
        ];
    }

    private function getTotalRevenue()
    {
        return Order::where('status', 'completed')->sum('total_amount');
    }

    private function getCurrentMonthRevenue()
    {
        return Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
    }

    private function getPendingVerification()
    {
        return Order::where('status', 'pending_verification')->sum('total_amount');
    }
}
