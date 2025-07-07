<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingServiceResource\Pages;
use App\Models\BookingService;
use App\Models\Konsumen;
use App\Models\PlatKendaraan;
use App\Models\Mekanik;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class BookingServiceResource extends Resource
{
    protected static ?string $model = BookingService::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Booking Management';
    protected static ?string $navigationLabel = 'Bookings';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_konsumen')
                    ->label('Customer')
                    ->options(function () {
                        return Konsumen::with('user')->get()->mapWithKeys(function ($konsumen) {
                            return [$konsumen->id_konsumen => $konsumen->user->name ?? 'Unknown User'];
                        });
                    })
                    ->afterStateUpdated(function (callable $set) {
                        $set('id_plat_kendaraan', null);
                    })
                    ->reactive()
                    ->nullable()
                    ->searchable()
                    ->placeholder('Select a customer'),
                Forms\Components\Select::make('id_plat_kendaraan')
                    ->label('Vehicle')
                    ->options(function (callable $get) {
                        $idKonsumen = $get('id_konsumen');
                        if (!$idKonsumen) return [];

                        return \App\Models\PlatKendaraan::where('id_konsumen', $idKonsumen)
                            ->get()
                            ->mapWithKeys(function ($plat) {
                                return [$plat->id_plat_kendaraan => $plat->nomor_plat_kendaraan .
                                    ($plat->tipe_kendaraan ? ' - ' . $plat->tipe_kendaraan : '')];
                            });
                    })
                    ->reactive()
                    ->searchable()
                    ->required()
                    ->placeholder('Select a vehicle'),
                Forms\Components\Select::make('id_mekanik')
                    ->label('Mechanic')
                    ->options(function () {
                        $today = Carbon::now()->dayOfWeekIso;

                        return \App\Models\Mekanik::with('user')
                            ->where('kuantitas_hari', '>=', $today)
                            ->get()
                            ->mapWithKeys(function ($mekanik) {
                                return [$mekanik->id_mekanik => $mekanik->user->name ?? 'Unknown User'];
                            });
                    })
                    ->nullable()
                    ->searchable()
                    ->placeholder('Select a mechanic')
                    ->helperText('Only available mechanics for today are listed.'),
                Forms\Components\DatePicker::make('tanggal_booking')
                    ->label('Tanggal Booking')
                    ->required()
                    ->minDate(now()->addDay())
                    ->maxDate(now()->addMonths(3))
                    ->disabledDates(function () {
                        return \App\Models\HariLibur::getHolidayDates(
                            now()->format('Y-m-d'),
                            now()->addMonths(3)->format('Y-m-d')
                        );
                    })
                    ->helperText('Tanggal yang diblokir adalah hari libur nasional')
                    ->reactive(),
                Forms\Components\TimePicker::make('estimasi_kedatangan')
                    ->label('Estimated Arrival')
                    ->default(Carbon::now('Asia/Makassar')->format('H:i'))
                    ->required(),
                Forms\Components\Select::make('status_booking')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal',
                    ])
                    ->required()
                    ->default('menunggu'),
                Forms\Components\Textarea::make('keluhan_konsumen')
                    ->label('Customer Complaint')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_booking_service')
                    ->label('Booking ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('konsumen.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('platKendaraan.nomor_plat_kendaraan')
                    ->label('Vehicle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_booking')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimasi_kedatangan')
                    ->label('Time')
                    ->time(),
                Tables\Columns\BadgeColumn::make('status_booking')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu',
                        'primary' => 'dikonfirmasi',
                        'success' => 'selesai',
                        'danger' => 'batal',
                    ]),
                Tables\Columns\TextColumn::make('mekanik.user.name')
                    ->label('Mechanic')
                    ->default('Not assigned'),
                Tables\Columns\TextColumn::make('keluhan_konsumen')
                    ->label('Complaint')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_booking')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal',
                    ]),
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('tanggal_booking', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('tanggal_booking', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                // Admin bisa assign mechanic jika booking dalam status 'menunggu'
                Tables\Actions\Action::make('assign_mechanic')
                    ->label('Assign Mechanic')
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('id_mekanik')
                            ->label('Select Mechanic')
                            ->options(function () {
                                return Mekanik::with('user')->get()->mapWithKeys(function ($mekanik) {
                                    return [$mekanik->id_mekanik => $mekanik->user->name ?? 'Unknown User'];
                                });
                            })
                            ->required()
                            ->searchable(),
                    ])
                    ->action(function (BookingService $record, array $data) {
                        $record->update([
                            'id_mekanik' => $data['id_mekanik'],
                            'status_booking' => 'dikonfirmasi'
                        ]);

                        $mekanik = Mekanik::find($data['id_mekanik']);
                        if ($mekanik && $mekanik->user) {
                            $mekanik->user->notify(new \App\Notifications\MekanikJobAssigned($record));
                        }

                        $record->loadMissing(['mekanik.user']);

                        if ($record->konsumen && $record->konsumen->user) {
                            $record->konsumen->user->notify(new \App\Notifications\MekanikAssignedToBooking($record));
                        }
                    })
                    ->visible(fn(BookingService $record) => $record->status_booking === 'menunggu'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingServices::route('/'),
            'create' => Pages\CreateBookingService::route('/create'),
            'edit' => Pages\EditBookingService::route('/{record}/edit'),
        ];
    }
}
