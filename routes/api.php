<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\EquipmentController;
use App\Http\Controllers\FingerPrintController;

// By mozo
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/check-permission', [EquipmentController::class, 'checkPermission']);
Route::get('/check-permission', 'App\Http\Controllers\EquipmentController@checkPermission');


Route::post('fingerprint', [FingerPrintController::class, 'index']);

Route::get('fingerprintData', [FingerPrintController::class, 'getData']);

Route::post('fingerprintReceived', [FingerPrintController::class, 'onReceived']);
