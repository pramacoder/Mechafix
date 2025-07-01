<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    @if ($userVehicles->count() > 0)
                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Pilih Kendaraan -->
                                <div class="md:col-span-2">
                                    <x-label for="id_plat_kendaraan" value="{{ __('Pilih Kendaraan') }}" />
                                    <select id="id_plat_kendaraan" name="id_plat_kendaraan"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="">-- Select Your Vehicle --</option>
                                        @foreach ($userVehicles as $vehicle)
                                            <option value="{{ $vehicle->id_plat_kendaraan }}"
                                                {{ old('id_plat_kendaraan') == $vehicle->id_plat_kendaraan ? 'selected' : '' }}>
                                                {{ $vehicle->nomor_plat_kendaraan }} - {{ $vehicle->cc_kendaraan }} CC
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_plat_kendaraan')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Booking -->
                                <div>
                                    <x-label for="tanggal_booking" value="{{ __('Tanggal Booking') }}" />
                                    <x-input id="tanggal_booking" class="block mt-1 w-full" type="date"
                                        name="tanggal_booking" :value="old('tanggal_booking')"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        max="{{ date('Y-m-d', strtotime('+3 months')) }}" required />
                                    @error('tanggal_booking')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        <span class="text-red-500">⚠️</span> Jika tidak bisa memilih tanggal maka
                                        bengkel tutup.
                                    </p>
                                </div>

                                <!-- Estimasi Kedatangan -->
                                <div>
                                    <x-label for="estimasi_kedatangan" value="{{ __('Jam Kedatangan') }}" />
                                    <x-input id="estimasi_kedatangan" class="block mt-1 w-full" type="time"
                                        name="estimasi_kedatangan" :value="old('estimasi_kedatangan')" required />
                                    @error('estimasi_kedatangan')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Keluhan Konsumen -->
                                <div class="md:col-span-2">
                                    <x-label for="keluhan_konsumen" value="{{ __('Masalah Kendaraan') }}" />
                                    <textarea id="keluhan_konsumen" name="keluhan_konsumen" rows="4"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        placeholder="Tuliskan permasalahan kendaraanmu..." required>{{ old('keluhan_konsumen') }}</textarea>
                                    @error('keluhan_konsumen')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 space-x-2">
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Cancel
                                </a>
                                <x-button class="ml-3">
                                    {{ __('Submit Booking') }}
                                </x-button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ditemukan kendaraan</h3>
                            <p class="mt-1 text-sm text-gray-500">Kamu harus menambah kendaraan sebelum booking service.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('platkendaraan.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Add Vehicle First
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('tanggal_booking');

            // Ambil semua data hari libur dari sistem (database Filament)
            const holidayDates = @json(\App\Models\HariLibur::getHolidayDates(now()->format('Y-m-d'), now()->addMonths(3)->format('Y-m-d')));
            const holidayDetails = @json(\App\Models\HariLibur::getHolidayDetails(now()->format('Y-m-d'), now()->addMonths(3)->format('Y-m-d')));

            function isHoliday(date) {
                return holidayDates.includes(date);
            }

            function getHolidayName(date) {
                const holiday = holidayDetails.find(h =>
                    h.dates && h.dates.includes(date)
                );
                return holiday ? holiday.nama : 'Hari Libur';
            }

            dateInput.addEventListener('change', function() {
                const selectedDate = this.value;
                if (selectedDate && isHoliday(selectedDate)) {
                    const holidayName = getHolidayName(selectedDate);

                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Libur!',
                        html: `Tanggal yang Anda pilih adalah hari libur:<br><b>"${holidayName}"</b><br>Silakan pilih tanggal lain.`,
                        confirmButtonText: 'OK'
                    });

                    this.value = '';
                    this.focus();
                    this.classList.add('border-red-500', 'bg-red-50');
                    setTimeout(() => {
                        this.classList.remove('border-red-500', 'bg-red-50');
                    }, 3000);
                }
            });

            const form = dateInput.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const selectedDate = dateInput.value;
                    if (selectedDate && isHoliday(selectedDate)) {
                        e.preventDefault();
                        const holidayName = getHolidayName(selectedDate);
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak bisa booking di hari libur!',
                            html: `Hari libur: <b>"${holidayName}"</b><br>Silakan pilih tanggal lain.`,
                            confirmButtonText: 'OK'
                        });
                        dateInput.focus();
                        return false;
                    }
                });
            }
        });
    </script>
</x-app-layout>