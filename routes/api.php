<?php

use App\Http\Controllers\Api\NasaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/endpoint-test', [NasaController::class, 'getData']);

Route::get('/nasa/instruments', [NasaController::class, 'getInstruments']);
Route::get('/nasa/activities', [NasaController::class, 'getActivityIds']);
Route::get('/nasa/instruments/usage', [NasaController::class, 'getInstrumentUsage']);
Route::post('/nasa/instruments/usage', [NasaController::class, 'getInstrumentUsageByName']);
