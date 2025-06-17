<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Vehicle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <form method="POST" action="{{ route('platkendaraan.update', $kendaraan) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Plat Nomor -->
                            <div>
                                <x-label for="nomor_plat_kendaraan" value="{{ __('License Plate Number') }}" />
                                <x-input id="nomor_plat_kendaraan" class="block mt-1 w-full" type="text" name="nomor_plat_kendaraan" :value="old('nomor_plat_kendaraan', $kendaraan->nomor_plat_kendaraan)" required autofocus />
                                @error('nomor_plat_kendaraan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CC Kendaraan -->
                            <div>
                                <x-label for="cc_kendaraan" value="{{ __('Engine Capacity (CC)') }}" />
                                <x-input id="cc_kendaraan" class="block mt-1 w-full" type="number" name="cc_kendaraan" :value="old('cc_kendaraan', $kendaraan->cc_kendaraan)" min="50" max="10000" required />
                                @error('cc_kendaraan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-2">
                            <a href="{{ route('platkendaraan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cancel
                            </a>
                            <x-button class="ml-3">
                                {{ __('Update Vehicle') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>