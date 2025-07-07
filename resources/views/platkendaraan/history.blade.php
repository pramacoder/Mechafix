<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black leading-tight">
            {{ __('History Perbaikan untuk Plat Kendaraan: ') }} {{ $platkendaraan->nomor_plat_kendaraan ?? '' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-black/10 shadow-xl rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-black mb-6">Repair History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-orange-500">
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Tanggal Perbaikan</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Dokumentasi</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Next Service</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Mekanik</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($riwayats as $riwayat)
                                <tr class="hover:bg-orange-50 transition">
                                    <td class="px-4 py-3 text-black">{{ \Carbon\Carbon::parse($riwayat->tanggal_perbaikan)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $riwayat->deskripsi_perbaikan }}</td>
                                    <td class="px-4 py-3">
                                        @if($riwayat->dokumentasi_perbaikan)
                                            <a href="{{ asset('storage/' . $riwayat->dokumentasi_perbaikan) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $riwayat->dokumentasi_perbaikan) }}" alt="Dokumentasi" class="h-16 rounded-lg border-2 border-orange-500 shadow">
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-black">{{ \Carbon\Carbon::parse($riwayat->next_service)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-black">{{ $riwayat->mekanik?->user?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 bg-orange-50 rounded-xl">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-16 w-16 text-orange-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                                            </svg>
                                            <span class="text-lg font-bold text-black mb-2">Belum ada riwayat perbaikan.</span>
                                            <span class="text-base text-gray-500">Kendaraan ini belum pernah melakukan perbaikan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>