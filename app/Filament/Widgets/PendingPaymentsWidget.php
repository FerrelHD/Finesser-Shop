<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PaymentResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingPaymentsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Pembayaran Perlu Verifikasi';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', 'pending_verification')
                    ->with(['user', 'product'])
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pembeli')
                    ->default('-'),
                Tables\Columns\TextColumn::make('product.title')
                    ->label('Produk')
                    ->limit(24)
                    ->default('-'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('review')
                    ->label('Tinjau')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Order $record): string => PaymentResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('Tidak ada antrean verifikasi')
            ->emptyStateDescription('Semua pembayaran masuk sudah ditinjau.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
