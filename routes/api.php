<?php

use App\Http\Controllers\DeviceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'devices'], function () {
        Route::get('/', [DeviceController::class, 'index']);
        Route::get('/{device}', [DeviceController::class, 'show']);
        Route::post('/', [DeviceController::class, 'store']);
        Route::put('/{device}', [DeviceController::class, 'update']);
        Route::delete('/{device}', [DeviceController::class, 'destroy']);
    });
});
