@php
    $admin = $admin ?? null;
    $adminUser = $adminUser ?? null;
    $mekanikUser = $mekanikUser ?? null;
    $messages = $messages ?? collect();
    $formAction = '#';
    if ($admin && optional($admin)->id_admin) {
        $formAction = route('filachat.admin.send', ['admin' => $admin->id_admin]);
    } elseif (isset($mekanik) && isset($mekanik->id_mekanik)) {
        $formAction = route('filachat.send', ['mekanik' => $mekanik->id_mekanik]);
    }
    // Ambil daftar mekanik untuk sidebar (jika belum ada, bisa diganti dengan query di controller)
    $daftarMekanik = \App\Models\Mekanik::with('user')->get();
@endphp

<x-layoutkonsumen>
<div class="flex flex-col md:flex-row gap-4 max-w-6xl mx-auto min-h-[70vh]">
    <!-- Sidebar Mekanik -->
    <aside class="w-full md:w-1/4 bg-white rounded-2xl shadow-md p-4 mb-4 md:mb-0">
        <h2 class="text-2xl font-bold text-orange-600 mb-4">Contact</h2>
        <ul class="space-y-2">
            @foreach($daftarMekanik as $mek)
                <li>
                    <a href="{{ route('filachat.show', ['mekanik' => $mek->id_mekanik]) }}"
                       class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 transition {{ isset($mekanik) && $mekanik->id_mekanik == $mek->id_mekanik ? 'bg-orange-100 font-bold' : '' }}">
                        <span class="w-8 h-8 rounded-full bg-orange-200 flex items-center justify-center text-lg font-bold text-orange-700">
                            {{ strtoupper(substr($mek->user->name ?? 'M', 0, 1)) }}
                        </span>
                        <span>{{ $mek->user->name ?? 'Mekanik' }}</span>
                    </a>
                </li>
            @endforeach
            <!-- Jika ingin admin juga, tambahkan di sini -->
            {{--
            <li>
                <a href="{{ route('filachat.admin.show', ['admin' => 1]) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 transition">
                    <span class="w-8 h-8 rounded-full bg-orange-200 flex items-center justify-center text-lg font-bold text-orange-700">A</span>
                    <span>Admin</span>
                </a>
            </li>
            --}}
        </ul>
    </aside>

    <!-- Chat Area -->
    <div class="flex-1 bg-white rounded-2xl shadow-lg flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex items-center gap-4 bg-gray-50">
            <div class="w-12 h-12 rounded-full bg-orange-200 flex items-center justify-center text-2xl font-bold text-orange-700">
                {{ strtoupper(substr(optional($adminUser)->name ?? optional($mekanikUser)->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <div class="font-bold text-lg text-gray-900">
                    {{ optional($adminUser)->name ?? optional($mekanikUser)->name ?? ($conversation->receiver->agentable->name ?? 'Pilih kontak') }}
                </div>
                <div class="text-sm text-gray-500">
                    @if($admin)
                        Admin
                    @elseif($mekanikUser)
                        Mekanik
                    @else
                        User
                    @endif
                </div>
            </div>
        </div>
        <!-- Chat Body -->
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4 bg-gray-50">
            @if($messages->count())
                @foreach($messages as $msg)
                    @php
                        $isKonsumen = $msg->senderable_type === get_class($conversation->sender) && $msg->senderable_id === $conversation->senderable_id;
                    @endphp
                    <div class="flex {{ $isKonsumen ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs md:max-w-md px-4 py-2 rounded-2xl {{ $isKonsumen ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-900' }} shadow">
                            <div class="text-sm">{{ $msg->message }}</div>
                            <div class="text-xs mt-1 text-right opacity-70">{{ $msg->created_at->format('H:i') }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-gray-400 mt-10">Belum ada pesan. Pilih kontak untuk mulai chat.</div>
            @endif
        </div>
        <!-- Chat Input -->
        @if($formAction !== '#')
        <form action="{{ $formAction }}" method="POST" class="flex items-center gap-2 border-t px-6 py-4 bg-white">
            @csrf
            <input type="text" name="message" placeholder="Type your message..." required class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-orange-500" autocomplete="off">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold transition">Send</button>
        </form>
        @else
        <div class="text-center text-gray-400 py-6">Pilih kontak untuk mulai chat.</div>
        @endif
    </div>
</div>
</x-layoutkonsumen>