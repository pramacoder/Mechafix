<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\BookingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Service;
use App\Models\SparePart;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Financial Management';
    protected static ?string $navigationLabel = 'Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_pembayaran')
                    ->label('Payment ID')
                    ->disabled()
                    ->visibleOn('edit'),

                Forms\Components\Select::make('id_booking_service')
                    ->label('Booking Service (Optional)')
                    ->options(function ($get) {
                        $selected = $get('id_booking_service');
                        return \App\Models\BookingService::with(['konsumen.user'])
                            // ->whereNull('id_pembayaran')
                            ->when($selected, fn($query) => $query->orWhere('id_booking_service', $selected))
                            ->get()
                            ->mapWithKeys(fn($b) => [
                                $b->id_booking_service => "#{$b->id_booking_service} - {$b->konsumen->user->name}"
                            ]);
                    })
                    ->searchable()
                    ->nullable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $booking = \App\Models\BookingService::with([
                                'konsumen.user',
                                'platKendaraan',
                                'transaksiServices.service',
                                'transaksiSpareParts.sparePart'
                            ])->find($state);

                            // Set otomatis customer & plat
                            $set('id_konsumen', $booking?->id_konsumen);
                            $set('id_plat_kendaraan', $booking?->id_plat_kendaraan);

                            // Set otomatis transaksiServices dari booking
                            $set('transaksiServices', $booking?->transaksiServices->map(function ($ts) {
                                return [
                                    'id_service' => $ts->id_service,
                                    'kuantitas_service' => $ts->kuantitas_service,
                                    'subtotal_service' => $ts->subtotal_service,
                                ];
                            })->toArray() ?? []);

                            // Set otomatis transaksiSpareParts dari booking
                            $set('transaksiSpareParts', $booking?->transaksiSpareParts->map(function ($tp) {
                                return [
                                    'id_barang' => $tp->id_barang,
                                    'kuantitas_barang' => $tp->kuantitas_barang,
                                    'subtotal_barang' => $tp->subtotal_barang,
                                ];
                            })->toArray() ?? []);
                        } else {
                            $set('id_konsumen', null);
                            $set('id_plat_kendaraan', null);
                            $set('transaksiServices', []);
                            $set('transaksiSpareParts', []);
                        }
                        $totalService = collect($booking?->transaksiServices)->sum(function ($ts) {
                            return $ts->kuantitas_service * ($ts->service->biaya_service ?? 0);
                        });

                        $totalSparepart = collect($booking?->transaksiSpareParts)->sum(function ($tp) {
                            return $tp->kuantitas_barang * ($tp->sparePart->harga_barang ?? 0);
                        });

                        $set('total_pembayaran', $totalService + $totalSparepart);
                    })
                    ->dehydrated(fn($state) => filled($state))
                    ->live(),

                Forms\Components\Select::make('id_konsumen')
                    ->label('Customer')
                    ->options(
                        \App\Models\Konsumen::with('user')->get()->mapWithKeys(fn($k) => [
                            $k->id_konsumen => $k->user->name ?? 'Unknown'
                        ])
                    )
                    ->searchable()
                    ->required(fn($get) => blank($get('id_booking_service')))
                    ->disabled(fn($get) => filled($get('id_booking_service')))
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('id_plat_kendaraan', null))
                    ->placeholder('Select a customer')
                    ->dehydrated(),

                Forms\Components\Repeater::make('transaksiServices')
                    ->relationship('transaksiServices')
                    ->label('Services')
                    ->schema([
                        Forms\Components\Select::make('id_service')
                            ->label('Service')
                            ->options(\App\Models\Service::all()->mapWithKeys(fn($s) => [
                                $s->id_service => $s->nama_service . ' (Rp ' . number_format($s->biaya_service, 0, ',', '.') . ')'
                            ]))
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::updateServiceSubtotal($set, $get);
                                self::updateTotalFromRepeater($set, $get, '../../');
                            })
                            ->dehydrated(fn($state) => filled($state)),

                        Forms\Components\TextInput::make('kuantitas_service')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::updateServiceSubtotal($set, $get);
                                self::updateTotalFromRepeater($set, $get, '../../');
                            })
                            ->required(),

                        Forms\Components\TextInput::make('subtotal_service')
                            ->label('Subtotal')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(true)
                            ->default(0)
                            ->reactive(),
                    ])
                    ->addActionLabel('Add Service')
                    ->deleteAction(fn($action) => $action->label('Delete')->after(function (callable $set, callable $get) {
                        self::updateTotalFromRepeater($set, $get, '../');
                    }))
                    ->columns(3)
                    ->defaultItems(0)
                    ->collapsible(),

                Forms\Components\Repeater::make('transaksiSpareParts')
                    ->relationship('transaksiSpareParts')
                    ->label('Spare Parts')
                    ->schema([
                        Forms\Components\Select::make('id_barang')
                            ->label('Spare Part')
                            ->options(\App\Models\SparePart::all()->mapWithKeys(fn($sp) => [
                                $sp->id_barang => $sp->nama_barang . ' (Rp ' . number_format($sp->harga_barang, 0, ',', '.') . ')'
                            ]))
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::updateSparepartSubtotal($set, $get);
                                self::updateTotalFromRepeater($set, $get, '../../');
                            })
                            ->dehydrated(fn($state) => filled($state)),

                        Forms\Components\TextInput::make('kuantitas_barang')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                self::updateSparepartSubtotal($set, $get);
                                self::updateTotalFromRepeater($set, $get, '../../');
                            })
                            ->required(),

                        Forms\Components\TextInput::make('subtotal_barang')
                            ->label('Subtotal')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(true)
                            ->default(0)
                            ->reactive(),
                    ])
                    ->addActionLabel('Add Spare Part')
                    ->deleteAction(fn($action) => $action->label('Delete')->after(function (callable $set, callable $get) {
                        self::updateTotalFromRepeater($set, $get, '../');
                    }))
                    ->columns(3)
                    ->defaultItems(0)
                    ->collapsible(),

                Forms\Components\Placeholder::make('total_pembayaran_display')
                    ->label('Total Amount')
                    ->content(function ($get) {
                        $total = $get('total_pembayaran') ?? 0;
                        return 'Rp ' . number_format($total, 0, ',', '.');
                    })
                    ->reactive(),

                Forms\Components\Hidden::make('total_pembayaran')
                    ->dehydrated(true)
                    ->default(0)
                    ->reactive(),

                Forms\Components\DatePicker::make('tanggal_pembayaran')
                    ->label('Payment Date')
                    ->required()
                    ->default(today()),

                Forms\Components\FileUpload::make('qris')
                    ->label('QRIS Code')
                    ->image()
                    ->directory('qris-codes')
                    ->visibility('public')
                    ->default('oli motor.webp')
                    ->helperText('QRIS code untuk pembayaran digital')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),

                Forms\Components\FileUpload::make('bukti_pembayaran')
                    ->label('Payment Proof')
                    ->image()
                    ->directory('payment-proofs')
                    ->visibility('public')
                    ->nullable()
                    ->helperText('Upload bukti pembayaran dari customer')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),

                Forms\Components\Select::make('status_pembayaran')
                    ->label('Payment Status')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Sudah Dibayar' => 'Sudah Dibayar',
                    ])
                    ->required()
                    ->default('Belum Dibayar'),
            ]);
    }

    private static function updateServiceSubtotal(callable $set, callable $get): void
    {
        $idService = $get('id_service');
        $qty = (int)($get('kuantitas_service') ?? 1);

        if ($idService) {
            $harga = \App\Models\Service::find($idService)?->biaya_service ?? 0;
            $subtotal = $harga * $qty;
            $set('subtotal_service', $subtotal);
        } else {
            $set('subtotal_service', 0);
        }
    }

    private static function updateSparepartSubtotal(callable $set, callable $get): void
    {
        $idBarang = $get('id_barang');
        $qty = (int)($get('kuantitas_barang') ?? 1);

        if ($idBarang) {
            $harga = \App\Models\SparePart::find($idBarang)?->harga_barang ?? 0;
            $subtotal = $harga * $qty;
            $set('subtotal_barang', $subtotal);
        } else {
            $set('subtotal_barang', 0);
        }
    }

    private static function updateTotalFromRepeater(callable $set, callable $get, string $prefix = ''): void
    {
        $services = $get($prefix . 'transaksiServices') ?? [];
        $spareparts = $get($prefix . 'transaksiSpareParts') ?? [];

        // Pastikan selalu array
        $services = is_array($services) ? $services : [];
        $spareparts = is_array($spareparts) ? $spareparts : [];

        // Filter hanya array asosiatif yang valid
        $services = array_filter($services, fn($item) => is_array($item) && !empty($item['id_service']));
        $spareparts = array_filter($spareparts, fn($item) => is_array($item) && !empty($item['id_barang']));

        $serviceSum = 0;
        foreach ($services as $service) {
            $harga = \App\Models\Service::find($service['id_service'])?->biaya_service ?? 0;
            $qty = (int)($service['kuantitas_service'] ?? 1);
            $serviceSum += $harga * $qty;
        }

        $sparepartSum = 0;
        foreach ($spareparts as $sp) {
            $harga = \App\Models\SparePart::find($sp['id_barang'])?->harga_barang ?? 0;
            $qty = (int)($sp['kuantitas_barang'] ?? 1);
            $sparepartSum += $harga * $qty;
        }

        $set($prefix . 'total_pembayaran', $serviceSum + $sparepartSum);
    }

    private static function updateTotalPembayaran(callable $set, callable $get): void
    {
        self::updateTotalFromRepeater($set, $get);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pembayaran')
                    ->label('Payment ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('konsumen.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ?? '-'),
                    
                Tables\Columns\TextColumn::make('transaksiServices')
                    ->label('Services')
                    ->formatStateUsing(function ($record) {
                        $list = $record->transaksiServices;
                        if (blank($list)) return '-';
                        return $list->map(fn($t) => $t->service->nama_service ?? '-')->implode(', ');
                    }),

                Tables\Columns\TextColumn::make('transaksiSpareParts')
                    ->label('Spare Parts')
                    ->formatStateUsing(function ($record) {
                        $direct = $record->transaksiSpareParts ?? collect();
                        $fromBooking = $record->bookingService?->transaksiSpareParts ?? collect();
                        $merged = $direct->concat($fromBooking);

                        if ($merged->isEmpty()) return '-';

                        $grouped = $merged->groupBy('id_barang');

                        return $grouped->map(function ($items, $idBarang) {
                            $nama = $items->first()?->sparePart->nama_barang ?? '-';
                            $totalQty = $items->sum('kuantitas_barang');

                            return $totalQty > 1 ? "$nama (x$totalQty)" : $nama;
                        })->implode(', ');
                    }),

                Tables\Columns\TextColumn::make('total_pembayaran')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('qris')
                    ->label('QRIS')
                    ->size(40)
                    ->circular(),

                Tables\Columns\BadgeColumn::make('status_pembayaran')
                    ->label('Status')
                    ->colors([
                        'danger' => 'Belum Dibayar',
                        'success' => 'Sudah Dibayar',
                    ]),

                Tables\Columns\ImageColumn::make('bukti_pembayaran')
                    ->label('Payment Proof')
                    ->size(40)
                    ->tooltip('Click to view payment proof'),

                Tables\Columns\TextColumn::make('tanggal_pembayaran')
                    ->label('Payment Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Sudah Dibayar' => 'Sudah Dibayar',
                    ]),

                Tables\Filters\Filter::make('has_bukti_pembayaran')
                    ->label('Has Payment Proof')
                    ->query(fn($query) => $query->whereNotNull('bukti_pembayaran')),

                Tables\Filters\Filter::make('no_bukti_pembayaran')
                    ->label('No Payment Proof')
                    ->query(fn($query) => $query->whereNull('bukti_pembayaran')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve Payment')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn(Pembayaran $record) => $record->update(['status_pembayaran' => 'Sudah Dibayar']))
                    ->requiresConfirmation()
                    ->visible(fn(Pembayaran $record) => $record->status_pembayaran === 'Belum Dibayar'),

                Tables\Actions\Action::make('reject')
                    ->label('Reject Payment')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn(Pembayaran $record) => $record->update(['status_pembayaran' => 'Belum Dibayar']))
                    ->requiresConfirmation()
                    ->visible(fn(Pembayaran $record) => $record->status_pembayaran === 'Sudah Dibayar'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['status_pembayaran' => 'Sudah Dibayar'])))
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'konsumen.user',
                'transaksiServices.service',
                'transaksiSpareParts.sparePart',
                'bookingService.konsumen.user',
                'bookingService.platKendaraan',
                'bookingService.transaksiSpareParts.sparePart',
                'bookingService.transaksiServices.service',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}