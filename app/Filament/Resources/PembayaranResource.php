<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\BookingService;
use App\Models\PlatKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_booking_service')
                    ->label('Booking Service')
                    ->relationship('bookingService', 'id_booking_service')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "#{$record->id_booking_service} - {$record->konsumen->user->name}")
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $booking = BookingService::find($state);
                            if ($booking) {
                                $set('id_plat_kendaraan', $booking->id_plat_kendaraan);
                            }
                        }
                    }),

                Forms\Components\Select::make('id_plat_kendaraan')
                    ->label('Vehicle')
                    ->relationship('platKendaraan', 'nomor_plat_kendaraan')
                    ->required()
                    ->searchable()
                    ->disabled(),

                Forms\Components\Select::make('id_transaksi_service')
                    ->label('Service Transaction')
                    ->relationship('transaksiService', 'id_transaksi_service')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "Service #{$record->id_transaksi_service} - {$record->service->nama_service} (Rp " . number_format($record->subtotal_service, 0, ',', '.') . ")")
                    ->searchable()
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        static::calculateTotal($state, $get('id_transaksi_barang'), $set);
                    }),

                Forms\Components\Select::make('id_transaksi_barang')
                    ->label('Spare Part Transaction')
                    ->relationship('transaksiSparePart', 'id_transaksi_barang')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "Parts #{$record->id_transaksi_barang} - {$record->sparePart->nama_barang} (Rp " . number_format($record->subtotal_barang, 0, ',', '.') . ")")
                    ->searchable()
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        static::calculateTotal($get('id_transaksi_service'), $state, $set);
                    }),

                Forms\Components\DatePicker::make('tanggal_pembayaran')
                    ->label('Payment Date')
                    ->required()
                    ->default(today()),

                Forms\Components\TextInput::make('total_pembayaran')
                    ->label('Total Payment')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->minValue(0)
                    ->disabled(),

                Forms\Components\FileUpload::make('qris')
                    ->label('QRIS Code')
                    ->image()
                    ->directory('qris-codes')
                    ->visibility('public')
                    ->default('oli motor.webp')
                    ->helperText('QRIS code untuk pembayaran digital'),

                Forms\Components\FileUpload::make('bukti_pembayaran')
                    ->label('Payment Proof')
                    ->image()
                    ->directory('payment-proofs')
                    ->visibility('public')
                    ->nullable()
                    ->helperText('Upload bukti pembayaran dari customer'),

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

    protected static function calculateTotal($serviceId, $sparePartId, Forms\Set $set): void
    {
        $total = 0;

        if ($serviceId) {
            $service = \App\Models\TransaksiService::find($serviceId);
            if ($service) {
                $total += $service->subtotal_service;
            }
        }

        if ($sparePartId) {
            $sparePart = \App\Models\TransaksiSparePart::find($sparePartId);
            if ($sparePart) {
                $total += $sparePart->subtotal_barang;
            }
        }

        $set('total_pembayaran', $total);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pembayaran')
                    ->label('Payment ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bookingService.konsumen.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('platKendaraan.nomor_plat_kendaraan')
                    ->label('Vehicle')
                    ->searchable(),

                Tables\Columns\TextColumn::make('transaksiService.service.nama_service')
                    ->label('Service')
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->transaksiService?->service?->nama_service ?? 'No service';
                    }),

                Tables\Columns\TextColumn::make('transaksiSparePart.sparePart.nama_barang')
                    ->label('Spare Part')
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->transaksiSparePart?->sparePart?->nama_barang ?? 'No spare part';
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
                    ->query(fn ($query) => $query->whereNotNull('bukti_pembayaran')),

                Tables\Filters\Filter::make('no_bukti_pembayaran')
                    ->label('No Payment Proof')
                    ->query(fn ($query) => $query->whereNull('bukti_pembayaran')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve Payment')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Pembayaran $record) => $record->update(['status_pembayaran' => 'Sudah Dibayar']))
                    ->requiresConfirmation()
                    ->visible(fn (Pembayaran $record) => $record->status_pembayaran === 'Belum Dibayar'),

                Tables\Actions\Action::make('reject')
                    ->label('Reject Payment')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn (Pembayaran $record) => $record->update(['status_pembayaran' => 'Belum Dibayar']))
                    ->requiresConfirmation()
                    ->visible(fn (Pembayaran $record) => $record->status_pembayaran === 'Sudah Dibayar'),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status_pembayaran' => 'Sudah Dibayar'])))
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
