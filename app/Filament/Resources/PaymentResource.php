<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification; // Tambahkan import ini di bagian atas file
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class PaymentResource extends Resource
{
    protected static ?string $model = Order::class;

    // Menggunakan format ikon yang benar untuk Filament 3
    protected static ?string $navigationIcon = 'heroicon-m-banknotes';
    
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?string $pluralModelLabel = 'Pembayaran';
    protected static ?string $modelLabel = 'Pembayaran';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'pending_verification' => 'Menunggu Verifikasi',
                        'verified' => 'Pembayaran Terverifikasi',
                        'rejected' => 'Pembayaran Ditolak',
                    ])
                    ->required(),
                Forms\Components\ViewField::make('payment_proof')
                    ->view('filament.forms.components.payment-proof-viewer'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product.title')
                    ->label('Produk')
                    ->searchable(),
                    TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn ($state) => [
                        'transfer_bank' => 'Transfer Bank',
                        'ewallet' => 'E-Wallet',
                    ][$state] ?? $state),                
                ImageColumn::make('payment_proof')
                    ->label('Bukti Pembayaran'),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'pending_verification' => 'info',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        'processing' => 'secondary', // tambahkan ini sesuai warna yang diinginkan
                        default => 'gray', // fallback jika ada status tak terduga lainnya
                    })                    
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Menunggu Verifikasi',
                        'verified' => 'Pembayaran Terverifikasi',
                        'rejected' => 'Pembayaran Ditolak',
                        'cancelled' => 'Dibatalkan'
                    ])
            ])
            ->actions([
                // Di dalam action verify, ganti kode notifikasi menjadi:
                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (\App\Models\Order $record): bool => $record->status === 'pending_verification')
                    ->action(function (\App\Models\Order $record) {
                        $record->update(['status' => 'verified']);
                        
                        // Broadcast event
                        broadcast(new \App\Events\PaymentVerified($record))->toOthers();
                        
                        // Notification untuk admin
                        Notification::make()
                            ->success()
                            ->title('Pembayaran berhasil diverifikasi')
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-s-x-mark')
                    ->color('danger')
                    ->visible(fn (\App\Models\Order $record): bool => $record->status === 'pending_verification')
                    ->action(fn (\App\Models\Order $record) => $record->update(['status' => 'rejected'])),
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }
}