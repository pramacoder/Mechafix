{{-- resources/views/components/job-estimation.blade.php --}}

@if(auth()->user()->konsumen)
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Bookings -->
    <div class="relative group cursor-pointer bg-white overflow-hidden shadow rounded-lg transition-all duration-200"
         onclick="window.location.href='{{ url('/konsumen/services#booking-section') }}'">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-lg font-medium text-gray-500 truncate">Total Bookings</dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{ auth()->user()->konsumen->bookingServices()->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <!-- Overlay hover -->
        <div class="absolute inset-0 bg-orange-500 bg-opacity-90 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <span class="text-white text-lg font-bold tracking-wide">Ingin booking?</span>
        </div>
    </div>

    <!-- My Vehicles -->
    <div
        class="bg-white overflow-hidden shadow rounded-lg cursor-pointer transition-all duration-200 hover:bg-orange-500 hover:text-white group"
        onclick="window.location.href='{{ route('platkendaraan.index') }}'">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400 group-hover:text-white transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-lg font-medium text-gray-500 group-hover:text-white truncate">My Vehicles</dt>
                        <dd class="text-lg font-medium text-gray-900 group-hover:text-white">
                            {{ auth()->user()->konsumen->platKendaraan()->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-lg font-medium text-gray-500 truncate">Pending Payment</dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{ auth()->user()->konsumen->bookingServices()
                                ->where('status_booking', 'selesai')
                                ->whereHas('pembayarans', function ($q) { $q->where('status_pembayaran', 'Belum Dibayar'); })
                                ->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed & Paid -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-lg font-medium text-gray-500 truncate">Paid</dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{ auth()->user()->konsumen->bookingServices()
                                ->where('status_booking', 'selesai')
                                ->whereHas('pembayarans', function ($q) { $q->where('status_pembayaran', 'Sudah Dibayar'); })
                                ->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


<!-- Pending Payments Alert Section -->
@if(auth()->user()->konsumen)
    @php
        $pendingPayments = auth()
            ->user()
            ->konsumen->bookingServices()
            ->where('status_booking', 'selesai')
            ->with(['platKendaraan', 'pembayarans', 'transaksiServices.service', 'transaksiSpareParts.sparePart'])
            ->whereHas('pembayarans', function ($q) {
                $q->where('status_pembayaran', 'Belum Dibayar');
            })
            ->get();
    @endphp

    @if ($pendingPayments->count() > 0)
        <div class="bg-red-50 border border-red-200 rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-red-900 mb-4">⚠️ Pending Payments</h3>
                <div class="space-y-4">
                    @foreach ($pendingPayments as $booking)
                        @php
                            $payment = $booking->pembayarans->first();
                            $serviceTotal = $booking->transaksiServices->sum('subtotal_service');
                            $sparepartTotal = $booking->transaksiSpareParts->sum('subtotal_barang');
                            $calculatedTotal = $serviceTotal + $sparepartTotal;
                            $isPaid = $payment && $payment->status_pembayaran === 'Sudah Dibayar';
                            $isCashConfirmed = $payment && $payment->bukti_pembayaran === 'cash_payment_confirmed';
                            $isProofUploaded =
                                $payment &&
                                $payment->bukti_pembayaran &&
                                $payment->bukti_pembayaran !== 'cash_payment_confirmed';
                        @endphp
                        <div class="bg-white border border-red-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">Booking #{{ $booking->id_booking_service }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->platKendaraan->nomor_plat_kendaraan }} -
                                        {{ $booking->tanggal_booking->format('d M Y') }}</p>

                                    <!-- Service Details Breakdown -->
                                    <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                        <h6 class="text-sm font-medium text-gray-800 mb-2">Service Details:</h6>
                                        <div class="space-y-1">
                                            @foreach ($booking->transaksiServices as $transaksi)
                                                <div class="flex justify-between text-sm">
                                                    <span
                                                        class="text-gray-700">{{ $transaksi->service->nama_service }}</span>
                                                    <span class="font-medium text-gray-900">Rp
                                                        {{ number_format($transaksi->subtotal_service, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                            @foreach ($booking->transaksiSpareParts as $transaksi)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-green-700">
                                                        {{ $transaksi->sparePart->nama_barang ?? '-' }}
                                                        @if ($transaksi->kuantitas_barang > 1)
                                                            (x{{ $transaksi->kuantitas_barang }})
                                                        @endif
                                                    </span>
                                                    <span class="font-medium text-green-900">Rp
                                                        {{ number_format($transaksi->subtotal_barang ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                            <div class="border-t pt-2 mt-2">
                                                <div class="flex justify-between text-sm font-semibold">
                                                    <span class="text-gray-800">Total Amount:</span>
                                                    <span class="text-red-600">
                                                        Rp {{ number_format($calculatedTotal, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-lg font-bold text-red-600">
                                        Rp {{ number_format($calculatedTotal, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">Due:
                                        {{ optional($payment->tanggal_pembayaran)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <h5 class="font-medium text-gray-800 mb-3">Payment:</h5>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- QRIS Payment -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h6 class="font-medium text-blue-900 mb-2">💳 QRIS Transfer</h6>
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $payment->qris) }}" alt="QRIS Code"
                                                class="w-32 h-32 mx-auto border rounded">
                                        </div>

                                        <!-- Upload Bukti Transfer -->
                                        <form action="{{ route('konsumen.upload-bukti', $payment->id_pembayaran) }}"
                                            method="POST" enctype="multipart/form-data" class="space-y-3">
                                            @csrf
                                            <div>
                                                <label class="block text-sm font-medium text-blue-800 mb-1">
                                                    Upload Payment Proof:
                                                </label>
                                                <input type="file" name="bukti_pembayaran" accept="image/*" required
                                                    class="w-full px-3 py-2 border border-blue-300 rounded-md text-sm">
                                            </div>

                                            @if ($payment->bukti_pembayaran && $payment->bukti_pembayaran !== 'cash_payment_confirmed')
                                                <div class="text-xs text-green-600">
                                                    ✅ Proof uploaded, waiting for verification
                                                </div>
                                            @else
                                                <button type="submit"
                                                    class="w-full bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                                                    Upload Proof
                                                </button>
                                            @endif
                                        </form>
                                    </div>

                                    <!-- Cash Payment -->
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h6 class="font-medium text-green-900 mb-2"> Cash Payment</h6>
                                        <p class="text-sm text-green-700 mb-3">Pay directly at our cashier counter</p>

                                        @php
                                            $payment =
                                                $booking->pembayarans->firstWhere('status_pembayaran', 'Belum Dibayar') ??
                                                $booking->pembayarans->first();

                                            $bukti = trim((string) ($payment->bukti_pembayaran ?? ''));
                                            $status = $payment->status_pembayaran ?? 'Belum Dibayar';

                                            $isCashConfirmed = $bukti === 'cash_payment_confirmed';
                                            $isProofUploaded = $bukti !== '' && $bukti !== 'cash_payment_confirmed';
                                            $isNoPaymentYet = $bukti === '' && $status === 'Belum Dibayar';
                                        @endphp

                                        @if ($isCashConfirmed)
                                            <div class="text-xs text-green-600 mb-2">
                                                ✅ Cash payment confirmed. Please pay at counter.
                                            </div>
                                            <button type="button" disabled
                                                class="w-full bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed">
                                                Cash Payment Confirmed
                                            </button>
                                        @elseif ($isProofUploaded)
                                            <div class="text-xs text-blue-600 mb-2">
                                                📤 Proof uploaded, waiting for verification
                                            </div>
                                            <button type="button" disabled
                                                class="w-full bg-gray-400 text-white px-3 py-2 rounded text-sm cursor-not-allowed">
                                                Cash Payment Disabled
                                            </button>
                                        @elseif ($isNoPaymentYet)
                                            <form action="{{ route('konsumen.cash-payment', $payment->id_pembayaran) }}"
                                                method="POST">
                                                @csrf
                                                <button type="button"
                                                    onclick="showCashConfirmModal(this.form, {{ $payment->total_pembayaran }})"
                                                    class="w-full bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700">
                                                    I'll Pay Cash at Counter
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="cashConfirmModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Confirm Cash Payment</h3>
                    <p class="mb-6 text-gray-700" id="cashConfirmText">
                        Are you sure you will pay in cash at our counter?
                    </p>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeCashConfirmModal()"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">No</button>
                        <button type="button" id="cashConfirmYesBtn"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Yes, Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

{{-- @include('dashboard.spare-part') --}}

<!-- Header Mechafix Modern: Background Image, Gradient Text, 2 Tombol -->
<div class="relative h-[420px] flex items-center justify-start overflow-hidden rounded-2xl shadow-lg mb-10">
    <!-- Background Image -->
    <img src="{{ asset('Services1.png') }}" alt="Mechafix Background" class="absolute inset-0 w-full h-full object-cover object-center z-0">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/70 z-10"></div>
    <!-- Content -->
    <div class="relative z-20 max-w-2xl pl-8 md:pl-16">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-white drop-shadow-lg">
            Mechafix, Solusi Modern<br>Servis & Sparepart Motor Anda
        </h1>
        <p class="text-white/90 text-lg mb-8 max-w-lg drop-shadow">
            Platform bengkel motor modern: booking, estimasi biaya, dan pantau status servis dengan mudah, cepat, dan <span class="text-orange-400 font-semibold">transparan</span>.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('booking.create') }}"
                class="px-6 py-3 bg-orange-500 text-white font-bold rounded-lg shadow hover:bg-orange-600 transition text-lg text-center">
                Booking Service
            </a>
            <a href="{{ route('platkendaraan.index') }}"
                class="px-6 py-3 bg-black border-2 border-orange-400 text-white font-bold rounded-lg shadow hover:bg-gray-800 transition text-lg text-center">
                Manage Vehicles
            </a>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
@if(auth()->user()->konsumen)
    @php
        $recentBookings = auth()
            ->user()
            ->konsumen->bookingServices()
            ->with([
                'platKendaraan',
                'mekanik.user',
                'pembayarans',
                'transaksiServices.service',
                'transaksiSpareParts.sparePart',
            ])
            ->latest()
            ->take(10)
            ->get();
    @endphp

    @if ($recentBookings->count() > 0)
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-10 border-2 border-orange-500">
            <div class="p-6 lg:p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Bookings</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Service & Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Next Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                    Mechanic</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentBookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->platKendaraan->nomor_plat_kendaraan }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->platKendaraan->cc_kendaraan }} CC
                                        </div>
                                        @if ($booking->status_booking === 'menunggu' && now()->diffInDays($booking->tanggal_booking, false) >= 3)
                                            <form
                                                action="{{ route('konsumen.cancel-booking', $booking->id_booking_service) }}"
                                                method="POST" class="inline mt-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button"
                                                    onclick="showCancelModal({{ $booking->id_booking_service }})"
                                                    class="text-red-600 hover:text-red-900 text-xs bg-red-100 px-2 py-1 rounded">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->tanggal_booking->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if ($booking->status_booking === 'menunggu') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status_booking === 'dikonfirmasi') bg-blue-100 text-blue-800
                                            @elseif($booking->status_booking === 'selesai') bg-green-100 text-green-800
                                            @elseif($booking->status_booking === 'batal') bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($booking->status_booking) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $serviceCount = $booking->transaksiServices->count();
                                            $sparepartCount = $booking->transaksiSpareParts->count();

                                            $totalService = $booking->transaksiServices->sum(
                                                fn($s) => $s->subtotal_service ?? 0,
                                            );
                                            $totalSparepart = $booking->transaksiSpareParts->sum(
                                                fn($s) => $s->subtotal_barang ?? 0,
                                            );
                                            $total = $totalService + $totalSparepart;
                                        @endphp
                                        @if ($serviceCount > 0 || $sparepartCount > 0)
                                            <div class="text-sm">
                                                @if ($serviceCount)
                                                    <div class="space-y-1 mb-2">
                                                        @foreach ($booking->transaksiServices as $transaksi)
                                                            <div class="flex justify-between">
                                                                <span
                                                                    class="text-gray-700 text-xs">{{ Str::limit($transaksi->service->nama_service, 20) }}</span>
                                                                <span class="text-gray-900 text-xs font-medium">Rp
                                                                    {{ number_format($transaksi->subtotal_service, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if ($sparepartCount)
                                                    <div class="space-y-1 mb-2">
                                                        @foreach ($booking->transaksiSpareParts as $transaksi)
                                                            <div class="flex justify-between">
                                                                <span class="text-green-700 text-xs">
                                                                    {{ Str::limit($transaksi->sparePart->nama_barang ?? '-', 20) }}
                                                                    @if ($transaksi->kuantitas_barang > 1)
                                                                        (x{{ $transaksi->kuantitas_barang }})
                                                                    @endif
                                                                </span>
                                                                <span class="text-green-900 text-xs font-medium">Rp
                                                                    {{ number_format($transaksi->subtotal_barang ?? 0, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="border-t pt-1">
                                                    <div class="flex justify-between">
                                                        <span class="text-sm font-semibold text-gray-800">Total:</span>
                                                        <span class="text-sm font-bold text-blue-600">
                                                            Rp {{ number_format($total, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">No services or spare parts selected</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $payment = $booking->pembayarans; @endphp
                                        @if ($payment)
                                            @if ($payment->status_pembayaran === 'Sudah Dibayar')
                                                <span
                                                    class="px-3 py-2 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                    ✅ Paid
                                                </span>
                                            @else
                                                <div class="text-center">
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full block mb-2">
                                                        ❌ Unpaid
                                                    </span>
                                                    <button
                                                        onclick="openPaymentModal({{ $payment->id_pembayaran }}, '{{ $booking->platKendaraan->nomor_plat_kendaraan }}', {{ $payment->total_pembayaran }}, '{{ addslashes($payment->qris) }}')"
                                                        class="px-3 py-2 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 w-full">
                                                        Selesaikan Pembayaran
                                                    </button>
                                                </div>
                                            @endif
                                        @elseif($booking->status_booking === 'selesai')
                                            <span class="text-orange-500 text-xs">⏳ Payment Pending</span>
                                        @else
                                            <span class="text-gray-400 text-xs">No payment required</span>
                                        @endif
                                    </td>

                                    {{-- KOLOM NEXT SERVICE --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $hasService =
                                                $booking->transaksiServices && $booking->transaksiServices->count() > 0;
                                            $payment = $booking->pembayaran ?? null;
                                            $isPaid = $payment && $payment->status_pembayaran === 'Sudah Dibayar';
                                            $nextServiceDate = null;

                                            if ($hasService && $isPaid) {
                                                $riwayat = \App\Models\RiwayatPerbaikan::where(
                                                    'id_plat_kendaraan',
                                                    $booking->id_plat_kendaraan,
                                                )
                                                    ->where('id_pembayaran', $payment->id_pembayaran)
                                                    ->first();
                                                if ($riwayat && $riwayat->next_service) {
                                                    $nextServiceDate = \Carbon\Carbon::parse($riwayat->next_service);
                                                }
                                            }
                                        @endphp

                                        @if ($hasService && $isPaid && $nextServiceDate)
                                            <div class="text-center">
                                                <div class="text-sm font-medium text-blue-600">
                                                    {{ $nextServiceDate->format('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    @if ($nextServiceDate->isPast())
                                                        <span class="text-red-600 font-medium">⚠️ Overdue</span>
                                                    @elseif($nextServiceDate->diffInDays(now()) <= 7)
                                                        <span class="text-orange-600 font-medium">🔔 Soon</span>
                                                    @else
                                                        <span
                                                            class="text-green-600">{{ $nextServiceDate->diffInDays(now()) }}
                                                            days left</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($hasService && $isPaid)
                                            <span class="text-blue-600 text-sm">📅 Available</span>
                                        @elseif($hasService && !$isPaid)
                                            <span class="text-gray-400 text-sm">⏳ Pending payment</span>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($booking->mekanik)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    @if ($booking->mekanik->user->profile_photo_path)
                                                        <img class="h-8 w-8 rounded-full object-cover"
                                                            src="{{ $booking->mekanik->user->profile_photo_url }}"
                                                            alt="{{ $booking->mekanik->user->name }}">
                                                    @else
                                                        <div
                                                            class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span
                                                                class="text-sm font-medium text-gray-700">{{ substr($booking->mekanik->user->name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <a href="{{ route('konsumen.mekanik-profile', $booking->mekanik->id_mekanik) }}"
                                                        class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                                        {{ $booking->mekanik->user->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $booking->mekanik->spesialisasi ?? 'Mechanic' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">Not assigned</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="cancelModal"
                        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Cancel Booking</h3>
                            <p class="mb-6 text-gray-700">Are you sure you want to cancel this booking?</p>
                            <form id="cancelBookingForm" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="closeCancelModal()"
                                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">No</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Yes,
                                        Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <div class="text-gray-400 text-6xl mb-4">🔧</div>
                    <p class="text-gray-500">No bookings yet.</p>
                    <p class="text-sm text-gray-400 mb-4">Start by booking your first service!</p>
                    <a href="{{ route('booking.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Book First Service
                    </a>
                </div>
            @endif
        </div>
    @endif

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div
        class="relative top-10 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">🏦 Complete Payment</h3>

            <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-blue-900">Vehicle:</p>
                        <p id="vehicleInfo" class="text-lg font-bold text-blue-800"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-blue-900">Total Amount:</p>
                        <p id="amountInfo" class="text-xl font-bold text-blue-800"></p>
                    </div>
                </div>
            </div>

            <!-- Payment Method Switch -->
            <div class="mb-6">
                <h4 class="text-md font-medium text-gray-800 mb-3">Choose Payment Method:</h4>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Cash Payment Option -->
                    <div class="border border-gray-300 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors"
                        onclick="selectPaymentMethod('cash')">
                        <div class="text-center">
                            <div class="text-4xl mb-2">💰</div>
                            <h5 class="font-medium text-gray-900">Cash Payment</h5>
                            <p class="text-xs text-gray-600 mt-1">Pay directly to admin/cashier</p>
                        </div>
                        <input type="radio" name="payment_method" value="cash" class="hidden"
                            id="payment_cash">
                    </div>

                    <!-- Cashless Payment Option -->
                    <div class="border border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors"
                        onclick="selectPaymentMethod('cashless')">
                        <div class="text-center">
                            <div class="text-4xl mb-2">💳</div>
                            <h5 class="font-medium text-gray-900">Transfer/QRIS</h5>
                            <p class="text-xs text-gray-600 mt-1">Pay via transfer/QRIS</p>
                        </div>
                        <input type="radio" name="payment_method" value="cashless" class="hidden"
                            id="payment_cashless">
                    </div>
                </div>
            </div>

            <!-- Cash Payment Section -->
            <div id="cashPaymentSection" class="hidden">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <h5 class="font-medium text-green-900 mb-2">💰 Cash Payment</h5>
                    <p class="text-sm text-green-700 mb-3">
                        Please pay directly to our admin/cashier with this booking slip.
                        After confirmation, admin will update payment status.
                    </p>
                    <form id="cashPaymentForm" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-4 py-3 rounded text-sm font-medium hover:bg-green-700">
                            ✅ Confirm Cash Payment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cashless Payment Section -->
            <div id="cashlessPaymentSection" class="hidden">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h5 class="font-medium text-blue-900 mb-3">💳 Cashless Payment</h5>

                    <!-- QRIS Code Display -->
                    <div class="text-center mb-4">
                        <p class="text-sm text-blue-700 mb-2">Scan QRIS code below:</p>
                        <div class="inline-block border-2 border-blue-300 rounded-lg p-2 bg-white">
                            <img id="qrisImage" src="" alt="QRIS Code" class="w-48 h-48 mx-auto">
                        </div>
                    </div>

                    <!-- Upload Bukti Transfer -->
                    <form id="cashlessPaymentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-2">Upload Payment
                                    Proof:</label>
                                <input type="file" name="bukti_pembayaran" accept="image/*" required
                                    class="w-full px-3 py-2 border border-blue-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-blue-600 mt-1">Supported: JPG, PNG, JPEG (Max: 2MB)</p>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-4 py-3 rounded text-sm font-medium hover:bg-blue-700">
                                📤 Upload Payment Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button type="button" onclick="closePaymentModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="relative z-10 container mx-auto px-6 py-12">
    {{-- Get Your Estimate Section --}}
    <div class="text-center mb-16">
        <div class="text-orange-400 text-sm font-semibold mb-4 tracking-wider">MECHAFIX</div>
        <h1 class="text-4xl md:text-5xl font-bold text-grey-900 mb-8">Get Your Estimate</h1>

        <div class="max-w-md mx-auto mb-8">
            <label class="block text-grey-900 text-lg font-medium mb-4">Input Your Bike Numbers</label>
            <input type="text" id="bikeNumbers"
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-orange-400 focus:outline-none text-gray-900 text-center text-lg"
                placeholder="Masukkan nomor plat motor" onkeyup="checkInput()">
        </div>

        <p class="text-gray-700 mb-8 max-w-2xl mx-auto">
            Discover how our job estimation process provides transparency and accuracy for your motorbike repairs.
        </p>

        <button id="viewQueueBtn" onclick="showEstimation()"
            class="bg-black hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            View Queue
        </button>
    </div>

    {{-- Loading State --}}
    <div id="loadingState" class="hidden text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-400 mx-auto mb-4"></div>
        <p class="text-gray-600">Loading booking information...</p>
    </div>

    {{-- Error State --}}
    <div id="errorState" class="hidden text-center py-12">
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-red-800 mb-2">Booking Not Found</h3>
            <p class="text-red-600" id="errorMessage">No booking found for this license plate number.</p>
        </div>
    </div>

    {{-- Job Estimation Statistics (Hidden by default) --}}
    <div id="estimationStats" class="hidden min-h-screen flex-col items-center">
        <div class="bg-gray-900 backdrop-blur-sm border border-gray-700 rounded-lg p-8">
            {{-- Header Section --}}
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12">
                <div class="mb-6 lg:mb-0">
                    <div class="text-orange-400 text-sm font-medium mb-2">Estimates</div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                        Reliable Job Estimation<br>
                        Statistics for You
                    </h2>
                </div>

                <div class="text-right">
                    <p class="text-gray-300 mb-2">We pride ourselves on providing accurate estimates quickly.</p>
                    <p class="text-orange-400 font-medium">Customer satisfaction is our top priority.</p>

                    <div class="flex items-center justify-end mt-4">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-medium" id="customerName">-</div>
                            <div class="text-gray-400 text-sm">License Plate</div>
                        </div>
                        <div class="ml-6">
                            <div class="text-orange-400 font-bold text-lg">MECHAFIX</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                {{-- Progress Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-4xl font-bold text-teal-400 mb-4" id="progressStatus">-</div>
                    <div class="text-teal-400 text-lg font-medium">Progress</div>
                    <div class="text-gray-300 text-sm mt-2" id="progressDescription">Current booking status</div>
                </div>

                {{-- Estimate Time Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-4xl font-bold text-teal-400 mb-4" id="estimateTime">-</div>
                    <div class="text-gray-300 text-sm mb-1" id="estimateDate">-</div>
                    <div class="text-orange-400 text-lg font-medium">Estimate Time</div>
                </div>

                {{-- Booking Info Card --}}
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-8 relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-400 rounded-l-lg"></div>
                    <div class="text-2xl font-bold text-teal-400 mb-4" id="bookingDate">-</div>
                    <div class="text-teal-400 text-lg font-medium">Booking Date</div>
                    <div class="text-gray-300 text-sm mt-2" id="arrivalTime">-</div>
                </div>
            </div>

            {{-- Customer Complaint --}}
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-lg p-6 mb-8">
                <h3 class="text-white font-medium mb-3">Customer Complaint</h3>
                <p class="text-gray-300" id="customerComplaint">-</p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    </svg>
                    Chat to Mechanic
                </button>
                <a href="/billing">
                    <button
                        class="bg-orange-400 hover:bg-orange-500 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300">
                        Billing
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    let countdownInterval;

    function checkInput() {
        const input = document.getElementById('bikeNumbers');
        const button = document.getElementById('viewQueueBtn');

        if (input.value.trim().length > 0) {
            button.disabled = false;
            button.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function showEstimation() {
        const input = document.getElementById('bikeNumbers');
        const plateNumber = input.value.trim();
        
        if (!plateNumber) return;

        // Show loading state
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('estimationStats').classList.add('hidden');

        // Fetch booking data
        fetch(`/api/booking-status/${encodeURIComponent(plateNumber)}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('loadingState').classList.add('hidden');
                
                if (data.success) {
                    updateEstimationStats(data.booking);
                    showEstimationStats();
                } else {
                    showError(data.message || 'Booking not found');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loadingState').classList.add('hidden');
                showError('Failed to load booking information');
            });
    }

    function updateEstimationStats(booking) {
        // Update customer name (license plate)
        document.getElementById('customerName').textContent = booking.plat_kendaraan.nomor_plat_kendaraan;

        // Update progress status
        const statusMap = {
            'menunggu': { text: 'Waiting', color: 'text-yellow-400', description: 'Waiting for confirmation' },
            'dikonfirmasi': { text: 'Confirmed', color: 'text-blue-400', description: 'Work in progress' },
            'selesai': { text: 'Completed', color: 'text-green-400', description: 'Service completed' },
            'batal': { text: 'Cancelled', color: 'text-red-400', description: 'Booking cancelled' }
        };

        const statusInfo = statusMap[booking.status_booking] || { text: booking.status_booking, color: 'text-gray-400', description: 'Unknown status' };
        
        const progressElement = document.getElementById('progressStatus');
        progressElement.textContent = statusInfo.text;
        progressElement.className = `text-4xl font-bold mb-4 ${statusInfo.color}`;
        document.getElementById('progressDescription').textContent = statusInfo.description;

        // Update booking date and arrival time
        const bookingDate = new Date(booking.tanggal_booking);
        document.getElementById('bookingDate').textContent = bookingDate.toLocaleDateString('id-ID');
        document.getElementById('arrivalTime').textContent = `Arrival: ${booking.estimasi_kedatangan}`;

        // Update customer complaint
        document.getElementById('customerComplaint').textContent = booking.keluhan_konsumen;

        // Update estimate time based on status
        updateEstimateTime(booking);
    }

    function updateEstimateTime(booking) {
        const estimateTimeElement = document.getElementById('estimateTime');
        const estimateDateElement = document.getElementById('estimateDate');

        if (booking.status_booking === 'dikonfirmasi') {
            // Calculate 48 hours from confirmation
            const confirmationTime = new Date(booking.updated_at); // Assuming updated_at is when status changed to 'dikonfirmasi'
            const completionTime = new Date(confirmationTime.getTime() + (48 * 60 * 60 * 1000)); // Add 48 hours
            
            startCountdown(completionTime);
            estimateDateElement.textContent = `