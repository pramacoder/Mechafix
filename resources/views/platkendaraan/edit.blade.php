<x-layoutkonsumen>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black leading-tight">
            {{ __('Edit Vehicle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-black/10 shadow-xl rounded-2xl">
                <div class="p-8">
                    <form method="POST" action="{{ route('platkendaraan.update', $kendaraan) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Plat Nomor -->
                            <div>
                                <label for="nomor_plat_kendaraan" class="block text-sm font-semibold text-gray-700 mb-2">License Plate Number</label>
                                <input id="nomor_plat_kendaraan" class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white" type="text" name="nomor_plat_kendaraan" value="{{ old('nomor_plat_kendaraan', $kendaraan->nomor_plat_kendaraan) }}" required autofocus />
                                @error('nomor_plat_kendaraan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CC Kendaraan -->
                            <div>
                                <label for="cc_kendaraan" class="block text-sm font-semibold text-gray-700 mb-2">Engine Capacity (CC)</label>
                                <input id="cc_kendaraan" class="block w-full px-4 py-3 border border-black/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition duration-200 text-black bg-white" type="number" name="cc_kendaraan" value="{{ old('cc_kendaraan', $kendaraan->cc_kendaraan) }}" min="50" max="10000" required />
                                @error('cc_kendaraan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('platkendaraan.index') }}" class="inline-flex items-center px-5 py-2 bg-black text-white rounded-lg font-semibold text-sm shadow hover:bg-gray-800 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold text-sm shadow hover:bg-orange-600 transition-all duration-200">
                                {{ __('Update Vehicle') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layoutkonsumen>