<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return response()->json($user);
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
        $cek = User::count();

        if ($cek == 0) {
            $urut = 10001;
            $kode = 'SN' . $tahun_bulan . $urut;
        } else {
            $ambil = User::all()->last();
            $urut = (int)substr($ambil->kode, -5) + 1;
            $kode = 'SN' . $tahun_bulan . $urut;
        }
        
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'role' => 'required|in:admin,supplier',
            ]);

            $user = User::create([
                'kode' => $kode,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json($user, 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($request->password == null) {
                $user->nama = $request->nama;
                $user->email = $request->email;
                $user->update();

            } else {
                $user->nama = $request->nama;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->update();
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Berhasil menghapus data']);
    }
}
