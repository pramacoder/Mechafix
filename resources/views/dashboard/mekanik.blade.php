<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Mekanik Dashboard</h3>
                <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}! Here are your assigned jobs.</p>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <!-- Stats cards -->
                <div class="bg-blue-100 p-3 rounded-lg text-center">
                    <div class="text-blue-800 text-sm font-medium">Active Jobs</div>
                    <div class="text-2xl font-bold text-blue-900">
                        {{ auth()->user()->mekanik ? auth()->user()->mekanik->bookingServices()->where('status_booking', 'dikonfirmasi')->count() : 0 }}
                    </div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg text-center">
                    <div class="text-yellow-800 text-sm font-medium">Today's Jobs</div>
                    <div class="text-2xl font-bold text-yellow-900">
                        {{ auth()->user()->mekanik ? auth()->user()->mekanik->bookingServices()->whereDate('tanggal_booking', today())->count() : 0 }}
                    </div>
                </div>
                <div class="bg-green-100 p-3 rounded-lg text-center">
                    <div class="text-green-800 text-sm font-medium">Completed Jobs</div>
                    <div class="text-2xl font-bold text-green-900">
                        {{ auth()->user()->mekanik ? auth()->user()->mekanik->bookingServices()->where('status_booking', 'selesai')->count() : 0 }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Jobs Table -->
        <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-4">Active Jobs (Confirmed)</h4>

            @if (auth()->user()->mekanik &&
                    auth()->user()->mekanik->bookingServices()->where('status_booking', 'dikonfirmasi')->exists())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complaint
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach (auth()->user()->mekanik->bookingServices()->where('status_booking', 'dikonfirmasi')->with(['konsumen.user', 'platKendaraan', 'transaksiServices.service', 'transaksiSpareParts.sparePart'])->get() as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $booking->id_booking_service }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->konsumen->user->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->platKendaraan->nomor_plat_kendaraan ?? 'Unknown' }}
                                        <br>
                                        <span
                                            class="text-xs text-gray-500">{{ $booking->platKendaraan->cc_kendaraan ?? '' }}
                                            CC</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->tanggal_booking->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                        <div class="truncate" title="{{ $booking->keluhan_konsumen }}">
                                            {{ $booking->keluhan_konsumen }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $totalBiaya =
                                                $booking->transaksiServices->sum('subtotal_service') +
                                                $booking->transaksiSpareParts->sum('subtotal_barang');
                                            $serviceCount = $booking->transaksiServices->count();
                                            $sparepartCount = $booking->transaksiSpareParts->count();
                                        @endphp
                                        @if ($serviceCount > 0 || $sparepartCount > 0)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                                Services/Parts Selected
                                            </span>
                                            <div class="text-xs text-gray-600 mt-1">
                                                Total: Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $serviceCount }} service(s), {{ $sparepartCount }} part(s)
                                            </div>
                                            @if ($sparepartCount)
                                                <div class="text-xs text-green-700 mt-1">
                                                    Spare Parts:
                                                    @foreach ($booking->transaksiSpareParts as $ts)
                                                        {{ $ts->sparePart->nama_barang ?? '-' }}@if ($ts->kuantitas_barang > 1)
                                                            (x{{ $ts->kuantitas_barang }})
                                                        @endif{{ !$loop->last ? ',' : '' }}
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                                Need Analysis
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($serviceCount === 0 && $sparepartCount === 0)
                                            <button
                                                onclick="openServiceModal({{ $booking->id_booking_service }}, '{{ $booking->platKendaraan->nomor_plat_kendaraan }}', '{{ $booking->konsumen->user->name }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                                Select Services/Parts
                                            </button>
                                        @else
                                            <a href="{{ route('mekanik.complete-job', $booking->id_booking_service) }}"
                                                onclick="return confirmCompleteJob(event, {{ $totalBiaya }})"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                                Complete Job (Rp {{ number_format($totalBiaya, 0, ',', '.') }})
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <div class="text-gray-400 text-6xl mb-4">🔧</div>
                    <p class="text-gray-500">No active jobs yet.</p>
                    <p class="text-sm text-gray-400">New confirmed jobs will appear here.</p>
                </div>
            @endif
        </div>

        <!-- Completed Jobs (status = selesai) -->
        <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-4">Recently Completed Jobs</h4>

            @if (auth()->user()->mekanik && auth()->user()->mekanik->bookingServices()->where('status_booking', 'selesai')->exists())
                <div class="space-y-3">
                    @foreach (auth()->user()->mekanik->bookingServices()->where('status_booking', 'selesai')->with(['konsumen.user', 'platKendaraan', 'pembayarans', 'transaksiServices.service', 'transaksiSpareParts.sparePart'])->latest('updated_at')->take(5)->get() as $completed)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-green-900">
                                        #{{ $completed->id_booking_service }} -
                                        {{ $completed->platKendaraan->nomor_plat_kendaraan ?? 'Unknown Vehicle' }}
                                    </p>
                                    <p class="text-sm text-green-700">
                                        Customer: {{ $completed->konsumen->user->name ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs text-green-600 mb-2">
                                        Completed: {{ $completed->updated_at->format('d M Y H:i') }}
                                    </p>
                                    <p class="text-sm text-green-800">
                                        <strong>Amount:</strong> Rp
                                        {{ number_format($completed->transaksiServices->sum('subtotal_service') + $completed->transaksiSpareParts->sum('subtotal_barang'), 0, ',', '.') }}
                                    </p>
                                    @if ($completed->transaksiSpareParts->count())
                                        <div class="text-xs text-green-700 mt-1">
                                            Spare Parts:
                                            @foreach ($completed->transaksiSpareParts as $ts)
                                                {{ $ts->sparePart->nama_barang ?? '-' }}@if ($ts->kuantitas_barang > 1)
                                                    (x{{ $ts->kuantitas_barang }})
                                                @endif{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 text-right">
                                    @if ($completed->pembayarans && $completed->pembayarans->first())
                                        @if ($completed->pembayarans->first()->status_pembayaran === 'Sudah Dibayar')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                ✅ Paid
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                                                ⏳ Awaiting Payment
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                            No Payment Record
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">No completed jobs yet.</p>
                    <p class="text-sm text-gray-400">Completed jobs will appear here.</p>
                </div>
            @endif
        </div>

        <!-- Chat Inbox Section -->
        <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-4">💬 Customer Chat Inbox</h4>
            @if (isset($conversations) && $conversations->count())
                <div class="space-y-4">
                    @foreach ($conversations as $conversation)
                        <a href="{{ route('filachat.mekanik.chat', $conversation->id) }}"
                            class="block bg-gray-50 border rounded-lg p-4 hover:bg-blue-50 transition">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="font-semibold text-blue-700">
                                        {{ $conversation->sender->agentable->name ?? 'Unknown Konsumen' }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-2">
                                        (Last:
                                        {{ $conversation->messages->last()?->created_at?->diffForHumans() ?? '-' }})
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2 text-gray-800">
                                <strong>Last message:</strong>
                                {{ $conversation->messages->last()?->message ?? 'No messages yet.' }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500">No chat conversations yet.</div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for Service & Spare Part Selection -->
<div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div
        class="relative top-10 mx-auto p-5 border w-[800px] shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">🔧 Select Services & Spare Parts</h3>
            <form id="serviceForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle & Customer</label>
                    <input type="text" id="vehicleCustomerInfo" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Pilih service yang tersedia</label>
                    <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach (\App\Models\Service::orderBy('jenis_service')->orderBy('nama_service')->get()->groupBy('jenis_service') as $jenis => $services)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-800 mb-3 text-lg border-b pb-2">{{ $jenis }}
                                </h4>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach ($services as $service)
                                        <div
                                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded border border-gray-100">
                                            <div class="flex items-center">
                                                <input type="checkbox" name="services[]"
                                                    value="{{ $service->id_service }}"
                                                    data-price="{{ $service->biaya_service }}"
                                                    data-name="{{ $service->nama_service }}"
                                                    data-time="{{ $service->estimasi_waktu }}"
                                                    id="service_{{ $service->id_service }}"
                                                    class="service-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                <label for="service_{{ $service->id_service }}"
                                                    class="ml-3 text-sm cursor-pointer flex-1">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $service->nama_service }}</div>
                                                    <div class="text-xs text-gray-500">Est.
                                                        {{ $service->estimasi_waktu }} minutes</div>
                                                </label>
                                            </div>
                                            <div class="text-sm font-medium text-blue-600 ml-4">
                                                Rp {{ number_format($service->biaya_service, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Spare Parts Used</label>
                    <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach (\App\Models\SparePart::orderBy('nama_barang')->get() as $sparepart)
                            <div
                                class="flex items-center justify-between p-3 hover:bg-gray-50 rounded border border-gray-100">
                                <div class="flex items-center">
                                    <input type="checkbox" name="spareparts[]" value="{{ $sparepart->id_barang }}"
                                        data-price="{{ $sparepart->harga_barang }}"
                                        data-name="{{ $sparepart->nama_barang }}"
                                        id="sparepart_{{ $sparepart->id_barang }}"
                                        class="sparepart-checkbox h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <label for="sparepart_{{ $sparepart->id_barang }}"
                                        class="ml-3 text-sm cursor-pointer flex-1">
                                        <div class="font-medium text-green-900">
                                            {{ $sparepart->nama_barang }}</div>
                                    </label>
                                </div>
                                <div class="text-sm font-medium text-green-700 ml-4">
                                    Rp {{ number_format($sparepart->harga_barang, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-lg font-medium text-blue-900">Total Cost:</span>
                        <span id="totalCost" class="text-xl font-bold text-blue-900">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-blue-700">
                        <span>Total Time:</span>
                        <span id="totalTime">0 minutes</span>
                    </div>
                    <div class="text-xs text-blue-600 mt-2">
                        <span id="selectedCount">0</span> item(s) selected
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <button type="button" onclick="closeServiceModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" id="saveServicesBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                        Save Selection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentBookingId = null;

    function openServiceModal(bookingId, vehicle, customer) {
        currentBookingId = bookingId;

        document.getElementById('serviceModal').classList.remove('hidden');
        document.getElementById('serviceForm').action = `/mekanik/booking/${bookingId}/services`;
        document.getElementById('vehicleCustomerInfo').value = `${vehicle} - ${customer}`;

        // Reset checkboxes and calculation
        document.querySelectorAll('.service-checkbox, .sparepart-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        calculateTotal();
    }

    function closeServiceModal() {
        document.getElementById('serviceModal').classList.add('hidden');
        currentBookingId = null;
    }

    function calculateTotal() {
        let totalCost = 0;
        let totalTime = 0;
        let selectedServiceCount = 0;
        let selectedSparepartCount = 0;

        // Services
        document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
            totalCost += parseInt(checkbox.getAttribute('data-price'));
            totalTime += parseInt(checkbox.getAttribute('data-time'));
            selectedServiceCount++;
        });

        // Spareparts
        document.querySelectorAll('.sparepart-checkbox:checked').forEach(checkbox => {
            totalCost += parseInt(checkbox.getAttribute('data-price'));
            selectedSparepartCount++;
        });

        // Update DOM elements
        document.getElementById('totalCost').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
        document.getElementById('totalTime').textContent = totalTime + ' minutes';
        document.getElementById('selectedCount').textContent = selectedServiceCount + selectedSparepartCount;

        // Enable/disable save button
        const saveBtn = document.getElementById('saveServicesBtn');
        if (selectedServiceCount > 0 || selectedSparepartCount > 0) {
            saveBtn.disabled = false;
            saveBtn.textContent =
                `Save Selection (${selectedServiceCount} service${selectedServiceCount !== 1 ? 's' : ''}, ${selectedSparepartCount} part${selectedSparepartCount !== 1 ? 's' : ''})`;
        } else {
            saveBtn.disabled = true;
            saveBtn.textContent = 'Save Selection';
        }
    }

    // Toast function
    function showAlert(type, message) {
        const alertBox = document.createElement('div');
        alertBox.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-sm 
        ${type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : ''}
        ${type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : ''}`;
        alertBox.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${type === 'success' ? 
                    '<svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 00-2 0v6a1 1 0 002 0V5z" clip-rule="evenodd" /></svg>' :
                    '<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 00-2 0v6a1 1 0 002 0V5z" clip-rule="evenodd" /></svg>'
                }
            </div>
            <div class="ml-3">
                <p class="font-medium">${type === 'success' ? 'Success!' : 'Error!'}</p>
                <p class="mt-1">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    `;
        document.body.appendChild(alertBox);

        setTimeout(() => {
            alertBox.remove();
        }, 5000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Add change listeners to checkboxes
        document.querySelectorAll('.service-checkbox, .sparepart-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Handle form submission
        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            const selectedServices = document.querySelectorAll('.service-checkbox:checked');
            const selectedSpareparts = document.querySelectorAll('.sparepart-checkbox:checked');
            if (selectedServices.length === 0 && selectedSpareparts.length === 0) {
                e.preventDefault();
                showAlert('error', 'Please select at least one service or spare part!');
                return false;
            }

            document.getElementById('saveServicesBtn').disabled = true;
            document.getElementById('saveServicesBtn').textContent = 'Saving...';
        });

        // Show flash messages as toast
        @if (session('success'))
            showAlert('success', '{{ session('success') }}');
        @endif

        @if (session('error'))
            showAlert('error', '{{ session('error') }}');
            console.error('Error:', '{{ session('error') }}');
        @endif
    });

    window.onclick = function(event) {
        const serviceModal = document.getElementById('serviceModal');
        if (event.target === serviceModal) {
            closeServiceModal();
        }
    }

    document.getElementById('serviceForm').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Ganti confirm pada tombol Complete Job dengan SweetAlert2
    window.confirmCompleteJob = function(event, total) {
        event.preventDefault();
        Swal.fire({
            title: 'Mark this job as completed?',
            text: 'Customer will be able to make payment.\nTotal: Rp ' + total.toLocaleString('id-ID'),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Complete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = event.target.href;
            }
        });
        return false;
    }
</script>