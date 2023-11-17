<?php

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


Route::get('/device/{id}', [\App\Http\API\DeviceController::class, 'show']);

Route::get('/devices', [\App\Http\API\DeviceController::class, 'index']);

Route::post('/device', [\App\Http\API\DeviceController::class, 'create']);
Route::put('/device/{id}', [\App\Http\API\DeviceController::class, 'update']);


Route::delete('/device/{id}', [\App\Http\API\DeviceController::class, 'destroy']);

Route::post('/device/{id}/status', [\App\Http\API\DeviceLastStatusController::class, 'updateOrCreate']);

