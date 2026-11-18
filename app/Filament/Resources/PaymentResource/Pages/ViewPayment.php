<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('verify')
                ->label('Verifikasi Pembayaran')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Order $record): bool => $record->status === 'pending_verification')
                ->action(fn (Order $record) => PaymentResource::verifyOrder($record)),
            Actions\Action::make('reject')
                ->label('Tolak Pembayaran')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Order $record): bool => $record->status === 'pending_verification')
                ->action(fn (Order $record) => PaymentResource::rejectOrder($record)),
        ];
    }
}
