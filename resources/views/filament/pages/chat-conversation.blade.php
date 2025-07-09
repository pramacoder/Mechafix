<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Chat Header --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-semibold text-sm">
                        {{ substr($this->getCustomerName(), 0, 2) }}
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        {{ $this->getCustomerName() }}
                    </h3>
                    <p class="text-sm text-gray-500">Conversation #{{ $this->conversation->id }}</p>
                </div>
            </div>
        </div>

        {{-- Chat Messages --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <div class="p-4 h-96 overflow-y-auto space-y-4" id="messages-container">
                @foreach($this->getMessages() as $message)
                    <div class="flex w-full {{ $message->senderable_type === 'App\\Models\\User' ? 'justify-end' : 'justify-start' }}">
                        <div class="inline-block max-w-sm lg:max-w-md">
                            <div class="px-4 py-2 rounded-lg {{ $message->senderable_type === 'App\\Models\\User' 
                                ? 'bg-blue-600 text-white' 
                                : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                                
                                @if($message->message)
                                    <p class="text-sm break-words text-black">{{ $message->message }}</p>
                                @endif
                                
                                @if($message->attachments)
                                    <div class="mt-2 space-y-1">
                                        @foreach(json_decode($message->attachments, true) ?? [] as $attachment)
                                            <a href="{{ Storage::url($attachment) }}" 
                                               target="_blank" 
                                               class="block text-xs underline">
                                                📎 {{ basename($attachment) }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1 {{ $message->senderable_type === 'App\\Models\\User' ? 'text-right' : 'text-left' }}">
                                {{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Message Form --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
            <form wire:submit="sendMessage" class="space-y-4">
                {{ $this->form }}
                
                <div class="flex justify-end">
                    <x-filament::button type="submit" icon="heroicon-o-paper-airplane">
                        Send Message
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto scroll to bottom
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // Scroll on load
        document.addEventListener('DOMContentLoaded', scrollToBottom);

        // Scroll when new messages arrive
        Livewire.on('messages-updated', scrollToBottom);
    </script>
</x-filament-panels::page>