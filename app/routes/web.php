<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PreferencesController;
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

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::get('/', function () {
		return view('dashboard');
	})->name('dashboard');
	Route::get('/preferences', [PreferencesController::class, 'edit'])->name('preferences.edit');
	Route::patch('/preferences', [PreferencesController::class, 'update'])->name('preferences.update');
});

require __DIR__.'/auth.php';
