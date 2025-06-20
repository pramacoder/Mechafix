<?php
// filepath: c:\laragon\www\Mechafix\app\Filament\Resources\KonsumenResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\KonsumenResource\Pages;
use App\Models\Konsumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KonsumenResource extends Resource
{
    protected static ?string $model = Konsumen::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Customer Management';
    protected static ?string $navigationLabel = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id')
                    ->label('User Account')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' (' . $record->email . ')'),
                Forms\Components\Textarea::make('alamat_konsumen')
                    ->label('Address')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_konsumen')
                    ->label('Customer ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_konsumen')
                    ->label('Address')
                    ->limit(50),
                Tables\Columns\TextColumn::make('plat_kendaraan_count')
                    ->label('Vehicles')
                    ->counts('platKendaraan'),
                Tables\Columns\TextColumn::make('booking_services_count')
                    ->label('Bookings')
                    ->counts('bookingServices'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_vehicles')
                    ->label('Has Vehicles')
                    ->query(fn($query) => $query->has('platKendaraan')),
                Tables\Filters\Filter::make('has_bookings')
                    ->label('Has Bookings')
                    ->query(fn($query) => $query->has('bookingServices')),
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
            'index' => Pages\ListKonsumens::route('/'),
            'create' => Pages\CreateKonsumen::route('/create'),
            'edit' => Pages\EditKonsumen::route('/{record}/edit'),
        ];
    }
}
