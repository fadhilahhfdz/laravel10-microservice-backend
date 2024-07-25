<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();

        return response()->json($supplier);
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
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nama_barang' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
            ]);

            $supplier = new Supplier;
            $supplier->nama = $request->nama;
            $supplier->nama_barang = $request->nama_barang;
            $supplier->harga = $request->harga;
            $supplier->save();

            return response()->json($supplier, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $supplier = Supplier::findOrFail($id);

            $request->validate([
                'nama' => 'required|string|max:255',
                'nama_barang' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
            ]);

            $supplier->update($request->all());

            return response()->json($supplier);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['message' => 'Berhasil menghapus data']);
    }
}
