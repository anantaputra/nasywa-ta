<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\Api\RajaOngkirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\User\AlamatController;
use App\Http\Controllers\User\ProfilController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('produk', [ProdukController::class, 'index'])->name('produk');
Route::get('kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('pesan-kirim', [KontakController::class, 'simpan'])->name('pesan.kirim');
Route::get('google', [GoogleController::class, 'login'])->name('google');

Route::middleware('auth')->group(function(){
    Route::prefix('user')->name('user')->group(function(){
        Route::prefix('profil')->name('.profil')->group(function(){
            Route::get('/', [ProfilController::class, 'index']);
            Route::post('simpan', [ProfilController::class, 'simpan'])->name('.simpan');
            Route::post('foto', [ProfilController::class, 'foto'])->name('.foto');
        });
        Route::prefix('alamat')->name('.alamat')->group(function(){
            Route::get('/', [AlamatController::class, 'index']);
            Route::post('simpan', [AlamatController::class, 'simpan'])->name('.simpan');
            Route::post('edit', [AlamatController::class, 'index'])->name('.edit');
            Route::post('update', [AlamatController::class, 'update'])->name('.update');
            Route::get('{id}/hapus', [AlamatController::class, 'hapus'])->name('.hapus');
            Route::get('{id}/utama', [AlamatController::class, 'utama'])->name('.set.utama');
            Route::get('hapus/edit', [AlamatController::class, 'var_edit'])->name('.var.edit');
            Route::post('ganti', [AlamatController::class, 'ganti_alamat'])->name('.ganti');
            Route::get('provinsi', [RajaOngkirController::class, 'semua_provinsi'])->name('.provinsi');
            Route::get('kota', [RajaOngkirController::class, 'kota'])->name('.kota');
        });
        Route::prefix('password')->name('.password')->group(function(){
            Route::get('/');
        });
        Route::prefix('tagihan')->name('.tagihan')->group(function(){
            Route::get('/');
        });
        Route::prefix('riwayat')->name('.riwayat')->group(function(){
            Route::get('/');
        });
        Route::prefix('retur')->name('.retur')->group(function(){
            Route::get('/');
        });
    });
    Route::prefix('keranjang')->name('keranjang')->group(function(){
        Route::get('/', [KeranjangController::class, 'index']);
        Route::post('tambah', [KeranjangController::class, 'tambah'])->name('.tambah');
        Route::get('checkout', [KeranjangController::class, 'checkout'])->name('.checkout');
    });
    Route::prefix('pesan')->name('pesan')->group(function(){
        Route::post('/', [PesananController::class, 'pesan'])->name('.sekarang');
        Route::post('buat', [PesananController::class, 'pesan'])->name('.buat');
    });
    Route::prefix('checkout')->name('checkout')->group(function(){
        Route::get('{id}', [CheckoutController::class, 'checkout']);
        Route::get('keranjang', [CheckoutController::class, 'keranjang'])->name('.keranjang');
    });
});

Route::prefix('admin')->name('admin')->middleware('auth')->group(function(){
    Route::get('/', [AdminHomeController::class, 'index']);
    Route::prefix('kategori')->name('.kategori')->group(function(){
        Route::get('/', [AdminKategoriController::class, 'index']);
        Route::get('tambah', [AdminKategoriController::class, 'tambah'])->name('.tambah');
        Route::post('tambah', [AdminKategoriController::class, 'simpan'])->name('.simpan');
        Route::get('ubah/{id}', [AdminKategoriController::class, 'ubah'])->name('.ubah');
        Route::get('hapus/{id}', [AdminKategoriController::class, 'hapus'])->name('.hapus');
    });
    Route::prefix('produk')->name('.produk')->group(function(){
        Route::get('/', [AdminProdukController::class, 'index']);
        Route::get('tambah', [AdminProdukController::class, 'tambah'])->name('.tambah');
        Route::get('ubah/{id}', [AdminProdukController::class, 'ubah'])->name('.ubah');
        Route::get('hapus/{id}', [AdminProdukController::class, 'hapus'])->name('.hapus');
        Route::post('simpan', [AdminProdukController::class, 'simpan'])->name('.simpan');
        Route::post('edit', [AdminProdukController::class, 'edit'])->name('.edit');
    });
    Route::prefix('inbox')->name('.inbox')->group(function(){
        Route::get('/');
    });
    Route::prefix('pesanan')->name('.pesanan')->group(function(){
        Route::get('/');
    });
    Route::prefix('transaksi')->name('.transaksi')->group(function(){
        Route::get('/');
    });
    Route::prefix('retur')->name('.retur')->group(function(){
        Route::get('/');
    });
    Route::prefix('laporan')->name('.laporan')->group(function(){
        Route::prefix('pesanan')->name('.pesanan')->group(function(){
            Route::get('/');
        });
        Route::prefix('transaksi')->name('.transaksi')->group(function(){
            Route::get('/');
        });
        Route::prefix('retur')->name('.retur')->group(function(){
            Route::get('/');
        });
    });
});

require __DIR__.'/auth.php';
