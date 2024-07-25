<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        $supplier = Supplier::all();

        return response()->json([
            'message' => 'show all',
            'data' => [
                'barang' => $barang,
                'kategori' => $kategori,
                'satuan' => $satuan,
                'supplier' => $supplier,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sekarang = Carbon::now();
        $tahun_bulan = $sekarang->year . $sekarang->month;
        $cek = Barang::count();

        if ($cek == 0) {
            $urut = 10001;
            $kode = 'KD' . $tahun_bulan . $urut;
        } else {
            $ambil = Barang::all()->last();
            $urut = (int)substr($ambil->kode, -5) + 1;
            $kode = 'KD' . $tahun_bulan . $urut;
        }

        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'id_kategori' => 'required|exists:kategoris,id',
                'id_satuan' => 'required|exists:satuans,id',
                'id_supplier' => 'required|exists:suppliers,id',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
            ]);
    
            $barang = Barang::create([
                'kode' => $kode,
                'nama' => $request->nama,
                'gambar' => $request->gambar,
                'id_kategori' => $request->id_kategori,
                'id_satuan' => $request->id_satuan,
                'id_supplier' => $request->id_supplier,
                'harga' => $request->harga,
                'stok' => $request->stok,
            ]);
    
            return response()->json($barang, 201);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Barang::with('kategori', 'satuan', 'supplier')->find($id);
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        $supplier = Supplier::all();

        return response()->json([
            'message' => 'barang by id',
            'data' => [
                'barang' => $barang,
                'kategori' => $kategori,
                'satuan' => $satuan,
                'supplier' => $supplier,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $request->validate([
                'nama' => 'required|string|max:255',
                'id_kategori' => 'required|exists:kategoris,id',
                'id_satuan' => 'required|exists:satuans,id',
                'id_supplier' => 'required|exists:suppliers,id',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
            ]);

            $barang->update($request->all());

            return response()->json($barang);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Berhasil menghapus data']);
    }
}
