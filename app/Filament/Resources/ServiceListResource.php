<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceListResource\Pages;
use App\Models\ServiceList;
use Filament\Infolists\Components\Tabs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Infolist;
use Illuminate\Validation\Rules\In;

class ServiceListResource extends Resource
{
    protected static ?string $model = ServiceList::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Booking';
    protected static ?string $navigationGroup = 'Customer Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create New List!')
                    ->description('Make with detail notes!')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('id_user')
                                    ->label('ID User')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('kendaraan')
                                    ->label('Kendaraan')
                                    ->options([
                                        'n-max' => 'N-max',
                                        'vario' => 'Vario',
                                        'beat' => 'Beat',
                                        'scoopy' => 'Scoopy',
                                    ])
                                    ->default('Select')
                                    ->required(),

                                Select::make('mechanic')
                                    ->label('Mechanic')
                                    ->options ([
                                        'andi' => 'Andi',
                                        'budi' => 'Budi',
                                        'cici' => 'Cici',
                                        'didi' => 'Didi',
                                        'bagus'=> 'Bagus',
                                        ])
                                    ->default('Select')
                                    ->required()
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('cc_kendaraan')
                                    ->label('CC Kendaraan')
                                    ->numeric()
                                    ->required(),

                                Repeater::make('service_items')
                                    ->label('List')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('item_name')
                                                    ->label('Item')
                                                    ->required(),
                                                TextInput::make('price')
                                                    ->label('Price')
                                                    ->numeric()
                                                    ->prefix('Rp.')
                                                    ->required(),
                                            ])
                                    ])
                                    ->defaultItems(5)
                                    ->default([
                                        ['item_name' => 'Oli Kastrol F-1', 'price' => 20000],
                                        ['item_name' => 'V-Belt', 'price' => 200000],
                                        ['item_name' => 'Kampas Rem', 'price' => 80000],
                                        ['item_name' => 'Busi Motor', 'price' => 30000],
                                        ['item_name' => 'Service Motor', 'price' => 200000],
                                    ])
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $items = $get('service_items') ?? [];
                                        $total = collect($items)->sum('price');
                                        $set('total_price', $total);
                                    })
                                    ->addActionLabel('Add Item')
                                    ->reorderable(false)
                                    ->deletable(true)
                                    ->collapsible(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('plat_kendaraan')
                                    ->label('Plat Kendaraan')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('note')
                                    ->label('Note')
                                    ->rows(4),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('total_price')
                                            ->label('Subtotal')
                                            ->prefix('Rp.')
                                            ->numeric()
                                            ->default(530000)
                                            ->readOnly()
                                            ->extraAttributes([
                                                'class' => 'font-bold text-lg'
                                            ]),

                                        TextInput::make('total_price')
                                            ->label('TOTAL')
                                            ->prefix('Rp.')
                                            ->numeric()
                                            ->default(530000)
                                            ->readOnly()
                                            ->extraAttributes([
                                                'class' => 'font-bold text-xl text-green-600'
                                            ]),
                                    ]),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('id_booking')
                                    ->label('ID Booking')
                                    ->default('FX210512345')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('estimate_time')
                                    ->label('Estimate')
                                    ->default('45 minutes')
                                    ->required()
                                    ->maxLength(255),

                                // Empty column for alignment
                                Forms\Components\Placeholder::make('')
                            ]),

                        Grid::make(3)
                            ->schema([
                                DatePicker::make('tgl_booking')
                                    ->label('Tgl Booking')
                                    ->default('2025-05-21')
                                    ->required(),

                                // Empty columns for alignment
                                Forms\Components\Placeholder::make(''),
                                Forms\Components\Placeholder::make(''),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_user')
                    ->label('ID User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plat_kendaraan')
                    ->label('Plat Kendaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kendaraan')
                    ->label('Kendaraan'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('tgl_booking')
                    ->label('Tanggal Booking')
                    ->date(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceLists::route('/'),
            'create' => Pages\CreateServiceList::route('/create'),
            'edit' => Pages\EditServiceList::route('/{record}/edit'),
        ];
    }
}
