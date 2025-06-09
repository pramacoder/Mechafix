<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MekanikResource\Pages;
use App\Models\Mekanik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MekanikResource extends Resource
{
    protected static ?string $model = Mekanik::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Mechanics';

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_mekanik')
                    ->label('Mechanic ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookingServices_count')
                    ->label('Active Jobs')
                    ->counts('bookingServices'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListMekaniks::route('/'),
            'create' => Pages\CreateMekanik::route('/create'),
            'edit' => Pages\EditMekanik::route('/{record}/edit'),
        ];
    }
}