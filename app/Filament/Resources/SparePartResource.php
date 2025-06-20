<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SparePartResource\Pages;
use App\Filament\Resources\SparePartResource\RelationManagers;
use App\Models\SparePart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ramsey\Uuid\Type\Integer;

class SparePartResource extends Resource
{
    protected static ?string $model = SparePart::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Spare Parts';
    protected static ?Int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('deskripsi_barang')
                    ->label('Deskripsi Barang')
                    ->required()
                    ->rows(3),

                Forms\Components\TextInput::make('harga_barang')
                    ->label('Harga Barang')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0),

                Forms\Components\TextInput::make('kuantitas_barang')
                    ->label('Kuantitas Stok')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Forms\Components\FileUpload::make('gambar_barang')
                    ->label('Gambar Barang')
                    ->image()
                    ->directory('spare-parts')
                    ->visibility('public')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth(400)
                    ->imageResizeTargetHeight(400)
                    ->required(),

                Forms\Components\TextInput::make('link_shopee')
                    ->label('Link Shopee')
                    ->url()
                    ->nullable()
                    ->helperText('Optional: Link ke produk di Shopee'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_barang')
                    ->label('Gambar')
                    ->size(60)
                    ->circular(),

                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('harga_barang')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kuantitas_barang')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state == 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('link_shopee')
                    ->label('Shopee Link')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->link_shopee)
                    ->url(fn ($record) => $record->link_shopee)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-link'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('stok_rendah')
                    ->label('Stok Rendah')
                    ->query(fn (Builder $query): Builder => $query->where('kuantitas_barang', '<=', 10)),

                Tables\Filters\Filter::make('stok_habis')
                    ->label('Stok Habis')
                    ->query(fn (Builder $query): Builder => $query->where('kuantitas_barang', '=', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama_barang', 'asc');
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
            'index' => Pages\ListSpareParts::route('/'),
            'create' => Pages\CreateSparePart::route('/create'),
            'edit' => Pages\EditSparePart::route('/{record}/edit'),
        ];
    }
}
