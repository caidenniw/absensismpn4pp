<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/siswa', [AdminController::class, 'showSiswa'])->name('siswa.index');
        Route::get('/siswa/{id}', [AdminController::class, 'showSiswaByClass'])->name('siswa.byclass');
        Route::get('/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('siswa.edit');
        Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
        Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('kelas.store');
        Route::post('/matapelajaran', [AdminController::class, 'storeMataPelajaran'])->name('matapelajaran.store');
        Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');
        Route::get('/guru', [AdminController::class, 'indexGuru'])->name('guru.index');
        Route::get('/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('guru.edit');
        Route::put('/guru/{id}', [AdminController::class, 'updateGuru'])->name('guru.update');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::delete('/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('kelas.destroy');
        Route::delete('/matapelajaran/{id}', [AdminController::class, 'destroyMataPelajaran'])->name('matapelajaran.destroy');
        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('siswa.destroy');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'index'])->name('dashboard');
        Route::get('/absensi', [GuruController::class, 'showAbsensi'])->name('absensi.show');
        Route::post('/absensi', [GuruController::class, 'storeAbsensi'])->name('absensi.store');
        Route::get('/profile', [GuruController::class, 'showProfile'])->name('profile');
        Route::put('/profile', [GuruController::class, 'updateProfile'])->name('profile.update');
    });

    Route::get('/pdf/absensi', [PdfController::class, 'generatePdf'])->name('pdf.absensi');
});
