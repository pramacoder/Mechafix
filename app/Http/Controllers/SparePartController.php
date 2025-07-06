<?php

namespace App\Http\Controllers;
use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    

    public function index()
    {
        $query = request('q');
        $spareParts = SparePart::when($query, function($q) use ($query) {
            $q->where('nama_barang', 'like', '%' . $query . '%');
        })->get();
        return view('konsumen.part_shop', compact('spareParts'));
    }
}