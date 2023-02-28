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

// user
Route::get('produk', [App\Http\Controllers\API\UserController::class, 'produk']);
Route::get('produk/{id}', [App\Http\Controllers\API\UserController::class, 'produk_detail']);

Route::get('toko', [App\Http\Controllers\API\UserController::class, 'toko']);
Route::get('toko/{id}', [App\Http\Controllers\API\UserController::class, 'toko_detail']);
Route::get('toko/{id}/produk', [App\Http\Controllers\API\UserController::class, 'toko_produk']);


// login dan register
Route::post('login', [App\Http\Controllers\API\AdminController::class, 'login']);
Route::post('register', [App\Http\Controllers\API\AdminController::class, 'register']);


// admin
Route::get('admin/produk', [App\Http\Controllers\API\AdminController::class, 'produk']);
Route::get('admin/produk/{id}', [App\Http\Controllers\API\AdminController::class, 'produk_detail']);
Route::post('admin/produk-tambah', [App\Http\Controllers\API\AdminController::class, 'produk_tambah']);
Route::post('admin/produk-edit', [App\Http\Controllers\API\AdminController::class, 'produk_edit']);
Route::post('admin/produk-hapus', [App\Http\Controllers\API\AdminController::class, 'produk_hapus']);

Route::get('admin/profil', [App\Http\Controllers\API\AdminController::class, 'profil']);
Route::post('admin/profil-edit', [App\Http\Controllers\API\AdminController::class, 'profil_edit']);