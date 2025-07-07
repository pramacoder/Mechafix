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
        $spareparts = $get($prefix . 'transaksiSpareParts') ?? [];
        $spareparts = is_array($spareparts) ? $spareparts : [];
        $spareparts = array_filter($spareparts, fn($item) => is_array($item) && !empty($item['id_barang']));

        $sparepartSum = 0;
        foreach ($spareparts as $sp) {
            $harga = \App\Models\SparePart::find($sp['id_barang'])?->harga_barang ?? 0;
            $qty = (int)($sp['kuantitas_barang'] ?? 1);
            $sparepartSum += $harga * $qty;
        }

        $set($prefix . 'total_pembayaran', $sparepartSum);
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

                // Tampilkan booking status jika ada
                Tables\Columns\TextColumn::make('booking_status')
                    ->label('Booking Status')
                    ->getStateUsing(function ($record) {
                        $booking = \App\Models\BookingService::where('id_pembayaran', $record->id_pembayaran)->first();
                        return $booking?->status_booking ?? '-';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'selesai' => 'success',
                        'dikonfirmasi' => 'warning', 
                        'pending' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('transaksiSpareParts')
                    ->label('Spare Parts')
                    ->formatStateUsing(function ($record) {
                        $spareParts = $record->transaksiSpareParts ?? collect();

                        if ($spareParts->isEmpty()) return '-';

                        return $spareParts->map(function ($tp) {
                            $nama = $tp->sparePart->nama_barang ?? 'Unknown';
                            $qty = $tp->kuantitas_barang;
                            return $qty > 1 ? "{$nama} (x{$qty})" : $nama;
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
                    ->label('Payment Status')
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Sudah Dibayar' => 'Sudah Dibayar',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // Action untuk upload payment proof (khusus booking selesai & belum dibayar)
                Tables\Actions\Action::make('upload_payment_proof')
                    ->label('Upload Payment Proof')
                    ->icon('heroicon-o-camera')
                    ->color('warning')
                    ->form([
                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->label('Payment Proof')
                            ->image()
                            ->directory('payment-proofs')
                            ->visibility('public')
                            ->required()
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),
                        
                        Forms\Components\FileUpload::make('qris')
                            ->label('QRIS Code (Optional)')
                            ->image()
                            ->directory('qris-codes')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp']),
                    ])
                    ->action(function (Pembayaran $record, array $data) {
                        $record->update([
                            'bukti_pembayaran' => $data['bukti_pembayaran'],
                            'qris' => $data['qris'] ?? $record->qris,
                            'status_pembayaran' => 'Sudah Dibayar', // Otomatis ubah status
                        ]);
                        
                        // Kirim notifikasi sukses
                        \Filament\Notifications\Notification::make()
                            ->title('Payment proof uploaded successfully!')
                            ->body('Payment status has been updated to "Sudah Dibayar"')
                            ->success()
                            ->send();
                    })
                    ->visible(function (Pembayaran $record) {
                        // Tampilkan hanya jika:
                        // 1. Status pembayaran = Belum Dibayar
                        // 2. Booking status = selesai
                        // 3. Belum ada bukti pembayaran
                        $booking = \App\Models\BookingService::where('id_pembayaran', $record->id_pembayaran)->first();
                        
                        return $record->status_pembayaran === 'Belum Dibayar' && 
                               $booking?->status_booking === 'selesai' &&
                               empty($record->bukti_pembayaran);
                    }),

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
                'transaksiSpareParts.sparePart',
                'bookingService',
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