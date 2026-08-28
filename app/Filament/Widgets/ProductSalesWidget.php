<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ProductSalesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil data penjualan untuk produk yang masih ada
        $productSales = Order::select('orders.product_id', DB::raw('COUNT(*) as total_sales'))
            ->join('produks', 'orders.product_id', '=', 'produks.id')
            ->where('produks.is_active', true) // Hanya produk yang masih aktif
            ->groupBy('orders.product_id')
            ->with('product')
            ->get();

        // Membuat array stats untuk setiap produk
        return $productSales->map(function ($sale) {
            if ($sale->product) {
                return Stat::make(
                    $sale->product->title,
                    $sale->total_sales . ' terjual'
                )
                ->description('Total penjualan produk ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success');
            }
            return null;
        })->filter()->toArray(); // Filter null values
    }
}