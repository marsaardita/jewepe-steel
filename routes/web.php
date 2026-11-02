<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['checklogin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/master/kategori', [CategoryController::class, 'index']);
    Route::get('/master/barang', [BarangController::class, 'index']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    
    // CRUD Pengguna
    Route::get('/master/pengguna', [UserController::class, 'index']);
    Route::post('/master/pengguna', [UserController::class, 'store']);
    Route::put('/master/pengguna/{id}', [UserController::class, 'update']);
    Route::delete('/master/pengguna/{id}', [UserController::class, 'destroy']);
});