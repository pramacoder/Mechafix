<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Vehicles') }}
            </h2>
            <a href="{{ route('platkendaraan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                Add Vehicle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h1 class="text-2xl font-medium text-gray-900 mb-6">
                        Vehicle Management
                    </h1>

                    @if($platkendaraan->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($platkendaraan as $kendaraan)
                                <div class="bg-gray-50 p-6 rounded-lg border">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $kendaraan->nomor_plat_kendaraan }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            Vehicle
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Engine:</span>
                                            <span class="text-sm font-medium">{{ $kendaraan->cc_kendaraan }} CC</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Total Bookings:</span>
                                            <span class="text-sm font-medium">{{ $kendaraan->bookingServices()->count() }}</span>
                                        </div>
                                    </div>

                                    <div class="flex space-x-2">
                                        <!-- Fix: Gunakan id_plat_kendaraan -->
                                        <a href="{{ route('platkendaraan.edit', $kendaraan->id_plat_kendaraan) }}" class="flex-1 text-center px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                            Edit
                                        </a>
                                        <form action="{{ route('platkendaraan.destroy', $kendaraan->id_plat_kendaraan) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-3 py-2 text-sm bg-red-200 text-red-700 rounded hover:bg-red-300" onclick="return confirm('Are you sure?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m11 0v-4a2 2 0 00-2-2h-4m-2 0h-4a2 2 0 00-2 2v4m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No vehicles</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding your first vehicle.</p>
                            <div class="mt-6">
                                <a href="{{ route('platkendaraan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Add Vehicle
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>