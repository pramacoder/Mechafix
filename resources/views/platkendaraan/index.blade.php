<x-layoutkonsumen>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black tracking-tight">
                {{ __('My Vehicles') }}
            </h2>
            <a href="{{ route('platkendaraan.create') }}"
                class="inline-flex items-center px-5 py-2 bg-orange-500 rounded-xl font-semibold text-white text-sm shadow hover:bg-orange-600 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Vehicle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-2xl">
                <div class="p-8">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('platkendaraan.create') }}"
                            class="inline-flex items-center px-6 py-3 rounded-xl text-white bg-orange-500 hover:bg-orange-600 font-semibold shadow transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Vehicle
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold text-black mb-6">
                        Vehicle Management
                    </h1>

                    @if ($platkendaraan->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($platkendaraan as $kendaraan)
                                <div class="bg-white border border-black/10 rounded-xl shadow p-6 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-xl font-bold text-black">
                                                {{ $kendaraan->nomor_plat_kendaraan }}
                                            </h3>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-600">
                                                Vehicle
                                            </span>
                                        </div>
                                        <div class="space-y-2 mb-6">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-500">Engine:</span>
                                                <span class="text-sm font-semibold text-black">{{ $kendaraan->cc_kendaraan }} CC</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-500">Total Bookings:</span>
                                                <span class="text-sm font-semibold text-black">{{ $kendaraan->bookingServices()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('platkendaraan.history', $kendaraan->id_plat_kendaraan) }}"
                                            class="flex-1 text-center px-3 py-2 text-sm bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all duration-200 shadow">
                                            History
                                        </a>
                                        <a href="{{ route('platkendaraan.edit', $kendaraan->id_plat_kendaraan) }}"
                                            class="flex-1 text-center px-3 py-2 text-sm bg-black text-white rounded-lg hover:bg-gray-800 transition-all duration-200 shadow">
                                            Edit
                                        </a>
                                        <form action="{{ route('platkendaraan.destroy', $kendaraan->id_plat_kendaraan) }}"
                                            method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-3 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 shadow"
                                                onclick="return confirm('Are you sure?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                            </svg>
                            <h3 class="mt-4 text-xl font-bold text-black">No vehicles</h3>
                            <p class="mt-2 text-base text-gray-500">Get started by adding your first vehicle.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layoutkonsumen>
