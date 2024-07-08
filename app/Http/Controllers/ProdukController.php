<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();

        return response()->json($produk);
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
        $cek = Produk::count();

        if ($cek == 0) {
            $urut = 10001;
            $kode = 'GNS' . $tahun_bulan . $urut;
        } else {
            $ambil = Produk::all()->last();
            $urut = (int)substr($ambil->kode, -5) + 1;
            $kode = 'GNS' . $tahun_bulan . $urut;
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $produk = Produk::create([
            'kode' => $kode,
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return response()->json($produk, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $produk->update($request->all());

        return response()->json($produk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return response()->json(['message' => 'Berhasil menghapus produk']);
    }
}
