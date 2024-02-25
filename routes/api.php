<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\EquipmentController;

// By mozo
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/check-permission', [EquipmentController::class, 'checkPermission']);
Route::get('/check-permission', 'App\Http\Controllers\EquipmentController@checkPermission');
