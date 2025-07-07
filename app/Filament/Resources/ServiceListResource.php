<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceListResource\Pages;
use App\Models\ServiceList;
use App\Models\Service;
use App\Models\SparePart;
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
use Filament\Forms\Components\Placeholder;

class ServiceListResource extends Resource
{
    protected static ?string $model = ServiceList::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Booking (gajadi)';
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

                                // Select::make('kendaraan')
                                //     ->label('Kendaraan')
                                //     ->options([
                                //         'n-max' => 'N-max',
                                //         'vario' => 'Vario',
                                //         'beat' => 'Beat',
                                //         'scoopy' => 'Scoopy',
                                //     ])
                                //     ->default('Select')
                                //     ->required(),

                                Select::make('mechanic')
                                    ->label('Mechanic')
                                    ->options(function () {
                                        return \App\Models\Mekanik::with('user')
                                            ->get()
                                            ->mapWithKeys(function ($mekanik) {
                                                return [$mekanik->id_mekanik => $mekanik->user->name ?? 'Unknown User'];
                                            });
                                    })
                                    ->searchable()
                                    ->required()
                            ]),

                        Grid::make(3)
                            ->schema([
                                // TextInput::make('full_name')
                                //     ->label('Full Name')
                                //     ->required()
                                //     ->maxLength(255),

                                // Select::make('konsumen')
                                //     ->label('Konsumen')
                                //     ->options(function () {
                                //         return \App\Models\Konsumen::with('user')
                                //             ->get()
                                //             ->mapWithKeys(function ($konsumen) {
                                //                 return [$konsumen->id_konsumen => $konsumen->user->name ?? 'Unknown User'];
                                //             });
                                //     })
                                //     ->searchable()
                                //     ->required()
                                //     ->live()
                                //     ->afterStateUpdated(function ($state, Set $set) {
                                //         $set('plat_kendaraan', null);
                                //     }),

                                TextInput::make('full_name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),
                                // TextInput::make('cc_kendaraan')
                                //     ->label('CC Kendaraan')
                                //     ->numeric()
                                //     ->required(),

                                // Dropdown multiselect untuk List Service & Spare Part
                                Select::make('service_items')
                                    ->label('Service List')
                                    ->multiple()
                                    ->options(Service::all()->pluck('nama_service', 'id_service'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $serviceOptions = \App\Models\Service::query()->pluck('biaya_service', 'id_service')->toArray();
                                        $serviceTotal = collect($state)->sum(fn($item) => $serviceOptions[$item] ?? 0);

                                        // Ambil juga dari spare_part_items untuk hitung total keseluruhan
                                        $sparePartState = $get('spare_part_items') ?? [];
                                        $sparePartOptions = \App\Models\SparePart::query()->pluck('harga_barang', 'id_barang')->toArray();
                                        $sparePartTotal = collect($sparePartState)->sum(fn($item) => $sparePartOptions[$item] ?? 0);

                                        $set('total_price', $serviceTotal + $sparePartTotal);
                                    }),

                                Select::make('spare_part_items')
                                    ->label('Spare Part List')
                                    ->multiple()
                                    ->options(SparePart::all()->pluck('nama_barang', 'id_barang'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $sparePartOptions = \App\Models\SparePart::query()->pluck('harga_barang', 'id_barang')->toArray();
                                        $sparePartTotal = collect($state)->sum(fn($item) => $sparePartOptions[$item] ?? 0);

                                        // Ambil juga dari service_items untuk hitung total keseluruhan
                                        $serviceState = $get('service_items') ?? [];
                                        $serviceOptions = \App\Models\Service::query()->pluck('biaya_service', 'id_service')->toArray();
                                        $serviceTotal = collect($serviceState)->sum(fn($item) => $serviceOptions[$item] ?? 0);

                                        $set('total_price', $serviceTotal + $sparePartTotal);
                                    }),

                                // Select::make('spare_part_items')
                                //     ->label('Spare Part List')
                                //     ->multiple()
                                //     ->options(SparePart::all()->pluck('nama_barang', 'id_barang'))
                                //     ->searchable()
                                //     ->required()
                                //     ->live()
                                //     ->afterStateUpdated(function ($state, Set $set) {
                                //         $sparePartOptions = \App\Models\SparePart::query()->pluck('harga_barang', 'nama_barang')->toArray();
                                //         $total = collect($state)->sum(fn($item) => $sparePartOptions[$item] ?? 0);
                                //         $set('total_price', $total);
                                //     }),
                            ]),

                        Grid::make(3)
                            ->schema([
                                // Select::make('plat_kendaraan')
                                //     ->label('Plat Kendaraan')
                                //     ->options(function (Get $get) {
                                //         $konsumenId = $get('konsumen');
                                //         if (!$konsumenId) {
                                //             return [];
                                //         }

                                //         return \App\Models\PlatKendaraan::where('id_konsumen', $konsumenId)
                                //             ->get()
                                //             ->mapWithKeys(function ($plat) {
                                //                 return [
                                //                     $plat->id_plat_kendaraan => $plat->nomor_plat_kendaraan . ' (' . $plat->cc_kendaraan . ' CC)'
                                //                 ];
                                //             })
                                //             ->toArray();
                                //     })
                                //     ->searchable()
                                //     ->required()
                                //     ->placeholder('Pilih konsumen terlebih dahulu')
                                //     ->disabled(fn(Get $get) => !$get('konsumen')),

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
                                            Placeholder::make('subtotal')
                                                ->label('Subtotal')
                                                ->content(function (Get $get) {
                                                    $serviceOptions = \App\Models\Service::query()->pluck('biaya_service', 'id_service')->toArray();
                                                    $serviceNames = \App\Models\Service::query()->pluck('nama_service', 'id_service')->toArray();
                                                    $sparePartOptions = \App\Models\SparePart::query()->pluck('harga_barang', 'id_barang')->toArray();
                                                    $sparePartNames = \App\Models\SparePart::query()->pluck('nama_barang', 'id_barang')->toArray();

                                                    $serviceItems = $get('service_items') ?? [];
                                                    $sparePartItems = $get('spare_part_items') ?? [];

                                                    if (empty($serviceItems) && empty($sparePartItems)) {
                                                        return 'Belum ada item dipilih';
                                                    }

                                                    $lines = [];

                                                    if (!empty($serviceItems)) {
                                                        $lines[] = "**Service Items**";
                                                        foreach ($serviceItems as $id) {
                                                            $name = $serviceNames[$id] ?? '-';
                                                            $price = $serviceOptions[$id] ?? 0;
                                                            $lines[] = "$name - Rp. " . number_format($price, 0, ',', '.');
                                                        }
                                                    }

                                                    if (!empty($sparePartItems)) {
                                                        $lines[] = "\n**Spare Part Items**";
                                                        foreach ($sparePartItems as $id) {
                                                            $name = $sparePartNames[$id] ?? '-';
                                                            $price = $sparePartOptions[$id] ?? 0;
                                                            $lines[] = "$name - Rp. " . number_format($price, 0, ',', '.');
                                                        }
                                                    }

                                                    $total = collect($serviceItems)->sum(fn($id) => $serviceOptions[$id] ?? 0)
                                                        + collect($sparePartItems)->sum(fn($id) => $sparePartOptions[$id] ?? 0);

                                                    $lines[] = str_repeat('-', 30);
                                                    $lines[] = "TOTAL - Rp. " . number_format($total, 0, ',', '.');

                                                    return implode("\n", $lines);
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
