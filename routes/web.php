<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\AlternatifKriteriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::resource('kriteria', KriteriaController::class);
Route::resource('sub_kriteria', SubKriteriaController::class);
Route::resource('alternatif', AlternatifController::class);
Route::resource('alternatif_kriteria', AlternatifKriteriaController::class);
Route::get('/perhitungan', [PerhitunganController::class, 'index']);
