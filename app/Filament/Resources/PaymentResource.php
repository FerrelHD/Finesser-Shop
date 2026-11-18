<?php

namespace App\Filament\Resources;

use App\Events\PaymentVerified;
use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-m-banknotes';

    protected static ?string $navigationGroup = 'Katalog & Penjualan';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?string $pluralModelLabel = 'Pembayaran';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = Order::where('status', 'pending_verification')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function verifyOrder(Order $record): void
    {
        $record->update(['status' => 'verified']);

        broadcast(new PaymentVerified($record))->toOthers();

        Notification::make()
            ->success()
            ->title('Pembayaran berhasil diverifikasi')
            ->send();
    }

    public static function rejectOrder(Order $record): void
    {
        $record->update(['status' => 'rejected']);

        Notification::make()
            ->danger()
            ->title('Pembayaran ditolak')
            ->send();
    }

    public static function statusLabel(string $state): string
    {
        return match ($state) {
            'pending' => 'Menunggu Pembayaran',
            'pending_verification' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => $state,
        };
    }

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'pending' => 'warning',
            'pending_verification' => 'info',
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'gray',
        };
    }

    public static function paymentMethodLabel(?string $state): string
    {
        return match ($state) {
            'transfer_bank' => 'Transfer Bank',
            'ewallet' => 'E-Wallet',
            default => $state ?? '-',
        };
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status Pembayaran')
                    ->columns(1)
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
                            ->label('Bukti Pembayaran')
                            ->view('filament.forms.components.payment-proof-viewer'),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Grid::make(['default' => 1, 'lg' => 2])
                    ->schema([
                        Infolists\Components\Section::make('Detail Transaksi')
                            ->columns(2)
                            ->columnSpan(1)
                            ->schema([
                                Infolists\Components\TextEntry::make('user.name')
                                    ->label('Pembeli'),
                                Infolists\Components\TextEntry::make('user.email')
                                    ->label('Email Pembeli'),
                                Infolists\Components\TextEntry::make('product.title')
                                    ->label('Produk')
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('payment_method')
                                    ->label('Metode Pembayaran')
                                    ->formatStateUsing(fn (?string $state): string => self::paymentMethodLabel($state)),
                                Infolists\Components\TextEntry::make('total_price')
                                    ->label('Total Pembayaran')
                                    ->money('IDR'),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => self::statusLabel($state))
                                    ->color(fn (string $state): string => self::statusColor($state)),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Tanggal Order')
                                    ->dateTime('d M Y, H:i'),
                            ]),

                        Infolists\Components\Section::make('Bukti Pembayaran')
                            ->columnSpan(1)
                            ->schema([
                                Infolists\Components\ViewEntry::make('payment_proof')
                                    ->hiddenLabel()
                                    ->view('filament.forms.components.payment-proof-viewer'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Order $record): string => $record->user?->email ?? '-'),
                TextColumn::make('product.title')
                    ->label('Produk')
                    ->searchable()
                    ->limit(28),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->formatStateUsing(fn (?string $state): string => self::paymentMethodLabel($state)),
                ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->disk('public')
                    ->size(44)
                    ->square(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::statusLabel($state))
                    ->color(fn (string $state): string => self::statusColor($state)),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'pending_verification' => 'Menunggu Verifikasi',
                        'verified' => 'Pembayaran Terverifikasi',
                        'rejected' => 'Pembayaran Ditolak',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->status === 'pending_verification')
                    ->action(fn (Order $record) => self::verifyOrder($record)),
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-s-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->status === 'pending_verification')
                    ->action(fn (Order $record) => self::rejectOrder($record)),
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
