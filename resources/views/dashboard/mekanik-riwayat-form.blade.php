@php
    // Pastikan $booking sudah dilempar dari controller (BookingService yang baru saja selesai)
    $defaultNextService = \Carbon\Carbon::now()->addMonths(3)->format('Y-m-d');
@endphp

<div class="bg-white shadow-xl rounded-lg max-w-2xl mx-auto mt-10 p-8">
    <h2 class="text-2xl font-bold text-green-800 mb-2">Riwayat Perbaikan Selesai</h2>
    <p class="text-gray-600 mb-6">Silakan lengkapi detail riwayat perbaikan kendaraan berikut:</p>

    <div class="mb-4">
        <div class="text-sm text-gray-500 mb-1">Booking ID</div>
        <div class="font-semibold text-gray-900">#{{ $booking->id_booking_service }}</div>
    </div>
    <div class="mb-4">
        <div class="text-sm text-gray-500 mb-1">Kendaraan</div>
        <div class="font-semibold text-gray-900">
            {{ $booking->platKendaraan->nomor_plat_kendaraan ?? '-' }}
            ({{ $booking->platKendaraan->cc_kendaraan ?? '-' }} CC)
        </div>
    </div>
    <div class="mb-4">
        <div class="text-sm text-gray-500 mb-1">Customer</div>
        <div class="font-semibold text-gray-900">
            {{ $booking->konsumen->user->name ?? '-' }}
        </div>
    </div>
    <div class="mb-4">
        <div class="text-sm text-gray-500 mb-1">Tanggal Selesai</div>
        <div class="font-semibold text-gray-900">
            {{ now()->format('d M Y H:i') }}
        </div>
    </div>
    <div class="mb-4">
        <div class="text-sm text-gray-500 mb-1">Keluhan Konsumen</div>
        <div class="text-gray-800">{{ $booking->keluhan_konsumen }}</div>
    </div>

    <div class="mb-6">
        <div class="text-sm text-gray-500 mb-2">Layanan & Spare Part</div>
        <div class="bg-gray-50 rounded-lg p-4">
            @if ($booking->transaksiServices->count())
                <div class="mb-2">
                    <div class="font-semibold text-blue-700 mb-1">Layanan:</div>
                    <ul class="list-disc ml-5 text-sm text-gray-800">
                        @foreach ($booking->transaksiServices as $ts)
                            <li>
                                {{ $ts->service->nama_service ?? '-' }}
                                <span class="text-gray-500">({{ $ts->service->estimasi_waktu ?? '-' }} menit)</span>
                                <span class="text-blue-700 font-semibold ml-2">Rp
                                    {{ number_format($ts->subtotal_service, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($booking->transaksiSpareParts->count())
                <div>
                    <div class="font-semibold text-green-700 mb-1">Spare Part:</div>
                    <ul class="list-disc ml-5 text-sm text-gray-800">
                        @foreach ($booking->transaksiSpareParts as $ts)
                            <li>
                                {{ $ts->sparePart->nama_barang ?? '-' }}
                                @if ($ts->kuantitas_barang > 1)
                                    (x{{ $ts->kuantitas_barang }})
                                @endif
                                <span class="text-green-700 font-semibold ml-2">Rp
                                    {{ number_format($ts->subtotal_barang, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="border-t mt-3 pt-3 flex justify-between font-bold text-lg">
                <span>Total Biaya:</span>
                <span class="text-green-700">
                    Rp
                    {{ number_format($booking->transaksiServices->sum('subtotal_service') + $booking->transaksiSpareParts->sum('subtotal_barang'), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <form action="{{ route('mekanik.complete-job', $booking->id_booking_service) }}" method="POST"
        enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Perbaikan <span
                    class="text-red-500">*</span></label>
            <textarea name="deskripsi_perbaikan" rows="3" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('deskripsi_perbaikan') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dokumentasi Perbaikan (Opsional, Gambar)</label>
            <input type="file" name="dokumentasi_perbaikan" accept="image/*"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500 text-sm">
            <div class="text-xs text-gray-500 mt-1">Upload foto hasil perbaikan jika ada.</div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Service Berikutnya (Opsional)</label>
            <input type="date" name="next_service"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-green-500 focus:border-green-500 text-sm"
                value="{{ old('next_service', $defaultNextService) }}">
            <div class="text-xs text-gray-500 mt-1">Default 3 bulan dari hari ini, bisa diganti sesuai kebutuhan.</div>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('mekanik.dashboard') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</a>
            <button type="submit"
                class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-semibold shadow text-sm transition">
                Simpan Riwayat
            </button>
        </div>
    </form>
</div>