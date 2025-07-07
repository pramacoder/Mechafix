<?php

namespace App\Filament\Mekanik\Resources;

use App\Filament\Resources\TransaksiRiwayatResource\Pages;
use App\Models\RiwayatPerbaikan;
use App\Models\TransaksiService;
use App\Models\TransaksiSparePart;
use App\Models\Pembayaran;
use App\Models\Service;
use App\Models\SparePart;
use App\Models\PlatKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Console\View\Components\Task;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Service Management';
    protected static ?string $navigationLabel = 'Complete Service Record';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Services & Spare Parts')
                        ->schema([
                            Forms\Components\Select::make('id_booking_service')
                                ->label('Booking Service')
                                ->options(function ($get) {
                                    $selected = $get('id_booking_service');
                                    return \App\Models\BookingService::with(['konsumens.user'])
                                        ->when($selected, fn($query) => $query->orWhere('id_booking_service', $selected))
                                        ->get()
                                        ->mapWithKeys(fn($b) => [
                                            $b->id_booking_service => "#{$b->id_booking_service} - {$b->konsumens->user->name}" // Perbaiki: konsumens
                                        ]);
                                })
                                ->searchable()
                                ->nullable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $booking = \App\Models\BookingService::with([
                                            'konsumens.user',
                                            'platKendaraan',
                                            'mekanik.user',
                                            'transaksiServices.service',
                                            'transaksiSpareParts.sparePart'
                                        ])->find($state);

                                        $set('id_konsumen', $booking?->id_konsumen);
                                        $set('id_plat_kendaraan', $booking?->id_plat_kendaraan);
                                        $set('id_mekanik', $booking?->id_mekanik);

                                        // Set tanggal dengan format yang benar
                                        $set('tanggal_perbaikan', $booking?->tanggal_booking?->format('Y-m-d') ?? today()->format('Y-m-d'));

                                        // Set services dan spare parts dari booking
                                        $set('transaksi_services', $booking?->transaksiServices->map(function ($ts) {
                                            return [
                                                'id_service' => $ts->id_service,
                                                'kuantitas_service' => $ts->kuantitas_service,
                                                'subtotal_service' => $ts->subtotal_service,
                                            ];
                                        })->toArray() ?? []);

                                        $set('transaksi_spare_parts', $booking?->transaksiSpareParts->map(function ($tp) {
                                            return [
                                                'id_barang' => $tp->id_barang,
                                                'kuantitas_barang' => $tp->kuantitas_barang,
                                                'subtotal_barang' => $tp->subtotal_barang,
                                            ];
                                        })->toArray() ?? []);

                                        // Perhitungan total
                                        $totalService = collect($booking?->transaksiServices)->sum(function ($ts) {
                                            return $ts->kuantitas_service * ($ts->service->biaya_service ?? 0);
                                        });

                                        $totalSparepart = collect($booking?->transaksiSpareParts)->sum(function ($tp) {
                                            return $tp->kuantitas_barang * ($tp->sparePart->harga_barang ?? 0);
                                        });

                                        $set('total_pembayaran', $totalService + $totalSparepart);
                                    } else {
                                        $set('id_konsumen', null);
                                        $set('id_plat_kendaraan', null);
                                        $set('id_mekanik', null);
                                        $set('tanggal_perbaikan', today()->format('Y-m-d'));
                                        $set('transaksi_services', []);
                                        $set('transaksi_spare_parts', []);
                                        $set('total_pembayaran', 0);
                                    }
                                })
                                ->dehydrated(fn($state) => filled($state))
                                ->live(),

                            Forms\Components\Hidden::make('id_konsumen')
                                ->dehydrated(true)
                                ->required(),

                            Forms\Components\Hidden::make('id_plat_kendaraan')
                                ->dehydrated(true)
                                ->required(),

                            Forms\Components\Hidden::make('id_mekanik')
                                ->dehydrated(true)
                                ->required(),

                            Forms\Components\Placeholder::make('customer_vehicle_info')
                                ->label('Customer & Vehicle Information')
                                ->content(function (Get $get) {
                                    $bookingId = $get('id_booking_service');
                                    if ($bookingId) {
                                        $booking = \App\Models\BookingService::with(['konsumens.user', 'platKendaraan', 'mekanik.user'])->find($bookingId);
                                        if ($booking) {
                                            $customer = $booking->konsumens->user->name ?? 'Unknown'; // Perbaiki: konsumens
                                            $vehicle = $booking->platKendaraan->nomor_plat_kendaraan ?? 'Unknown';
                                            $mechanic = $booking->mekanik->user->name ?? 'Unknown';

                                            return "Customer: {$customer}\nVehicle: {$vehicle}\nAssigned Mechanic: {$mechanic}";
                                        }
                                    }
                                    return 'Select booking service first';
                                })
                                ->extraAttributes(['style' => 'white-space: pre-line; background: #f3f4f6; padding: 12px; border-radius: 6px;']),

                            Forms\Components\Repeater::make('transaksi_services')
                                ->label('Services Performed')
                                ->schema([
                                    Forms\Components\Select::make('id_service')
                                        ->label('Service')
                                        ->options(Service::all()->mapWithKeys(fn($s) => [
                                            $s->id_service => $s->nama_service . ' (Rp ' . number_format($s->biaya_service, 0, ',', '.') . ')'
                                        ]))
                                        ->searchable()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            if ($state) {
                                                $service = Service::find($state);
                                                $qty = $get('kuantitas_service') ?: 1;
                                                $subtotal = $service ? $service->biaya_service * $qty : 0;
                                                $set('subtotal_service', $subtotal);
                                            }
                                        }),

                                    Forms\Components\TextInput::make('kuantitas_service')
                                        ->label('Quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            $serviceId = $get('id_service');
                                            if ($serviceId) {
                                                $service = Service::find($serviceId);
                                                $subtotal = $service ? $service->biaya_service * $state : 0;
                                                $set('subtotal_service', $subtotal);
                                            }
                                        }),

                                    Forms\Components\TextInput::make('subtotal_service')
                                        ->label('Subtotal')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated(),
                                ])
                                ->addActionLabel('Add Service')
                                ->columns(3)
                                ->defaultItems(0)
                                ->collapsible(),

                            Forms\Components\Repeater::make('transaksi_spare_parts')
                                ->label('Spare Parts Used')
                                ->schema([
                                    Forms\Components\Select::make('id_barang')
                                        ->label('Spare Part')
                                        ->options(SparePart::all()->mapWithKeys(fn($sp) => [
                                            $sp->id_barang => $sp->nama_barang . ' (Rp ' . number_format($sp->harga_barang, 0, ',', '.') . ')'
                                        ]))
                                        ->searchable()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            if ($state) {
                                                $sparePart = SparePart::find($state);
                                                $qty = $get('kuantitas_barang') ?: 1;
                                                $subtotal = $sparePart ? $sparePart->harga_barang * $qty : 0;
                                                $set('subtotal_barang', $subtotal);
                                            }
                                        }),

                                    Forms\Components\TextInput::make('kuantitas_barang')
                                        ->label('Quantity')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            $sparePartId = $get('id_barang');
                                            if ($sparePartId) {
                                                $sparePart = SparePart::find($sparePartId);
                                                $subtotal = $sparePart ? $sparePart->harga_barang * $state : 0;
                                                $set('subtotal_barang', $subtotal);
                                            }
                                        }),

                                    Forms\Components\TextInput::make('subtotal_barang')
                                        ->label('Subtotal')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated(),
                                ])
                                ->addActionLabel('Add Spare Part')
                                ->columns(3)
                                ->defaultItems(0)
                                ->collapsible(),

                            Forms\Components\Placeholder::make('total_summary')
                                ->label('Total Summary')
                                ->content(function (Get $get) {
                                    $services = $get('transaksi_services') ?? [];
                                    $spareParts = $get('transaksi_spare_parts') ?? [];

                                    $serviceTotal = collect($services)->sum('subtotal_service');
                                    $sparePartTotal = collect($spareParts)->sum('subtotal_barang');
                                    $grandTotal = $serviceTotal + $sparePartTotal;

                                    return "Service Total: Rp " . number_format($serviceTotal, 0, ',', '.') . "\n" .
                                        "Spare Parts Total: Rp " . number_format($sparePartTotal, 0, ',', '.') . "\n" .
                                        "GRAND TOTAL: Rp " . number_format($grandTotal, 0, ',', '.');
                                })
                                ->extraAttributes(['style' => 'white-space: pre-line; font-weight: bold;']),
                        ]),

                    Wizard\Step::make('Repair History Details')
                        ->schema([
                            Forms\Components\Placeholder::make('tanggal_perbaikan_display')
                                ->label('Repair Date')
                                ->content(function (Get $get) {
                                    $bookingId = $get('id_booking_service');
                                    if ($bookingId) {
                                        $booking = \App\Models\BookingService::find($bookingId);
                                        return $booking?->tanggal_booking?->format('d F Y') ?? 'No date available';
                                    }
                                    return 'Select booking service first';
                                }),

                            // Tambahkan hidden field untuk menyimpan data ke database
                            Forms\Components\Hidden::make('tanggal_perbaikan')
                                ->default(function (Get $get) {
                                    $bookingId = $get('id_booking_service');
                                    if ($bookingId) {
                                        $booking = \App\Models\BookingService::find($bookingId);
                                        return $booking?->tanggal_booking?->format('Y-m-d') ?? today()->format('Y-m-d');
                                    }
                                    return today()->format('Y-m-d');
                                })
                                ->reactive(),

                            Forms\Components\Textarea::make('deskripsi_perbaikan')
                                ->label('Repair Description')
                                ->required()
                                ->rows(5)
                                ->placeholder('Describe the repair work performed, issues found, parts replaced, etc.'),

                            Forms\Components\FileUpload::make('dokumentasi_perbaikan')
                                ->label('Repair Documentation')
                                ->image()
                                ->directory('repair-documentation')
                                ->visibility('public')
                                ->helperText('Upload photos of the repair work')
                                ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),

                            Forms\Components\DatePicker::make('next_service')
                                ->label('Next Service Recommendation')
                                ->required()
                                ->default(now()->addMonths(3))
                                ->helperText('Recommend when the next service should be performed'),
                        ])
                        ->columns(2),
                ])
                    ->columnSpanFull()
                    ->persistStepInQueryString()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_riwayat_perbaikan')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('platKendaraan.konsumens.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('platKendaraan.nomor_plat_kendaraan')
                    ->label('Vehicle')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mekanik.user.name')
                    ->label('Mechanic')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('services_summary')
                    ->label('Services')
                    ->getStateUsing(function ($record) {
                        // Ambil services berdasarkan id_pembayaran
                        $services = \App\Models\TransaksiService::where('id_pembayaran', $record->id_pembayaran)
                            ->with('service')
                            ->get();
                        if ($services->isEmpty()) {
                            return 'No services';
                        }

                        return $services->map(function ($ts) {
                            $nama = $ts->service->nama_service ?? 'Unknown';
                            $qty = $ts->kuantitas_service;
                            return $qty > 1 ? "{$nama} (x{$qty})" : $nama;
                        })->implode(', ');
                    }),

                Tables\Columns\TextColumn::make('spare_parts_summary')
                    ->label('Spare Parts')
                    ->getStateUsing(function ($record) {
                        // Ambil spare parts berdasarkan id_pembayaran
                        $spareParts = \App\Models\TransaksiSparePart::where('id_pembayaran', $record->id_pembayaran)
                            ->with('sparePart')
                            ->get();

                        if ($spareParts->isEmpty()) {
                            return 'No spare parts';
                        }

                        return $spareParts->map(function ($tp) {
                            $nama = $tp->sparePart->nama_barang ?? 'Unknown';
                            $qty = $tp->kuantitas_barang;
                            return $qty > 1 ? "{$nama} (x{$qty})" : $nama;
                        })->implode(', ');
                    }),

                // Perbaikan: Hitung total dari pembayaran
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->getStateUsing(function ($record) {
                        // Gunakan total_pembayaran dari record pembayaran
                        return 'Rp ' . number_format($record->pembayaran->total_pembayaran ?? 0, 0, ',', '.');
                    }),

                Tables\Columns\TextColumn::make('tanggal_perbaikan')
                    ->label('Repair Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_service')
                    ->label('Next Service')
                    ->date()
                    ->sortable()
                    ->color(fn($state) => $state && $state < today() ? 'danger' : 'success'),

                Tables\Columns\ImageColumn::make('dokumentasi_perbaikan')
                    ->label('Documentation')
                    ->size(40)
                    ->circular(),
            ])
            ->filters([
                Tables\Filters\Filter::make('next_service_due')
                    ->label('Next Service Due')
                    ->query(fn($query) => $query->where('next_service', '<=', today())),

                Tables\Filters\SelectFilter::make('mekanik')
                    ->relationship('mekanik.user', 'name')
                    ->label('Mechanic'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'platKendaraan.konsumens.user',
                'mekanik.user',
                'pembayaran',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksiRiwayats::route('/'),
            'create' => Pages\CreateTransaksiRiwayat::route('/create'),
            'edit' => Pages\EditTransaksiRiwayat::route('/{record}/edit'),
        ];
    }
}
