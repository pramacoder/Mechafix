<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SparePartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of spare parts for konsumen
     */
    public function index()
    {
        try {
            // Ambil spare parts yang tersedia (sesuai dengan struktur model)
            $spareParts = SparePart::where('kuantitas_barang', '>', 0)
                ->orderBy('nama_barang', 'asc')
                ->get();

            return view('konsumen.part_shop', compact('spareParts'));

        } catch (\Exception $e) {
            \Log::error('Error in SparePartController@index:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('konsumen.home')->with('error', 'Terjadi kesalahan saat memuat halaman spare parts');
        }
    }

    /**
     * Show spare part details
     */
    public function show($id)
    {
        try {
            $sparePart = SparePart::where('id_barang', $id)->firstOrFail();
            
            return view('konsumen.part_detail', compact('sparePart'));

        } catch (\Exception $e) {
            \Log::error('Error in SparePartController@show:', [
                'error' => $e->getMessage(),
                'spare_part_id' => $id,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('konsumen.part_shop')->with('error', 'Spare part tidak ditemukan');
        }
    }

    /**
     * Search spare parts
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            
            $spareParts = SparePart::where('kuantitas_barang', '>', 0)
                ->where(function($q) use ($query) {
                    $q->where('nama_barang', 'LIKE', "%{$query}%")
                      ->orWhere('deskripsi_barang', 'LIKE', "%{$query}%");
                })
                ->orderBy('nama_barang', 'asc')
                ->get();

            return view('konsumen.part_shop', compact('spareParts', 'query'));

        } catch (\Exception $e) {
            \Log::error('Error in SparePartController@search:', [
                'error' => $e->getMessage(),
                'query' => $request->get('q'),
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('konsumen.part_shop')->with('error', 'Terjadi kesalahan saat mencari spare parts');
        }
    }

    /**
     * Get all spare parts for API or AJAX
     */
    public function getAllSpareParts()
    {
        try {
            $spareParts = SparePart::where('kuantitas_barang', '>', 0)
                ->select('id_barang', 'nama_barang', 'deskripsi_barang', 'harga_barang', 'kuantitas_barang', 'gambar_barang')
                ->orderBy('nama_barang', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $spareParts
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in SparePartController@getAllSpareParts:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data spare parts'
            ], 500);
        }
    }
}