<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mechanic Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 lg:p-8">
                    <div class="flex items-start space-x-6">
                        <!-- Basic Info -->
                        <div class="flex-1">
                            <div class="mb-3">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $mekanik->user->name }}</h1>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">📧 Email: </span>
                                        <span class="text-gray-700">{{ $mekanik->user->email }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">📅 Joined: </span>
                                        <span class="text-gray-700">{{ $mekanik->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">📅 Hari Kerja: </span>
                                        <span class="text-gray-700">{{ $mekanik->kuantitas_hari }}</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">🕒 Experience:</span>
                                        <span class="text-gray-700">
                                            @php
                                                $totalDays = $stats['working_days'];
                                                $years = floor($totalDays / 365);
                                                $months = floor(($totalDays % 365) / 30);
                                                $days = $totalDays % 30;
                                            @endphp

                                            @if ($totalDays < 30)
                                                {{-- Kurang dari 1 bulan --}}
                                                {{ $totalDays }} {{ Str::plural('day', $totalDays) }}
                                            @elseif($totalDays < 365)
                                                {{-- Kurang dari 1 tahun --}}
                                                {{ $months }} {{ Str::plural('month', $months) }}
                                                @if ($days > 0)
                                                    {{ $days }} {{ Str::plural('day', $days) }}
                                                @endif
                                            @else
                                                {{-- Lebih dari 1 tahun --}}
                                                {{ $years }} {{ Str::plural('year', $years) }}
                                                @if ($months > 0)
                                                    {{ $months }} {{ Str::plural('month', $months) }}
                                                @endif
                                                @if ($days > 0)
                                                    {{ $days }} {{ Str::plural('day', $days) }}
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">🏆 Completion: </span>
                                        <span
                                            class="text-green-600 font-medium">{{ $performance['completion_rate'] }}%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-20">📊 Avg/Month: </span>
                                        <span
                                            class="text-blue-600 font-medium">{{ $performance['avg_jobs_per_month'] }}
                                            jobs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">🔧</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total_jobs'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 font-bold text-sm">✅</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_jobs'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <span class="text-yellow-600 font-bold text-sm">⚡</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['active_jobs'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                    <span class="text-orange-600 font-bold text-sm">⏳</span>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_jobs'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 lg:p-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Performance Metrics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Completion Rate -->
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $performance['completion_rate'] }}%</div>
                            <div class="text-sm text-gray-600">Job Completion Rate</div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-green-600 h-2 rounded-full"
                                    style="width: {{ $performance['completion_rate'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Service History with This Mechanic -->
            @if ($myBookings->count() > 0)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 lg:p-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🔧 My Service History with
                            {{ $mekanik->user->name }}</h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Vehicle</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Services</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($myBookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->tanggal_booking->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $booking->platKendaraan->nomor_plat_kendaraan }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $booking->platKendaraan->cc_kendaraan }} CC</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm">
                                                    @foreach ($booking->transaksiServices as $transaksi)
                                                        <div class="text-gray-700">•
                                                            {{ $transaksi->service->nama_service }}</div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @php
                                                    $payment = optional($booking->pembayarans)->first();
                                                @endphp
                                                @if ($payment)
                                                    Rp {{ number_format($payment->total_pembayaran, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if ($booking->status_booking === 'menunggu') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status_booking === 'dikonfirmasi') bg-blue-100 text-blue-800
                                                    @elseif($booking->status_booking === 'selesai') bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst($booking->status_booking) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 lg:p-8">
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <div class="text-gray-400 text-4xl mb-4">🔧</div>
                            <p class="text-gray-500">No service history with this mechanic yet.</p>
                            <p class="text-sm text-gray-400">Book a service to start working with
                                {{ $mekanik->user->name }}!</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chat with Mechanic -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 lg:p-8 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">💬 Chat dengan {{ $mekanik->user->name }}</h3>
                    <a href="{{ route('filachat.show', ['mekanik' => $mekanik->id_mekanik]) }}"
                        class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl shadow transition-all duration-200">
                        Mulai Chat
                    </a>
                </div>
            </div>

            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
