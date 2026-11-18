<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Tren Pendapatan (6 Bulan Terakhir)';

    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $start = now()->subMonths(5)->startOfMonth();

        $orders = Order::where('status', 'verified')
            ->where('created_at', '>=', $start)
            ->get(['total_price', 'created_at']);

        $grouped = $orders->groupBy(fn (Order $order) => $order->created_at->format('Y-m'));

        $labels = [];
        $totals = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat('M Y');
            $totals[] = (float) ($grouped->get($key)?->sum('total_price') ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(24, 24, 27, 0.85)',
                    'borderColor' => '#18181b',
                    'borderRadius' => 6,
                    'barThickness' => 28,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
