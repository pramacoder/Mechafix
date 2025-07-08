<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Models\User;
use App\Models\Konsumen;
use App\Models\FilachatConversation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatResource extends Resource
{
    protected static ?string $model = FilachatConversation::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Customer Chats';
    protected static ?string $modelLabel = 'Chat';
    protected static ?string $pluralModelLabel = 'Customer Chats';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->placeholder('Type your message...')
                    ->required()
                    ->rows(3),

                Forms\Components\FileUpload::make('attachments')
                    ->label('Attachments')
                    ->multiple()
                    ->directory('chat-attachments')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(5120), // 5MB
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('customer_avatar')
                    ->label('')
                    ->getStateUsing(function ($record) {
                        $customerName = self::getCustomerName($record);
                        return 'https://ui-avatars.com/api/?name=' . urlencode($customerName) . '&color=7F9CF5&background=EBF4FF';
                    })
                    ->circular()
                    ->size(50),

                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('customer_name')
                        ->label('Customer')
                        ->getStateUsing(fn($record) => self::getCustomerName($record))
                        ->weight('bold')
                        ->size('lg'),

                    Tables\Columns\TextColumn::make('last_message')
                        ->label('')
                        ->getStateUsing(function ($record) {
                            $lastMessage = $record->messages()->latest()->first();
                            return $lastMessage ? \Str::limit($lastMessage->message, 60) : 'No messages yet';
                        })
                        ->color('gray')
                        ->size('sm'),

                    Tables\Columns\TextColumn::make('conversation_info')
                        ->label('')
                        ->getStateUsing(function ($record) {
                            $totalMessages = $record->messages()->count();
                            $lastActivity = $record->messages()->latest()->first();
                            $lastTime = $lastActivity ? $lastActivity->created_at->diffForHumans() : 'No activity';

                            return "{$totalMessages} messages • {$lastTime}";
                        })
                        ->color('gray')
                        ->size('xs'),
                ])->space(1),

                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\BadgeColumn::make('unread_count')
                        ->label('')
                        ->getStateUsing(function ($record) {
                            $user = auth()->user();
                            $count = $record->messages()
                                ->whereNull('last_read_at')
                                ->where('senderable_type', 'App\\Models\\Konsumen')
                                ->count();
                            return $count > 0 ? $count : null;
                        })
                        ->color('danger')
                        ->size('sm'),

                    Tables\Columns\IconColumn::make('online_status')
                        ->label('')
                        ->getStateUsing(fn() => true)
                        ->icon('heroicon-o-signal')
                        ->color('success')
                        ->size('sm'),
                ])->space(1),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->label('Unread Messages')
                    ->query(function ($query) {
                        return $query->whereHas('messages', function ($q) {
                            $q->whereNull('last_read_at')
                                ->where('senderable_type', 'App\\Models\\Konsumen');
                        });
                    }),

                Tables\Filters\Filter::make('recent')
                    ->label('Recent (Today)')
                    ->query(function ($query) {
                        return $query->whereHas('messages', function ($q) {
                            $q->whereDate('created_at', today());
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('open_chat')
                    ->label('Open Chat')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('primary')
                    ->button()
                    ->action(function ($record) {
                        return redirect()->to(static::getUrl('conversation', ['conversation' => $record->id]));
                    }), 

                Tables\Actions\Action::make('mark_all_read')
                    ->label('Mark All Read')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->action(function ($record) {
                        $record->messages()
                            ->whereNull('last_read_at')
                            ->update(['last_read_at' => now()]);
                    })
                    ->visible(function ($record) {
                        return $record->messages()->whereNull('last_read_at')->exists();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_all_read')
                        ->label('Mark All as Read')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->messages()
                                    ->whereNull('last_read_at')
                                    ->update(['last_read_at' => now()]);
                            }
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped(false)
            ->paginated([10, 25, 50]);
    }

    private static function getCustomerName($record): string
    {
        // Check if customer is sender or receiver
        if ($record->senderable_type === 'App\\Models\\Konsumen') {
            return $record->senderable?->user?->name ?? 'Unknown Customer';
        } elseif ($record->receiverable_type === 'App\\Models\\Konsumen') {
            return $record->receiverable?->user?->name ?? 'Unknown Customer';
        }

        return 'Unknown Customer';
    }

    public static function getEloquentQuery(): Builder
    {
        // $user = auth()->user();

        // return parent::getEloquentQuery()
        //     ->where(function ($query) use ($user) {
        //         if ($user->role === 'admin') {
        //             // Admin dapat melihat semua conversation
        //             return $query;
        //         } else {
        //             // Mekanik hanya melihat conversation yang melibatkan mereka
        //             $query->where(function ($q) use ($user) {
        //                 $q->where('senderable_type', 'App\\Models\\User')
        //                   ->where('senderable_id', $user->id)
        //                   ->orWhere('receiverable_type', 'App\\Models\\User')
        //                   ->where('receiverable_id', $user->id);
        //             });
        //         }

        //         return $query;
        //     })
        //     ->orderBy('updated_at', 'desc');
        return parent::getEloquentQuery()->orderBy('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChats::route('/'),
            'conversation' => Pages\ChatConversation::route('/conversation/{conversation}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        $query = static::getEloquentQuery()
            ->whereHas('messages', function ($q) {
                $q->whereNull('last_read_at')
                    ->where('senderable_type', 'App\\Models\\Konsumen');
            });

        $count = $query->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : 'primary';
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView($record): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
