<?php

use App\Livewire\ListEquipments;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::get('', ListEquipments::class)
    ->name('public');

Route::get('barcodeview/{barcode}', function ($slug){
    return view('barcode',[
        'barcode' => $slug
    ]);
})->name('barcode');

// Call Artisan Storage link in the access
Route::get('create-symlink', function (){
    Artisan::call('storage:link');
    return response('Done...');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('moderator');
})->middleware(['auth', 'signed'])->name('verification.verify');