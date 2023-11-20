<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PreferencesController;
use App\Http\Controllers\HostnameController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Domain;

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

Route::middleware('auth', 'userPreferences')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::get('/', [DashboardController::class, 'listDomains'])->name('dashboard');
	Route::get('/preferences', [PreferencesController::class, 'edit'])->name('preferences.edit');
	Route::patch('/preferences', [PreferencesController::class, 'update'])->name('preferences.update');
	Route::get('/hostname/{domain}', [HostnameController::class, 'show'])->name('hostname.show');
	Route::get('/hostname', [HostnameController::class, 'add'])->name('hostname.add');
	Route::put('/hostname', [HostnameController::class, 'store'])->name('hostname.store');
});

require __DIR__.'/auth.php';
