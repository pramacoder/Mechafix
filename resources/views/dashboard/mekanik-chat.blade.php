<x-layoutkonsumen>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 lg:p-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">💬 Chat with {{ $conversation->sender->agentable->name ?? 'Customer' }}</h3>
                    <div class="max-h-64 overflow-y-auto mb-4 border rounded p-3 bg-gray-50">
                        @php
                            $mekanikAgent = \App\Models\FilachatAgent::where([
                                'agentable_id' => Auth::id(),
                                'agentable_type' => get_class(Auth::user()),
                                'role' => 'mekanik',
                            ])->first();
                        @endphp
                        @if($messages->count())
                            @foreach($messages as $msg)
                                <div class="mb-2 flex {{ $mekanikAgent && $msg->senderable_id == $mekanikAgent->id ? 'justify-end' : 'justify-start' }}">
                                    <div class="inline-block px-3 py-2 rounded-lg {{ $mekanikAgent && $msg->senderable_id == $mekanikAgent->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                        <div class="text-xs font-semibold mb-1">
                                            {{ $msg->sender->agentable->name ?? 'Unknown' }}
                                            <span class="text-[10px] text-gray-400 ml-1">{{ $msg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div>{{ $msg->message }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-gray-500 text-sm">No messages yet. Start the conversation!</div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('filachat.mekanik.reply', $conversation->id) }}" class="flex space-x-2">
                        @csrf
                        <input type="text" name="message" class="flex-1 border rounded px-2 py-1" placeholder="Type your message..." required>
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Send</button>
                    </form>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 mt-4">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-layoutkonsumen>
