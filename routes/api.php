<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'auth', 'cekrole:admin'])->group(function () {
    Route::get('/admin/barang', [BarangController::class, 'index']);
    Route::post('/admin/barang/store', [BarangController::class, 'store']);
    Route::get('/admin/barang/{id}', [BarangController::class, 'show']);
    Route::put('/admin/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/admin/barang/{id}', [BarangController::class, 'destroy']);

    Route::get('/admin/kategori', [KategoriController::class, 'index']);
    Route::post('/admin/kategori/store', [KategoriController::class, 'store']);
    Route::get('/admin/kategori/{id}', [KategoriController::class, 'show']);
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy']);

    Route::get('/admin/satuan', [SatuanController::class, 'index']);
    Route::post('/admin/satuan/store', [SatuanController::class, 'store']);
    Route::get('/admin/satuan/{id}', [SatuanController::class, 'show']);
    Route::put('/admin/satuan/{id}', [SatuanController::class, 'update']);
    Route::delete('/admin/satuan/{id}', [SatuanController::class, 'destroy']);

    Route::get('/admin/user', [UserController::class, 'index']);
    Route::post('/admin/user/store', [UserController::class, 'store']);
    Route::get('/admin/user/{id}', [UserController::class, 'show']);
    Route::put('/admin/user/{id}', [UserController::class, 'update']);
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy']);

    Route::get('/admin/supplier', [SupplierController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'auth', 'cekrole:supplier'])->group(function () {
    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::post('/supplier/store', [SupplierController::class, 'store']);
    Route::get('/supplier/{id}', [SupplierController::class, 'show']);
    Route::put('/supplier/{id}', [SupplierController::class, 'update']);
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);
});