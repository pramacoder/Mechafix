<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Models\User;
use App\Models\Konsumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatResource extends Resource
{
    // Gunakan model FilachatMessage yang sebenarnya
    protected static ?string $model = \App\Models\FilachatMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Chat Messages';
    protected static ?string $modelLabel = 'Chat Message';
    protected static ?string $pluralModelLabel = 'Chat Messages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Message Details')
                    ->schema([
                        Forms\Components\Select::make('filachat_conversation_id')
                            ->label('Conversation')
                            ->options(function () {
                                return \App\Models\FilachatConversation::with(['senderable', 'receiverable'])
                                    ->get()
                                    ->mapWithKeys(function ($conv) {
                                        $senderName = self::getAgentName($conv->senderable_type, $conv->senderable_id);
                                        $receiverName = self::getAgentName($conv->receiverable_type, $conv->receiverable_id);
                                        return [$conv->id => "#{$conv->id} - {$senderName} ↔ {$receiverName}"];
                                    });
                            })
                            ->searchable()
                            ->required(),

                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(3),

                        Forms\Components\Select::make('senderable_type')
                            ->label('Sender Type')
                            ->options([
                                'App\\Models\\User' => 'Admin/Staff',
                                'App\\Models\\Konsumen' => 'Customer',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('senderable_id', null)),

                        Forms\Components\Select::make('senderable_id')
                            ->label('Sender')
                            ->options(function (callable $get) {
                                $type = $get('senderable_type');
                                if ($type === 'App\\Models\\User') {
                                    return User::where('role', '!=', 'konsumen')
                                        ->get()
                                        ->mapWithKeys(fn($u) => [$u->id => $u->name . " ({$u->role})"]);
                                } elseif ($type === 'App\\Models\\Konsumen') {
                                    return Konsumen::with('user')
                                        ->get()
                                        ->mapWithKeys(fn($k) => [$k->id_konsumen => $k->user->name ?? 'Unknown']);
                                }
                                return [];
                            })
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('receiverable_type')
                            ->label('Receiver Type')
                            ->options([
                                'App\\Models\\User' => 'Admin/Staff',
                                'App\\Models\\Konsumen' => 'Customer',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('receiverable_id', null)),

                        Forms\Components\Select::make('receiverable_id')
                            ->label('Receiver')
                            ->options(function (callable $get) {
                                $type = $get('receiverable_type');
                                if ($type === 'App\\Models\\User') {
                                    return User::where('role', '!=', 'konsumen')
                                        ->get()
                                        ->mapWithKeys(fn($u) => [$u->id => $u->name . " ({$u->role})"]);
                                } elseif ($type === 'App\\Models\\Konsumen') {
                                    return Konsumen::with('user')
                                        ->get()
                                        ->mapWithKeys(fn($k) => [$k->id_konsumen => $k->user->name ?? 'Unknown']);
                                }
                                return [];
                            })
                            ->searchable()
                            ->required(),

                        Forms\Components\FileUpload::make('attachments')
                            ->label('Attachments')
                            ->multiple()
                            ->directory('chat-attachments')
                            ->visibility('public'),

                        Forms\Components\Toggle::make('is_starred')
                            ->label('Starred Message'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('filachat_conversation_id')
                    ->label('Conversation')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sender_info')
                    ->label('Sender')
                    ->getStateUsing(function ($record) {
                        return self::getAgentName($record->senderable_type, $record->senderable_id);
                    })
                    ->badge()
                    ->color(fn($record) => $record->senderable_type === 'App\\Models\\User' ? 'info' : 'warning'),

                Tables\Columns\TextColumn::make('receiver_info')
                    ->label('Receiver')
                    ->getStateUsing(function ($record) {
                        return self::getAgentName($record->receiverable_type, $record->receiverable_id);
                    })
                    ->badge()
                    ->color(fn($record) => $record->receiverable_type === 'App\\Models\\User' ? 'info' : 'warning'),

                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->message;
                    }),

                Tables\Columns\IconColumn::make('is_starred')
                    ->label('Starred')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('attachments')
                    ->label('Attachments')
                    ->getStateUsing(function ($record) {
                        $attachments = is_string($record->attachments) 
                            ? json_decode($record->attachments, true) 
                            : $record->attachments;
                        
                        return $attachments ? count($attachments) . ' file(s)' : 'None';
                    })
                    ->badge()
                    ->color(fn($state) => $state !== 'None' ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('last_read_at')
                    ->label('Read At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('senderable_type')
                    ->label('Sender Type')
                    ->options([
                        'App\\Models\\User' => 'Admin/Staff',
                        'App\\Models\\Konsumen' => 'Customer',
                    ]),

                Tables\Filters\SelectFilter::make('receiverable_type')
                    ->label('Receiver Type')
                    ->options([
                        'App\\Models\\User' => 'Admin/Staff',
                        'App\\Models\\Konsumen' => 'Customer',
                    ]),

                Tables\Filters\TernaryFilter::make('is_starred')
                    ->label('Starred Messages'),

                Tables\Filters\Filter::make('unread')
                    ->label('Unread Messages')
                    ->query(fn($query) => $query->whereNull('last_read_at')),

                Tables\Filters\Filter::make('today')
                    ->label('Today\'s Messages')
                    ->query(fn($query) => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(fn($record) => $record->update(['last_read_at' => now()]))
                    ->visible(fn($record) => is_null($record->last_read_at)),

                Tables\Actions\Action::make('star_message')
                    ->label('Star')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->action(fn($record) => $record->update(['is_starred' => !$record->is_starred]))
                    ->visible(fn($record) => !$record->is_starred),

                Tables\Actions\Action::make('unstar_message')
                    ->label('Unstar')
                    ->icon('heroicon-s-star')
                    ->color('gray')
                    ->action(fn($record) => $record->update(['is_starred' => !$record->is_starred]))
                    ->visible(fn($record) => $record->is_starred),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('mark_as_read')
                        ->label('Mark Selected as Read')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['last_read_at' => now()])))
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('star_messages')
                        ->label('Star Selected')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['is_starred' => true])))
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    private static function getAgentName($type, $id): string
    {
        if ($type === 'App\\Models\\User') {
            $user = User::find($id);
            return $user ? $user->name . " ({$user->role})" : 'Unknown User';
        } elseif ($type === 'App\\Models\\Konsumen') {
            $konsumen = Konsumen::with('user')->find($id);
            return $konsumen?->user?->name ?? 'Unknown Customer';
        }
        return 'Unknown';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'create' => Pages\CreateChat::route('/create'),
            'edit' => Pages\EditChat::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('last_read_at')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : 'primary';
    }
}