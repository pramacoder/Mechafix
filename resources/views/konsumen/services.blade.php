<x-layoutkonsumen>
@php
    $user = auth()->user();
    $userVehicles = ($user && $user->konsumen && $user->konsumen->platKendaraan) ? $user->konsumen->platKendaraan : collect();
@endphp
    <div class="relative min-h-96 bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('{{ asset('Services1.png') }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="container mx-auto px-6 py-24 relative z-10">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold text-white mb-4">Book Your Service Today!</h1>
                <p class="text-xl text-gray-200 mb-8">Contact us now to schedule your appointment or to learn more
                    about our services.</p>
                <div class="flex space-x-4">
                    {{-- <button
                        class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded font-semibold transition duration-300">
                        Inquire
                    </button> --}}
                    <a href="https://wa.me/6287743447862"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded font-semibold transition duration-300">
                        Inquire
                    </a>
                    <a href="#booking-section"
                        class="border-2 border-white text-white hover:bg-white hover:text-gray-800 px-8 py-3 rounded font-semibold transition duration-300">
                        Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Section -->
    <div id="booking-section" class="container mx-auto px-6 py-16">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Side - Info -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Book Your Service</h2>
                <p class="text-gray-600 mb-8">Make a booking by filling out the form on the side.</p>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                </path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">mechafix@fixyou.com</span>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-gray-700">+62 877 43447862</span>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700">Universitas Udayana, Kampus Sudirman</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="lg:w-1/2">
                <div class="bg-white border border-black/10 shadow-xl rounded-2xl p-8 min-h-[420px] flex flex-col justify-center">
                {{-- Debug --}}
                {{-- {{ dd($userVehicles) }} --}}
                    @if ($userVehicles->count() > 0)
                        <form method="POST" action="{{ route('booking.store') }}" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Pilih Kendaraan -->
                                <div class="md:col-span-2">
                                    <label for="id_plat_kendaraan" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kendaraan</label>
                                    <select id="id_plat_kendaraan" name="id_plat_kendaraan"
                                        class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white shadow-sm" required>
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
                                    <label for="tanggal_booking" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Booking</label>
                                    <input id="tanggal_booking" class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white shadow-sm" type="date"
                                        name="tanggal_booking" value="{{ old('tanggal_booking') }}"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        max="{{ date('Y-m-d', strtotime('+3 months')) }}" required />
                                    @error('tanggal_booking')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        <span class="text-red-500">⚠️</span> Jika tidak bisa memilih tanggal maka bengkel tutup.
                                    </p>
                                </div>

                                <!-- Estimasi Kedatangan -->
                                <div>
                                    <label for="estimasi_kedatangan" class="block text-sm font-semibold text-gray-700 mb-2">Jam Kedatangan</label>
                                    <select id="estimasi_kedatangan" name="estimasi_kedatangan"
                                        class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white shadow-sm"
                                        required>
                                        @for ($i = 0; $i < 24; $i++)
                                            @php
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                $isClosed = $i >= 19 || $i < 8;
                                            @endphp
                                            <option value="{{ $hour }}:00"
                                                @if($isClosed) style="color:red;font-weight:bold;" disabled @endif
                                                {{ old('estimasi_kedatangan') == $hour.':00' ? 'selected' : '' }}>
                                                {{ $hour }}:00 {{ $isClosed ? '(Tutup)' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('estimasi_kedatangan')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Keluhan Konsumen -->
                                <div class="md:col-span-2">
                                    <label for="keluhan_konsumen" class="block text-sm font-semibold text-gray-700 mb-2">Masalah Kendaraan</label>
                                    <textarea id="keluhan_konsumen" name="keluhan_konsumen" rows="4"
                                        class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white shadow-sm"
                                        placeholder="Tuliskan permasalahan kendaraanmu..." required>{{ old('keluhan_konsumen') }}</textarea>
                                    @error('keluhan_konsumen')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8 space-x-3">
                                <a href="{{ route('dashboard.konsumen') }}"
                                    class="inline-flex items-center px-5 py-2 bg-black text-white rounded-lg font-semibold text-sm shadow hover:bg-gray-800 transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold text-sm shadow hover:bg-orange-600 transition-all duration-200">
                                    {{ __('Submit Booking') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="flex flex-col items-center justify-center h-full py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                            </svg>
                            <h3 class="mt-4 text-xl font-bold text-black">Tidak ditemukan kendaraan</h3>
                            <p class="mt-2 text-base text-gray-500">Kamu harus menambah kendaraan sebelum booking service.</p>
                            <div class="mt-8">
                                <a href="{{ route('platkendaraan.create') }}"
                                    class="inline-flex items-center px-6 py-3 rounded-xl text-white bg-orange-500 hover:bg-orange-600 font-semibold shadow transition-all duration-200">
                                    Add Vehicle First
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-brand-trusted />
    <x-section1-service>
        
    </x-section1-service>

    <script>
        // Add some interactive behavior
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Booking request submitted! We will contact you soon.');
        });

        // Add hover effects to buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Smooth scroll untuk Schedule
        const scheduleBtn = document.querySelector('a[href="#booking-section"]');
        if (scheduleBtn) {
            scheduleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById('booking-section');
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        }
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


</x-layoutkonsumen>
