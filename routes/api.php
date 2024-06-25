<?php

use App\Http\Controllers\API\HukumController;
use App\Http\Controllers\API\JaksaController;
use App\Http\Controllers\API\KorupsiController;
use App\Http\Controllers\API\PengaduanPegawaiController;
use App\Http\Controllers\API\PoskoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PengawasanAliranKepercayaan;
use App\Models\jaksa_masuk_sekolah;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user',[UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::post('/register', [UserController::class, 'register']);


Route::get('/pengaduanpegawai',[PengaduanPegawaiController::class, 'index']);
Route::post('/pengaduanpegawai', [PengaduanPegawaiController::class, 'store']);
Route::post('/pengaduanpegawai/{id}', [PengaduanPegawaiController::class, 'update']);
Route::delete('/pengaduanpegawai/{pengaduan_pegawai}', [PengaduanPegawaiController::class, 'destroy']);

Route::get('/pengaduankorupsi',[KorupsiController::class, 'index']);
Route::post('/pengaduankorupsi', [KorupsiController::class, 'store']);
Route::post('/pengaduankorupsi/{id}', [KorupsiController::class, 'update']);
Route::delete('/pengaduankorupsi/{pengadua_tindak_pidana_korupsi}', [KorupsiController::class, 'destroy']);

Route::get('/jaksa',[JaksaController::class, 'index']);
Route::post('/jaksa', [JaksaController::class, 'store']);
Route::post('/jaksa/{id}', [JaksaController::class, 'update']);
Route::delete('/jaksa/{jaksa_masuk_sekolah}', [JaksaController::class, 'destroy']);

Route::get('/hukum',[HukumController::class, 'index']);
Route::post('/hukum', [HukumController::class, 'store']);
Route::post('/hukum/{id}', [HukumController::class, 'update']);
Route::delete('/hukum/{penyuluhan_hukum}', [HukumController::class, 'destroy']);

Route::get('/posko',[PoskoController::class, 'index']);
Route::post('/posko', [PoskoController::class, 'store']);
Route::post('/posko/{id}', [PoskoController::class, 'update']);
Route::delete('/posko/{posko_pilkada}', [PoskoController::class, 'destroy']);

Route::get('/aliran',[PengawasanAliranKepercayaan::class, 'index']);
Route::post('/aliran',[PengawasanAliranKepercayaan::class, 'store']);
Route::post('/aliran/{id}',[PengawasanAliranKepercayaan::class, 'update']);
Route::delete('/aliran/{aliranid}',[PengawasanAliranKepercayaan::class, 'destroy']);

Route::get('/posko',[PoskoController::class, 'index']);
Route::post('/posko',[PoskoController::class, 'store']);
Route::post('/posko/{id}',[PoskoController::class, 'update']);
Route::delete('/posko/{posko_pilkada}',[PoskoController::class, 'destroy']);

