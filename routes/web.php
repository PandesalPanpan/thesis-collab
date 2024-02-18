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
    return redirect('moderator'); // This used to be for App Panel
})->name('filament.admin.auth.login');

// Route::get('moderator/login', function () {
//     return redirect('app');
// })->name('filament.moderator.auth.login');

Route::get('', ListEquipments::class);

Route::get('barcodeview/{barcode}', function ($slug){
    return view('barcode',[
        'barcode' => $slug
    ]);
})->name('barcode');
