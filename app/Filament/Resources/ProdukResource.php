<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Produk'),
                Forms\Components\RichEditor::make('description')
                    ->maxLength(65535)
                    ->label('Deskripsi')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File Utama')
                    ->disk('local')
                    ->directory('private/products')
                    ->maxSize(5242880)
                    ->nullable(),
                Forms\Components\TextInput::make('file_type')
                    ->required()
                    ->maxLength(255)
                    ->label('Tipe File'),
                FileUpload::make('preview_image')
                    ->label('Gambar Preview Utama')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('produks')
                    ->openable()
                    ->downloadable()
                    ->required(),
                
                FileUpload::make('preview_image_2')
                    ->label('Gambar Preview 2')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('produks')
                    ->openable()
                    ->downloadable()
                    ->nullable(),
                
                FileUpload::make('preview_image_3')
                    ->label('Gambar Preview 3')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('produks')
                    ->openable()
                    ->downloadable()
                    ->nullable(),
                
                FileUpload::make('preview_video')
                    ->label('Video Preview')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                    ->disk('public')
                    ->visibility('public')
                    ->directory('produks/videos')
                    ->maxSize(50000)
                    ->openable()
                    ->downloadable()
                    ->nullable(),
                
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga')
                    ->minValue(0)
                    ->maxValue(999999999)
                    ->step(1000)
                    ->inputMode('decimal'),
                
                Forms\Components\TagsInput::make('tags')
                    ->separator(',')
                    ->label('Tag Produk'),
                Forms\Components\Select::make('license_type')
                    ->options([
                        'free' => 'Gratis',
                        'personal' => 'Personal',
                        'commercial' => 'Komersial'
                    ])
                    ->required()
                    ->label('Tipe Lisensi'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Produk Unggulan')
                    ->helperText('Tampilkan di bagian Produk Unggulan di halaman utama')
                    ->default(false),
                Forms\Components\Toggle::make('is_bundling')
                    ->label('Produk Bundling')
                    ->helperText('Tampilkan di bagian Produk Bundling di halaman utama')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Produk'),
                Tables\Columns\ImageColumn::make('preview_image')
                    ->label('Preview')
                    ->disk('public')
                    ->visibility('public')
                    ->size(80)
                    ->square(),
                Tables\Columns\TextColumn::make('preview_video')
                    ->label('Video Preview')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('license_type')
                    ->label('Lisensi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'success',
                        'personal' => 'info',
                        'commercial' => 'warning',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Unggulan'),
                Tables\Columns\IconColumn::make('is_bundling')
                    ->boolean()
                    ->label('Bundling'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('license_type')
                    ->options([
                        'free' => 'Gratis',
                        'personal' => 'Personal',
                        'commercial' => 'Komersial'
                    ])
                    ->label('Tipe Lisensi'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Produk Unggulan'),
                Tables\Filters\TernaryFilter::make('is_bundling')
                    ->label('Produk Bundling'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
