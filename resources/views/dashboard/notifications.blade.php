<div class="mb-6">
    <button onclick="document.getElementById('notifPanel').classList.toggle('hidden')"
        class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
        🔔 Lihat Notifikasi @if (auth()->check())
            {{ auth()->user()->unreadNotifications->count() }}
        @endif
    </button>
    <div id="notifPanel" class="mt-3 bg-white border rounded-lg shadow-lg max-w-md w-full hidden">
        <div class="p-4">
            <h4 class="font-semibold text-lg mb-2">Notifikasi</h4>
            <ul class="divide-y divide-gray-200 max-h-80 overflow-y-auto" id="notifList">
                @php
                    $unreadNotifs = collect();
                    if (auth()->check()) {
                        $unreadNotifs = auth()->user()->unreadNotifications->take(10);
                    }
                @endphp
                @forelse($unreadNotifs as $notif)
                    <li class="py-2 flex justify-between items-center" id="notif-{{ $notif->id }}">
                        <div>
                            <span class="font-bold text-blue-800">
                                {{ $notif->data['message'] ?? $notif->type }}
                            </span>
                            <span class="text-xs text-gray-400 ml-2">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <button onclick="markNotifRead('{{ $notif->id }}')"
                            class="ml-4 px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Sudah Dibaca
                        </button>
                    </li>
                @empty
                    <li class="py-2 text-gray-400 text-center">Belum ada notifikasi baru.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script>
    function markNotifRead(id) {
        fetch('/notifications/mark-read/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                // Hilangkan notifikasi dari panel
                const el = document.getElementById('notif-' + id);
                if (el) el.remove();
                // Update badge jumlah notifikasi (opsional)
                let badge = document.querySelector('button.bg-blue-600');
                if (badge) {
                    let match = badge.textContent.match(/\((\d+)\)/);
                    if (match) {
                        let sisa = Math.max(0, parseInt(match[1]) - 1);
                        badge.innerHTML = `🔔 Lihat Notifikasi (${sisa})`;
                    }
                }
                // Jika sudah tidak ada notifikasi, tampilkan pesan kosong
                if (document.querySelectorAll('#notifList li').length === 0) {
                    document.getElementById('notifList').innerHTML =
                        '<li class="py-2 text-gray-400 text-center">Belum ada notifikasi baru.</li>';
                }
            }
        });
    }
</script>
