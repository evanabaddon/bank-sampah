<?php

use App\Http\Controllers\JenisLayananController;
use App\Http\Controllers\KategoriLayananController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TagihanController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    Route::get('beranda', 'BerandaOperatorController@index')->name('operator.beranda');
    Route::resource('user', UserController::class);
});


Route::prefix('nasabah')->middleware(['auth', 'auth.nasabah'])->group(function () {
    Route::get('beranda', 'BerandaNasabahController@index')->name('nasabah.beranda');
});


Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('beranda', 'BerandaOperatorController@index')->name('operator.beranda');
    Route::resource('user', UserController::class);
    Route::resource('nasabah', NasabahController::class);
    Route::resource('jenis-sampah', JenisSampahController::class);
    Route::resource('kategori-layanan', KategoriLayananController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('transaksi-bank', TransaksiBankController::class);
    Route::get('transaksi-bank/create/{id_nasabah?}', 'TransaksiBankController@create')->name('transaksi-bank.create');
    Route::get('nasabah/{id}/buat-pin', 'App\Http\Controllers\NasabahController@generateNewPin')->name('nasabah.buat-pin');
    Route::get('nasabah/{id}/kirim-pin', 'App\Http\Controllers\NasabahController@kirimPin')->name('nasabah.kirim-pin');
    Route::get('nota/{tagihan_id}', 'NotaController@print')->name('print.nota');
    Route::get('nota/update-and-print/{tagihan_id}', 'NotaController@updateStatusAndPrint')->name('update.and.print.nota');
    Route::get('nota/kirim-nota/{tagihan_id}', 'NotaController@kirimNota')->name('kirim.nota');

});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
});
