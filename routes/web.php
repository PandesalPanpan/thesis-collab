<?php

use App\Livewire\ListEquipments;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('admin/login', function () {
    return redirect('app');
})->name('filament.admin.auth.login');

Route::get('moderator/login', function () {
    return redirect('app');
})->name('filament.moderator.auth.login');

Route::get('', ListEquipments::class);

Route::get('barcodeview/{barcode}', function ($slug) {
    dd($slug);
    // return view('barcode', ['barcode' => $slug]);
})->name('barcode');

//Route::post('/', 'App\Http\Controllers\EquipmentController@index');
//Route::post('/broadcast', 'App\Http\Controllers\EquipmentController@broadcast');
//Route::post('/receive', 'App\Http\Controllers\EquipmentController@receive');

// Mozo, dito rin ung url ng api tas tatawagin ung controller
