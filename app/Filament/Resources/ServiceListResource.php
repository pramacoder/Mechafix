<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceListResource\Pages;
use App\Models\ServiceList;
use App\Models\Service;
use App\Models\Mekanik;
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
                                    ->options([
                                        'mechanic1' => 'Mechanic 1',
                                        'mechanic2' => 'Mechanic 2',])
                                    // ->options(
                                    //     \App\Models\Mekanik::query()
                                    //         ->pluck('nama_mekanik', 'id_mekanik')
                                    //         ->toArray()
                                    // )
                                    ->searchable()
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

                                // Dropdown multiselect untuk List Service
                                Select::make('service_items')
                                    ->label('List')
                                    ->multiple()
                                    ->options(Service::all()->pluck('nama_service', 'id_service'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $serviceOptions = \App\Models\Service::query()->pluck('biaya_service', 'nama_service')->toArray();
                                        $total = collect($state)->sum(fn($item) => $serviceOptions[$item] ?? 0);
                                        $set('total_price', $total);
                                    }),
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
                                        Forms\Components\Card::make([
                                            Forms\Components\Placeholder::make('subtotal')
                                                ->label('Subtotal')
                                                ->content(function (Get $get) {
                                                    $serviceOptions = \App\Models\Service::query()->pluck('biaya_service', 'id_service')->toArray();
                                                    $serviceNames = \App\Models\Service::query()->pluck('nama_service', 'id_service')->toArray();
                                                    $items = $get('service_items') ?? [];
                                                    if (empty($items)) {
                                                        return 'Belum ada item dipilih';
                                                    }
                                                    // Untuk rata kanan harga, cari panjang nama terpanjang
                                                    $maxNameLength = collect($items)->map(fn($id) => strlen($serviceNames[$id] ?? ''))->max() + 2;
                                                    $lines = collect($items)->map(function ($id) use ($serviceOptions, $serviceNames, $maxNameLength) {
                                                        $name = $serviceNames[$id] ?? '-';
                                                        $price = $serviceOptions[$id] ?? 0;
                                                        return str_pad($name, $maxNameLength, ' ', STR_PAD_RIGHT) . 'Rp. ' . number_format($price, 0, ',', '.');
                                                    })->implode("\n");
                                                    $total = collect($items)->sum(fn($id) => $serviceOptions[$id] ?? 0);
                                                    return $lines . "\n" . str_repeat('-', 30) . "\n" .
                                                        str_pad('TOTAL', $maxNameLength, ' ', STR_PAD_RIGHT) . 'Rp. ' . number_format($total, 0, ',', '.');
                                                })
                                                ->extraAttributes(['class' => 'font-bold text-lg', 'style' => 'white-space: pre-line;'])
                                                ->columnSpan(1),
                                        ])->columnSpan(1),
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
