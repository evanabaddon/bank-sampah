<?php

use App\Http\Controllers\KategoriLayananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\NeracaKeuanganController;
use App\Http\Controllers\PengepulController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TransaksiBankController;
use App\Http\Controllers\TransaksiPenarikanController;
use App\Http\Controllers\TransaksiPengeluaranController;
use App\Http\Controllers\TransaksiPenjualanController;
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
    if (Auth::check()) {
        $userAkses = Auth::user()->akses;

        if ($userAkses == 'admin') {
            return redirect()->route('admin.beranda');
        } elseif ($userAkses == 'operator' || $userAkses == 'outlet') {
            return redirect()->route('operator.beranda');
        }
    } else {
        return view('login');
    }
});


// redirect / to /login
Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', function () {
    if (Auth::check()) {
        $userAkses = Auth::user()->akses;
        
        if ($userAkses == 'admin') {
            return redirect()->route('admin.beranda');
        } elseif ($userAkses == 'operator' || $userAkses == 'outlet') {
            return redirect()->route('operator.beranda');
        }
    } else {
        return view('login');
    }
});

Route::prefix('nasabah')->middleware(['auth', 'auth.nasabah'])->group(function () {
    Route::get('beranda', 'BerandaNasabahController@index')->name('nasabah.beranda');
});


Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    Route::get('beranda', 'BerandaOperatorController@index')->name('operator.beranda');
    Route::resource('nasabah', NasabahController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('setting', SettingController::class);
    Route::get('nota/update-and-print/{tagihan_id}', 'NotaController@updateStatusAndPrint')->name('update.and.print.nota');
    // route bayar masal menggunakan notacontroller fungsi updateStatusMasal
    Route::post('/bayar-massal', 'NotaController@updateStatusMasal')->name('bayar-massal');
    Route::get('/buat-tagihan', 'TagihanController@buatTagihan')->name('buat-tagihan');
    // buat tagihan bulan ini
    Route::get('/buat-tagihan-bulan-ini', 'TagihanController@buatTagihanBulanIni')->name('buat-tagihan-bulan-ini');
    Route::resource('transaksi-penarikan', TransaksiPenarikanController::class);
    Route::get('transaksi-penarikan/create/{id_nasabah?}', 'TransaksiPenarikanController@create')->name('transaksi-penarikan.create');
    Route::resource('transaksi-bank', TransaksiBankController::class);
    Route::get('transaksi-bank/create/{id_nasabah?}', 'TransaksiBankController@create')->name('transaksi-bank.create');
    Route::get('validasi-qr/{kodenasabah}', 'BerandaOperatorController@validasiQr')->name('validasi-qr');
    Route::get('nasabah/cetak-kartu/{id}', 'NasabahController@cetakKartu')->name('nasabah.cetakKartu');
    Route::get('broadcast', 'TagihanController@broadcastWhatsapp')->name('broadcast');

});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('beranda', 'BerandaAdminController@index')->name('admin.beranda');
    Route::resource('user', UserController::class);
    Route::resource('jenis-sampah', JenisSampahController::class);
    Route::resource('pengepul', PengepulController::class);
    Route::resource('kategori-layanan', KategoriLayananController::class);
    Route::resource('transaksi-pengeluaran', TransaksiPengeluaranController::class);
    Route::resource('transaksi-penjualan', TransaksiPenjualanController::class);
    Route::resource('laporan', LaporanController::class);
    Route::get('laporan-tagihan', 'LaporanController@tagihan')->name('laporan.tagihan');
    Route::get('laporan-tagihan/cetak-pdf', 'LaporanController@cetakPdfTagihan')->name('laporan.tagihan.cetak-pdf');
    Route::get('laporan-outlet', 'LaporanController@outlet')->name('laporan.outlet');
    Route::get('laporan-outlet/cetak-pdf', 'LaporanController@cetakPdfOutlet')->name('laporan.outlet.cetak-pdf');
    Route::get('laporan-transaksi-bank', 'LaporanController@transaksiBank')->name('laporan.transaksi-bank');
    Route::get('laporan-transaksi-bank/cetak-pdf', 'LaporanController@cetakPdfTransaksiBank')->name('laporan.transaksi.bank.cetak-pdf');
    Route::get('laporan-transaksi-penjualan', 'LaporanController@transaksiPenjualan')->name('laporan.transaksi-penjualan');
    Route::get('laporan-transaksi-penjualan/cetak-pdf', 'LaporanController@cetakPdfTransaksiPenjualan')->name('laporan.transaksi.penjualan.cetak-pdf');
    Route::get('laporan-transaksi-penarikan', 'LaporanController@transaksiPenarikan')->name('laporan.transaksi-penarikan');
    Route::get('laporan-transaksi-penarikan/cetak-pdf', 'LaporanController@cetakPdfTransaksiPenarikan')->name('laporan.transaksi-penarikan.cetak-pdf');
    Route::get('laporan-stok', 'LaporanController@stokSampah')->name('laporan.stok');
    Route::get('laporan-stok/cetak-pdf', 'LaporanController@cetakPdfStokSampah')->name('laporan.stok.cetak-pdf');
    Route::get('nasabah/{id}/buat-pin', 'App\Http\Controllers\NasabahController@generateNewPin')->name('nasabah.buat-pin');
    Route::get('nasabah/{id}/kirim-pin', 'App\Http\Controllers\NasabahController@kirimPin')->name('nasabah.kirim-pin');
    Route::get('neraca-keuangan', [NeracaKeuanganController::class, 'index'])->name('neraca-keuangan.index');
    Route::get('neraca-keuangan/pdf', 'NeracaKeuanganController@generatePdf')->name('neraca-keuangan.pdf');
    Route::put('/tagihan/{id}/update-status', 'TagihanController@updateStatus')->name('update.status');
    Route::post('nasabah/import', 'NasabahController@import')->name('nasabah.import');
    Route::get('nasabah/export', 'NasabahController@export')->name('nasabah.export');
    Route::get('/broadcast', 'TagihanController@broadcastWhatsapp')->name('broadcast');
    Route::get('/queue-monitor', 'QueueMonitorController@index')->name('queue-monitor.index');

});

Route::get('nota/kirim-nota/{tagihan_id}', 'NotaController@kirimNota')->name('kirim.nota');
Route::get('nota/{tagihan_id}', 'NotaController@print')->name('print.nota');
Route::get('kwitansi/{tagihan_id}', 'NotaController@kwitansi')->name('kwitansi.nota');

Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
});


// route prefix untuk api
Route::get('api/login', 'App\Http\Controllers\Auth\LoginController@loginApi')->name('api.login');