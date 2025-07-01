<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Perbaikan untuk Plat Kendaraan: ') }} {{ $platkendaraan->nomor_plat_kendaraan ?? '' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Repair History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Perbaikan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dokumentasi</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Next Service</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mekanik</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($riwayats as $riwayat)
                                <tr>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($riwayat->tanggal_perbaikan)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ $riwayat->deskripsi_perbaikan }}</td>
                                    <td class="px-4 py-2">
                                        @if($riwayat->dokumentasi_perbaikan)
                                            <a href="{{ asset('storage/' . $riwayat->dokumentasi_perbaikan) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $riwayat->dokumentasi_perbaikan) }}" alt="Dokumentasi" class="h-16 rounded shadow">
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($riwayat->next_service)->format('d/m/Y') }}</td>
									<td class="px-4 py-2">{{ $riwayat->mekanik?->user?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat perbaikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>