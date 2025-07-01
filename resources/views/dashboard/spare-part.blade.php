@php
    $spareparts = \App\Models\SparePart::orderBy('nama_barang')->get();
    $maxShow = 12;
@endphp

<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Katalog Spare Part</h3>
    @if ($spareparts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($spareparts as $i => $sparepart)
                    <div class="border rounded-lg p-4 flex flex-col h-full {{ $i >= $maxShow ? 'sparepart-hidden hidden' : '' }}">
                    @if ($sparepart->gambar_barang)
                        <img src="{{ asset('storage/' . $sparepart->gambar_barang) }}" alt="{{ $sparepart->nama_barang }}"
                            class="w-full h-40 object-contain mb-3 rounded">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-gray-100 mb-3 rounded text-gray-400">
                            <span class="text-4xl">🛠️</span>
                        </div>
                    @endif
                    <div class="mb-2">
                        <span class="text-base font-bold text-green-800">{{ $sparepart->nama_barang }}</span>
                    </div>
                    <div class="text-sm text-gray-600 mb-1">
                        Kode: <span class="font-mono">{{ $sparepart->deskripsi_barang }}</span>
                    </div>
                    <div class="text-sm text-gray-600 mb-1">
                        Stok: <span class="font-semibold">{{ $sparepart->kuantitas_barang }}</span>
                    </div>
                    <div class="mt-auto text-lg font-semibold text-green-700">
                        Rp {{ number_format($sparepart->harga_barang, 0, ',', '.') }}
                    </div>
                    <div class="flex justify mt-2">
                        <a href="{{ $sparepart->link_shopee }}" target="_blank"
                            class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded transition font-semibold shadow-sm flex items-center gap-1">
                            Check it out on Shopee
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($spareparts->count() > $maxShow)
            <div class="flex justify-center mt-6">
                <button id="toggleSparepartBtn"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded font-semibold shadow text-sm transition"
                    onclick="toggleSparepartList()">
                    View all ({{ $spareparts->count() }})
                </button>
            </div>
            <script>
                let showAllSparepart = false;

                function toggleSparepartList() {
                    showAllSparepart = !showAllSparepart;
                    document.querySelectorAll('.sparepart-hidden').forEach(el => {
                        el.classList.toggle('hidden', !showAllSparepart);
                    });
                    document.getElementById('toggleSparepartBtn').textContent = showAllSparepart ?
                        'Show less' :
                        'View all ({{ $spareparts->count() }})';
                }
            </script>
        @endif
    @else
        <div class="text-gray-500 text-center py-8">
            Tidak ada data spare part.
        </div>
    @endif
</div>