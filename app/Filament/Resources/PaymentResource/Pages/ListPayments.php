<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Kita tidak perlu Actions\CreateAction karena pembayaran dibuat dari user
        ];
    }

    /**
     * Override query agar status 'pending_verification' muncul paling atas, lalu urutkan berdasarkan created_at desc
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->orderByRaw("FIELD(status, 'pending_verification') DESC")
            ->orderByDesc('created_at');
    }
}