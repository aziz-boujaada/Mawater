<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MeterReadingsController;
use App\Http\Controllers\MetersController;
use App\Models\MeterReadings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


    Route::get('/meters', [MetersController::class, 'index'])->name('meters');
    Route::get('/meter/create', [MetersController::class, 'create'])->name('meter.create');
    Route::post('/meter/store', [MetersController::class, 'store'])->name('meter.store');

    Route::get('/readings', [MeterReadingsController::class, 'index'])->name('readings');
    Route::get('/reading/create', [MeterReadingsController::class, 'create'])->name('reading.create');
    Route::post('/reading/store', [MeterReadingsController::class, 'store'])->name('reading.store');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/show/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
});

/// repair agent 
// Route::middleware(['collector'])->group(function () {
//     Route::get('/reading/create', [MeterReadingsController::class, 'create'])->name('reading.create');
//     Route::post('/reading/store', [MeterReadingsController::class, 'store'])->name('reading.store');

//     Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
//     Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
// });
