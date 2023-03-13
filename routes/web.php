<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login_post');
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['login'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('shop', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('shop/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::get('shop/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
    Route::post('shop/update', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::delete('shop/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');

    Route::get('item', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::post('item/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::get('item/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('item/update', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::delete('item/delete', [App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
});