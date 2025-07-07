<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatKendaraanResource\Pages;
use App\Models\PlatKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlatKendaraanResource extends Resource
{
    protected static ?string $model = PlatKendaraan::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Vehicle Management';
    protected static ?string $navigationLabel = 'Vehicles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_plat_kendaraan')
                    ->label('License Plate Number')
                    ->required()
                    ->maxLength(15)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('cc_kendaraan')
                    ->label('Engine Capacity (CC)')
                    ->numeric()
                    ->required()
                    ->minValue(50)
                    ->maxValue(10000),
                Forms\Components\Select::make('id_konsumen')
                    ->label('Owner')
                    ->options(function () {
                        return \App\Models\Konsumen::with('user')
                            ->get()
                            ->mapWithKeys(function ($konsumen) {
                                return [$konsumen->id_konsumen => $konsumen->user->name ?? 'Unknown User'];
                            });
                    })
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_plat_kendaraan')
                    ->label('Vehicle ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_plat_kendaraan')
                    ->label('License Plate')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cc_kendaraan')
                    ->label('Engine (CC)')
                    ->suffix(' CC')
                    ->sortable(),
                Tables\Columns\TextColumn::make('konsumen.user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('konsumen.user.email')
                    ->label('Owner Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookingServices_count')
                    ->label('Total Bookings')
                    ->counts('bookingServices'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('cc_range')
                    ->form([
                        Forms\Components\TextInput::make('cc_from')
                            ->label('CC From')
                            ->numeric(),
                        Forms\Components\TextInput::make('cc_to')
                            ->label('CC To')
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['cc_from'], fn($q) => $q->where('cc_kendaraan', '>=', $data['cc_from']))
                            ->when($data['cc_to'], fn($q) => $q->where('cc_kendaraan', '<=', $data['cc_to']));
                    }),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlatKendaraans::route('/'),
            'create' => Pages\CreatePlatKendaraan::route('/create'),
            'edit' => Pages\EditPlatKendaraan::route('/{record}/edit'),
        ];
    }
}
