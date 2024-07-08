<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/produk', [ProdukController::class, 'index']);
    Route::post('/admin/produk/store', [ProdukController::class, 'store']);
    Route::get('/admin/produk/{id}', [ProdukController::class, 'show']);
    Route::put('/admin/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy']);
});