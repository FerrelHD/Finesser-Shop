<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * Prioritaskan pembayaran berstatus 'pending_verification' di urutan teratas (portabel untuk MySQL & SQLite).
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->orderByRaw("CASE WHEN status = 'pending_verification' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at');
    }
}
