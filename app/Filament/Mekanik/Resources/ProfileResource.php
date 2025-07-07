<?php

namespace App\Filament\Mekanik\Resources;

use App\Filament\Mekanik\Resources\ProfileResource\Pages;
use App\Filament\Mekanik\Resources\ProfileResource\RelationManagers;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;
    protected static ?string $label = 'Profile';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $slug = 'profiles';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(['md' => 2, 'xl' => 3])
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('photo')
                        ->image()
                        ->required()
                        ->disk('public')
                        ->directory('profile-photos')
                        ->visibility('public')
                        ->openable()
                        ->downloadable()
                        ->label('Foto Profil')
                        ->preserveFilenames()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file
                                ->getClientOriginalName())
                                ->prepend(now()->timestamp . '-');
                        }),
                ])->columnSpan(1),
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Lengkap')
                        ->placeholder('Masukkan Nama Lengkap'),
                    Forms\Components\TextInput::make('username')
                        ->required()
                        ->maxLength(50)
                        ->label('Nama Pengguna')
                        ->placeholder('Masukkan Nama Pengguna'),
                    Forms\Components\Select::make('role')
                        ->required()
                        ->label('Peran')
                        ->options([
                            'Admin' => 'Admin',
                            'Inti' => 'Inti',
                            'Komisi 1' => 'Komisi 1',
                            'Komisi 2' => 'Komisi 2',
                            'Komisi 3' => 'Komisi 3',
                            'Komisi 4' => 'Komisi 4',
                            'Komisi 5' => 'Komisi 5',
                        ])
                        ->visibleOn(['create', 'edit']),
                    Forms\Components\Select::make('isPimpinan')
                        ->required()
                        ->label('Status')
                        ->options([
                            true => 'Pimpinan',
                            false => 'Non Pimpinan',
                        ])
                        ->visibleOn(['create', 'edit']),
                    Forms\Components\TextInput::make('specifiedRole')
                        ->required()
                        ->maxLength(50)
                        ->label('Jabatan')
                        ->placeholder('Masukkan Jabatan Pengguna'),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Masukkan Email Pengguna'),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->maxLength(255)
                        ->hiddenOn(['view', 'edit'])
                        ->placeholder('Masukkan Kata Sandi Pengguna'),
                ])->columnSpan(['md' => 1, 'xl' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Pengguna'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->label('Peran')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('isPimpinan')
                    ->boolean()
                    ->label('Pimpinan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('specifiedRole')
                    ->searchable()
                    ->sortable()
                    ->label('Jabatan')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('prodi.name')
                    ->searchable()
                    ->sortable()
                    ->label('Program Studi')
                    ->default('Belum ditambahkan')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Jabatan')
                    ->options([
                        'Admin' => 'Admin',
                        'Inti' => 'Inti',
                        'Komisi 1' => 'Komisi 1',
                        'Komisi 2' => 'Komisi 2',
                        'Komisi 3' => 'Komisi 3',
                        'Komisi 4' => 'Komisi 4',
                        'Komisi 5' => 'Komisi 5',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    // Tables\Actions\DeleteAction::make()
                    //     ->successRedirectUrl(route('filament.admin.resources.daftar-pengguna.index')),
                    // Tables\Actions\RestoreAction::make()
                    //     ->successRedirectUrl(route('filament.admin.resources.daftar-pengguna.index')),
                    // Tables\Actions\ForceDeleteAction::make()
                    //     ->successRedirectUrl(route('filament.admin.resources.daftar-pengguna.index')),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\RestoreBulkAction::make()
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
}
