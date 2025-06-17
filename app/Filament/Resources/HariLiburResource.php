<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HariLiburResource\Pages;
use App\Models\HariLibur;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HariLiburResource extends Resource
{
    protected static ?string $model = HariLibur::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Hari Libur';
    protected static ?string $pluralModelLabel = 'Hari Libur';
    protected static ?string $modelLabel = 'Hari Libur';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Hari Libur')
                    ->schema([
                        Forms\Components\TextInput::make('nama_hari_libur')
                            ->label('Nama Hari Libur')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Hari Raya Idul Fitri')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('tanggal_mulai')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ($state && !$get('tanggal_berakhir')) {
                                            $set('tanggal_berakhir', $state);
                                        }
                                    }),

                                Forms\Components\DatePicker::make('tanggal_berakhir')
                                    ->label('Tanggal Berakhir')
                                    ->required()
                                    ->afterOrEqual('tanggal_mulai')
                                    ->helperText('Untuk hari libur 1 hari, isi dengan tanggal yang sama'),
                            ]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Deskripsi atau informasi tambahan tentang hari libur')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('id_admin')
                            ->default(1)
                            ->dehydrateStateUsing(function ($state) {
                                if (Auth::guard('admin')->check()) {
                                    return Auth::guard('admin')->user()->id_admin;
                                }
                                return 1;
                            }),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_hari_libur')
                    ->label('Nama Hari Libur')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('tanggal_berakhir')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->sortable()
                    ->color('danger'),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->getStateUsing(function ($record) {
                        $days = $record->tanggal_mulai->diffInDays($record->tanggal_berakhir) + 1;
                        return $days . ' hari';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, '1 hari') => 'success',
                        str_contains($state, '2 hari') || str_contains($state, '3 hari') => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('days_status')
                    ->label('Timeline')
                    ->getStateUsing(function ($record) {
                        $now = now('Asia/Singapore')->startOfDay();
                        $start = $record->tanggal_mulai->setTimezone('Asia/Singapore')->startOfDay();
                        $end = $record->tanggal_berakhir->setTimezone('Asia/Singapore')->startOfDay();
                        
                        if ($now->lt($start)) {
                            // Hari libur belum dimulai
                            $days = $now->diffInDays($start);
                            return $days . ' hari lagi';
                        } elseif ($now->between($start, $end)) {
                            // Hari libur sedang berlangsung
                            return 'Sedang berlangsung';
                        } else {
                            // Hari libur sudah lewat
                            $days = $end->diffInDays($now);
                            return 'Sudah ' . $days . ' hari';
                        }
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'Sedang berlangsung') => 'success',
                        str_contains($state, 'hari lagi') && intval($state) <= 7 => 'warning',
                        str_contains($state, 'hari lagi') => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('admin.nama_admin')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active_holidays')
                    ->label('Hari Libur Aktif')
                    ->query(fn ($query) => $query->where('tanggal_berakhir', '>=', now('Asia/Singapore')->format('Y-m-d'))),

                Tables\Filters\Filter::make('upcoming_holidays')
                    ->label('Mendatang')
                    ->query(fn ($query) => $query->where('tanggal_mulai', '>=', now('Asia/Singapore')->format('Y-m-d'))),

                Tables\Filters\Filter::make('ongoing_holidays')
                    ->label('Sedang Berlangsung')
                    ->query(fn ($query) => $query->where('tanggal_mulai', '<=', now('Asia/Singapore')->format('Y-m-d'))
                                                 ->where('tanggal_berakhir', '>=', now('Asia/Singapore')->format('Y-m-d'))),

                Tables\Filters\Filter::make('current_month')
                    ->label('Bulan Ini')
                    ->query(fn ($query) => $query->whereMonth('tanggal_mulai', now('Asia/Singapore')->month)
                                                 ->whereYear('tanggal_mulai', now('Asia/Singapore')->year)),

                Tables\Filters\Filter::make('current_year')
                    ->label('Tahun Ini')
                    ->query(fn ($query) => $query->whereYear('tanggal_mulai', now('Asia/Singapore')->year)),

                Tables\Filters\SelectFilter::make('year')
                    ->label('Tahun')
                    ->options(function () {
                        $years = [];
                        for ($i = 2024; $i <= 2030; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->query(function ($query, array $data) {
                        if ($data['value']) {
                            $query->whereYear('tanggal_mulai', $data['value']);
                        }
                    }),

                Tables\Filters\SelectFilter::make('month')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value']) {
                            $query->whereMonth('tanggal_mulai', $data['value']);
                        }
                    }),

                Tables\Filters\SelectFilter::make('duration')
                    ->label('Durasi')
                    ->options([
                        '1' => '1 Hari',
                        '2-3' => '2-3 Hari',
                        '4-7' => '4-7 Hari',
                        '7+' => 'Lebih dari 7 Hari'
                    ])
                    ->query(function ($query, array $data) {
                        if (!$data['value']) return $query;
                        
                        return match($data['value']) {
                            '1' => $query->whereRaw('DATEDIFF(tanggal_berakhir, tanggal_mulai) = 0'),
                            '2-3' => $query->whereRaw('DATEDIFF(tanggal_berakhir, tanggal_mulai) BETWEEN 1 AND 2'),
                            '4-7' => $query->whereRaw('DATEDIFF(tanggal_berakhir, tanggal_mulai) BETWEEN 3 AND 6'),
                            '7+' => $query->whereRaw('DATEDIFF(tanggal_berakhir, tanggal_mulai) >= 7'),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Hari Libur')
                    ->modalContent(function ($record) {
                        $days = $record->tanggal_mulai->diffInDays($record->tanggal_berakhir) + 1;
                        $isActive = $record->tanggal_berakhir->gte(now('Asia/Singapore')->startOfDay());
                        
                        return view('filament.resources.hari-libur.view', [
                            'record' => $record,
                            'days' => $days,
                            'isActive' => $isActive
                        ]);
                    }),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplikasi')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('target_year')
                            ->label('Duplikasi ke Tahun')
                            ->options(function () {
                                $years = [];
                                for ($i = 2025; $i <= 2030; $i++) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            })
                            ->required()
                            ->helperText('Hari libur akan diduplikasi dengan tanggal yang sama di tahun target'),
                    ])
                    ->action(function (HariLibur $record, array $data) {
                        $targetYear = $data['target_year'];
                        $currentYear = $record->tanggal_mulai->year;
                        $yearDiff = $targetYear - $currentYear;

                        $newStart = $record->tanggal_mulai->copy()->addYears($yearDiff);
                        $newEnd = $record->tanggal_berakhir->copy()->addYears($yearDiff);

                        HariLibur::create([
                            'nama_hari_libur' => $record->nama_hari_libur,
                            'tanggal_mulai' => $newStart,
                            'tanggal_berakhir' => $newEnd,
                            'keterangan' => $record->keterangan . ' (duplikasi dari tahun ' . $currentYear . ')',
                            'id_admin' => Auth::guard('admin')->check() ? Auth::guard('admin')->user()->id_admin : 1,
                        ]);
                    })
                    ->successNotificationTitle('Hari libur berhasil diduplikasi')
                    ->requiresConfirmation()
                    ->modalHeading('Duplikasi Hari Libur')
                    ->modalDescription('Apakah Anda yakin ingin menduplikasi hari libur ini?'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('bulkDuplicate')
                        ->label('Duplikasi Massal')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('target_year')
                                ->label('Duplikasi ke Tahun')
                                ->options(function () {
                                    $years = [];
                                    for ($i = 2025; $i <= 2030; $i++) {
                                        $years[$i] = $i;
                                    }
                                    return $years;
                                })
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $targetYear = $data['target_year'];
                            
                            foreach ($records as $record) {
                                $currentYear = $record->tanggal_mulai->year;
                                $yearDiff = $targetYear - $currentYear;

                                $newStart = $record->tanggal_mulai->copy()->addYears($yearDiff);
                                $newEnd = $record->tanggal_berakhir->copy()->addYears($yearDiff);

                                HariLibur::create([
                                    'nama_hari_libur' => $record->nama_hari_libur,
                                    'tanggal_mulai' => $newStart,
                                    'tanggal_berakhir' => $newEnd,
                                    'keterangan' => $record->keterangan . ' (duplikasi massal)',
                                    'id_admin' => Auth::guard('admin')->check() ? Auth::guard('admin')->user()->id_admin : 1,
                                ]);
                            }
                        })
                        ->successNotificationTitle(fn ($records) => count($records) . ' hari libur berhasil diduplikasi')
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('exportToCalendar')
                        ->label('Export ke Kalender')
                        ->icon('heroicon-o-calendar-days')
                        ->color('success')
                        ->action(function ($records) {
                            // Export functionality can be implemented here
                        }),
                ]),
            ])
            ->defaultSort('tanggal_mulai', 'asc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHariLiburs::route('/'),
            'create' => Pages\CreateHariLibur::route('/create'),
            'edit' => Pages\EditHariLibur::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $now = now('Asia/Singapore');
        $upcoming = static::getModel()::where('tanggal_mulai', '>=', $now->format('Y-m-d'))
                                      ->where('tanggal_mulai', '<=', $now->copy()->addDays(30)->format('Y-m-d'))
                                      ->count();
        return $upcoming > 0 ? $upcoming : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }
}