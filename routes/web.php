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
    return redirect('/');
})->name('filament.admin.auth.login');

Route::get('moderator/login', function () {
    return redirect('/');
})->name('filament.moderator.auth.login');

Route::get('equipments', ListEquipments::class);