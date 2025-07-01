<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_service')
                    ->label('Service Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_service')
                    ->label('Service Type')
                    ->options([
                        'Service Rutin' => 'Service Rutin',
                        'Service Berat' => 'Service Berat',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('biaya_service')
                    ->label('Service Cost')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('estimasi_waktu')
                    ->label('Estimated Time (minutes)')
                    ->required()
                    ->numeric()
                    ->suffix('minutes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_service')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_service')
                    ->label('Service Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('jenis_service')
                    ->label('Type')
                    ->colors([
                        'primary' => 'Service Rutin',
                        'warning' => 'Service Berat',
                    ]),
                Tables\Columns\TextColumn::make('biaya_service')
                    ->label('Cost')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimasi_waktu')
                    ->label('Est. Time')
                    ->suffix(' min')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_service')
                    ->options([
                        'Service Rutin' => 'Service Rutin',
                        'Service Berat' => 'Service Berat',
                    ]),
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
            ->defaultSort('nama_service');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}