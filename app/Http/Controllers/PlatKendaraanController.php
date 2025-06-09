<?php

namespace App\Http\Controllers;

use App\Models\PlatKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatKendaraanController extends Controller
{
    public function index()
    {
        $platkendaraan = PlatKendaraan::where('id_konsumen', Auth::user()->konsumen->id_konsumen)->get();

        return view('platkendaraan.index', compact('platkendaraan'));
    }

    public function create()
    {
        return view('platkendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_plat_kendaraan' => 'required|string|max:15|unique:plat_kendaraans,nomor_plat_kendaraan',
            'cc_kendaraan' => 'required|integer|min:50|max:10000',
        ]);

        $kendaraan = PlatKendaraan::create([
            'nomor_plat_kendaraan' => strtoupper($request->nomor_plat_kendaraan),
            'cc_kendaraan' => $request->cc_kendaraan,
            'id_konsumen' => Auth::user()->konsumen->id_konsumen,
        ]);

        return redirect()->route('platkendaraan.index')->with('success', 'Plat kendaraan added successfully!');
    }

    public function edit($id_plat_kendaraan)
    {
        $kendaraan = PlatKendaraan::findOrFail($id_plat_kendaraan);
        
        // Check if kendaraan belongs to current user
        if ($kendaraan->id_konsumen !== Auth::user()->konsumen->id_konsumen) {
            abort(403);
        }

        return view('platkendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $id_plat_kendaraan)
    {
        $kendaraan = PlatKendaraan::findOrFail($id_plat_kendaraan);
        
        // Check ownership
        if ($kendaraan->id_konsumen !== Auth::user()->konsumen->id_konsumen) {
            abort(403);
        }

        $request->validate([
            'nomor_plat_kendaraan' => 'required|string|max:15|unique:plat_kendaraans,nomor_plat_kendaraan,' . $kendaraan->id_plat_kendaraan . ',id_plat_kendaraan',
            'cc_kendaraan' => 'required|integer|min:50|max:10000',
        ]);

        $kendaraan->update([
            'nomor_plat_kendaraan' => strtoupper($request->nomor_plat_kendaraan),
            'cc_kendaraan' => $request->cc_kendaraan,
        ]);

        return redirect()->route('platkendaraan.index')->with('success', 'Kendaraan updated successfully!');
    }

    public function destroy($id_plat_kendaraan)
    {
        $kendaraan = PlatKendaraan::findOrFail($id_plat_kendaraan);
        
        // Check ownership
        if ($kendaraan->id_konsumen !== Auth::user()->konsumen->id_konsumen) {
            abort(403);
        }

        // Check if kendaraan has active bookings
        if ($kendaraan->bookingServices()->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])->exists()) {
            return back()->with('error', 'Cannot delete kendaraan with active bookings.');
        }

        $kendaraan->delete();

        return redirect()->route('platkendaraan.index')->with('success', 'Kendaraan removed successfully!');
    }
}