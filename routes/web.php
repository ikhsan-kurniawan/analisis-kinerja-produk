<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
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

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [ProfileController::class, 'update'])->name('profil.update');

    Route::get('password/edit', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('password/update', [PasswordController::class, 'update'])->name('password.ubah');

    Route::get('logout', LogoutController::class)->name('logout');

    Route::redirect('/', 'dashboard');
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');

    Route::prefix('asset')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('asset.index');
        Route::get('/create', [AssetController::class, 'create'])->name('asset.create');
        Route::post('/', [AssetController::class, 'store'])->name('asset.store');
        Route::get('/{id}/edit', [AssetController::class, 'edit'])->name('asset.edit');
        Route::put('/{id}', [AssetController::class, 'update'])->name('asset.update');
        Route::delete('/{id}', [AssetController::class, 'destroy'])->name('asset.destroy');
    });


    Route::get('analisis', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::get('analisis/hitung/{bulan}/{tahun}', [AnalisisController::class, 'hitung'])->name('analisis.hitung');
    // Route::get('analisis/hitung', [AnalisisController::class, 'hitung'])->name('analisis.hitung');
    Route::get('analisis/load-data', [AnalisisController::class, 'loadData']);

    Route::post('hasil', [HasilController::class, 'store'])->name('hasil.store');
    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');
    Route::delete('hasil/{id}', [HasilController::class, 'destroy'])->name('hasil.destroy');
});
Route::get('test', TestController::class);
