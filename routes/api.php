<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [App\Http\Controllers\API\UserController::class, 'home']);
Route::get('/cari', [App\Http\Controllers\API\UserController::class, 'cari']);
Route::get('/toko', [App\Http\Controllers\API\UserController::class, 'toko']);

Route::post('/login', [App\Http\Controllers\API\AdminController::class, 'login']);
Route::post('/register', [App\Http\Controllers\API\AdminController::class, 'register']);
Route::post('/tambah_produk', [App\Http\Controllers\API\AdminController::class, 'tambah_produk']);
Route::post('/edit_produk', [App\Http\Controllers\API\AdminController::class, 'edit_produk']);