<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkirController;

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

Route::get('/', [ParkirController::class, 'index'])->name('main');
//transaksi masuk keluar
Route::get('masukParkir', [ParkirController::class, 'masukParkir'])->name('masukParkir');
Route::get('keluarParkir', [ParkirController::class, 'keluarParkir'])->name('keluarParkir');
Route::post('prosesMasukPakir', [ParkirController::class, 'prosesMasukParkir'])->name('prosesMasukParkir');
Route::post('prosesKeluarPakir', [ParkirController::class, 'prosesKeluarParkir'])->name('prosesKeluarParkir');
//laporan
Route::get('menuLaporan', [ParkirController::class, 'menuLaporan'])->name('menuLaporan');
Route::get('kendaraanDiLokasi', [ParkirController::class, 'kendaraanDiLokasi'])->name('kendaraanDiLokasi');
Route::post('resultKendaraanDiLokasi', [ParkirController::class, 'resultKendaraanDiLokasi'])->name('resultKendaraanDiLokasi');
Route::get('kendaraanMasukKeluar', [ParkirController::class, 'kendaraanMasukKeluar'])->name('kendaraanMasukKeluar');
Route::post('resultKendaraanMasukKeluar', [ParkirController::class, 'resultKendaraanMasukKeluar'])->name('resultKendaraanMasukKeluar');
Route::get('pendapatan', [ParkirController::class, 'pendapatan'])->name('pendapatan');
Route::post('resultPendapatan', [ParkirController::class, 'resultPendapatan'])->name('resultPendapatan');
//pengaturan
Route::get('menuPengaturan', [ParkirController::class, 'menuPengaturan'])->name('menuPengaturan');
Route::get('configKendaraan', [ParkirController::class, 'configKendaraan'])->name('configKendaraan');
Route::get('formConfigKendaraan/{configId}', [ParkirController::class, 'formConfigKendaraan'])->name('formConfigKendaraan');
Route::post('prosesConfigKendaraan', [ParkirController::class, 'prosesConfigKendaraan'])->name('prosesConfigKendaraan');
Route::get('configMinMenit', [ParkirController::class, 'configMinMenit'])->name('configMinMenit');
Route::get('formConfigMinMenit/{configId}', [ParkirController::class, 'formConfigMinMenit'])->name('formConfigMinMenit');
Route::post('prosesConfigMinMenit', [ParkirController::class, 'prosesConfigMinMenit'])->name('prosesConfigMinMenit');