<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Absen\UserController;
use App\Http\Controllers\Absen\AbsenController;


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


Route::get("/register", [UserController::class, 'register'])->name('user.register');
Route::get("/", [UserController::class, 'index'])->name('user.login');
Route::post("/register", [UserController::class, 'store'])->name('user.register.store');
Route::post("/", [UserController::class, 'auth'])->name('user.login.auth');
Route::get("/dashboard", [AbsenController::class, 'dashboard'])->name('user.dashboard')->middleware('auth');
Route::post("/absen_masuk", [AbsenController::class, 'process_absen_masuk'])->name('user.absen.process_masuk')->middleware('auth');
Route::post("/absen_keluar", [AbsenController::class, 'process_absen_pulang'])->name('user.absen.process_pulang')->middleware('auth');
Route::get("/absen_masuk", [AbsenController::class, 'view_absen_masuk'])->name('user.absen.masuk')->middleware('auth');
Route::get("/absen_pulang", [AbsenController::class, 'view_absen_pulang'])->name('user.absen.pulang')->middleware('auth');
Route::get("/logout", [UserController::class, 'logout'])->name('user.logout');
Route::get("/grafik", [AbsenController::class, 'grafik'])->name('user.grafik')->middleware('auth');
