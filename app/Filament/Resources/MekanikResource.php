<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MekanikResource\Pages;
use App\Models\Mekanik;
use App\Models\User;
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
                Forms\Components\Select::make('id_user')
                    ->label('User Account')
                    ->options(function () {
                        return User::where('role', 'mekanik')
                            ->whereDoesntHave('mekanik')
                            ->get()
                            ->mapWithKeys(function ($user) {
                                return [$user->id => $user->name . ' (' . $user->email . ')'];
                            });
                    })
                    ->required()
                    ->searchable()
                    ->placeholder('Select a user with mechanic role'),

                Forms\Components\TextInput::make('kuantitas_hari')
                    ->label('Days Available')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->minValue(1)
                    ->maxValue(7)
                    ->helperText('Number of days available each week (1-7)'),
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
                Tables\Columns\TextColumn::make('kuantitas_hari')
                    ->label('Days Available')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state <= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('availability')
                    ->label('Availability')
                    ->options([
                        'high' => 'High (5+ days)',
                        'medium' => 'Medium (3-4 days)', 
                        'low' => 'Low (1-2 days)',
                        'none' => 'Not Available (0 days)'
                    ])
                    ->query(function ($query, array $data) {
                        if (!$data['value']) return $query;
                        
                        return match($data['value']) {
                            'high' => $query->where('kuantitas_hari', '>=', 5),
                            'medium' => $query->whereBetween('kuantitas_hari', [3, 4]),
                            'low' => $query->whereBetween('kuantitas_hari', [1, 2]),
                            'none' => $query->where('kuantitas_hari', 0),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('updateAvailability')
                    ->label('Update Days')
                    ->icon('heroicon-o-calendar')
                    ->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('kuantitas_hari')
                            ->label('Days Available')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(7),
                    ])
                    ->action(function (Mekanik $record, array $data) {
                        $record->update(['kuantitas_hari' => $data['kuantitas_hari']]);
                    })
                    ->successNotificationTitle('Days availability updated successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('bulkUpdateAvailability')
                        ->label('Update Days Available')
                        ->icon('heroicon-o-calendar')
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('kuantitas_hari')
                                ->label('Days Available')
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->maxValue(7),
                        ])
                        ->action(function ($records, array $data) {
                            foreach ($records as $record) {
                                $record->update(['kuantitas_hari' => $data['kuantitas_hari']]);
                            }
                        })
                        ->successNotificationTitle('Bulk update completed'),
                ]),
            ])
            ->defaultSort('kuantitas_hari', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMekaniks::route('/'),
            'create' => Pages\CreateMekanik::route('/create'),
            'edit' => Pages\EditMekanik::route('/{record}/edit'),
        ];
    }

    // ADD: Custom navigation badge
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('kuantitas_hari', '>', 0)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}