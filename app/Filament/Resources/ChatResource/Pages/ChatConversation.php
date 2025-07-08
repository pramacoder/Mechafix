<?php

namespace App\Filament\Resources\ChatResource\Pages;

use App\Filament\Resources\ChatResource;
use App\Models\FilachatMessage;
use App\Models\FilachatConversation;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class ChatConversation extends Page
{
    protected static string $resource = ChatResource::class;
    protected static string $view = 'filament.pages.chat-conversation';

    public ?array $data = [
        'message' => '',
    ];
    public $conversation;

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }

    public function mount($conversation): void
    {
        $this->conversation = FilachatConversation::findOrFail($conversation);
        $this->data = ['message' => '']; // <- Ganti fillForm() dengan ini
        $this->markMessagesAsRead();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->placeholder('Type your message...')
                    ->required()
                    ->rows(3)
                    ->extraAttributes(['class' => 'resize-none']),
            ])
            ->statePath('data'); // <- Penting: gunakan statePath
    }

    public function sendMessage(): void
    {
        $data = $this->data;

        if (empty($data['message'])) {
            return;
        }

        FilachatMessage::create([
            'filachat_conversation_id' => $this->conversation->id,
            'message' => $data['message'],
            'senderable_type' => 'App\\Models\\User',
            'senderable_id' => auth()->id(),
            'receiverable_type' => $this->getCustomerType(),
            'receiverable_id' => $this->getCustomerId(),
        ]);

        $this->conversation->touch();

        // Reset form
        $this->data['message'] = '';

        // Refresh messages
        $this->dispatch('messages-updated');
    }

    public function getMessages()
    {
        return $this->conversation->messages()
            ->with(['senderable', 'receiverable'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getCustomerName(): string
    {
        if ($this->conversation->senderable_type === 'App\\Models\\Konsumen') {
            return $this->conversation->senderable?->user?->name ?? 'Unknown Customer';
        } elseif ($this->conversation->receiverable_type === 'App\\Models\\Konsumen') {
            return $this->conversation->receiverable?->user?->name ?? 'Unknown Customer';
        }

        return 'Unknown Customer';
    }

    private function markMessagesAsRead(): void
    {
        $this->conversation->messages()
            ->whereNull('last_read_at')
            ->where('senderable_type', 'App\\Models\\Konsumen')
            ->update(['last_read_at' => now()]);
    }

    private function getCustomerType(): string
    {
        return $this->conversation->senderable_type === 'App\\Models\\Konsumen'
            ? $this->conversation->senderable_type
            : $this->conversation->receiverable_type;
    }

    private function getCustomerId(): int
    {
        return $this->conversation->senderable_type === 'App\\Models\\Konsumen'
            ? $this->conversation->senderable_id
            : $this->conversation->receiverable_id;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Chats')
                ->url($this->getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}