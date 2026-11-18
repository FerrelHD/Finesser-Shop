<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ProductSalesWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $productSales = Order::select('orders.product_id', DB::raw('COUNT(*) as total_sales'))
            ->join('produks', 'orders.product_id', '=', 'produks.id')
            ->where('produks.is_active', true)
            ->where('orders.status', 'verified')
            ->groupBy('orders.product_id')
            ->orderByDesc('total_sales')
            ->limit(4)
            ->with('product')
            ->get();

        $stats = $productSales
            ->filter(fn ($sale) => $sale->product !== null)
            ->map(function ($sale) {
                return Stat::make(
                    $sale->product->title,
                    $sale->total_sales . ' terjual'
                )
                    ->description('Produk terlaris terverifikasi')
                    ->descriptionIcon('heroicon-m-shopping-bag')
                    ->color('gray');
            })
            ->values()
            ->all();

        if (empty($stats)) {
            return [
                Stat::make('Produk Terlaris', 'Belum ada data')
                    ->description('Statistik muncul setelah ada transaksi terverifikasi')
                    ->descriptionIcon('heroicon-m-shopping-bag')
                    ->color('gray'),
            ];
        }

        return $stats;
    }
}
