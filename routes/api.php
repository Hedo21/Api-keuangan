<?php

use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});;
Route::middleware('auth:sanctum')->put('/users/{id}', function (Request $request, $id) {
    return $request->user();
});;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::put('/profile', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('profil', [ProfilController::class, 'index']);
Route::post('profil', [ProfilController::class, 'create']);
Route::put('profil/{id}', [ProfilController::class, 'update']);
Route::delete('profil/{id}', [ProfilController::class, 'delete']);

Route::get('keuangan', [KeuanganController::class, 'index']);
Route::get('/index', [KeuanganController::class, 'index_relasi']);
Route::post('keuangan', [KeuanganController::class, 'create']);
Route::put('keuangan/{id}', [KeuanganController::class, 'update']);
