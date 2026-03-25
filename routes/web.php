<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeterReadingsController;
use App\Http\Controllers\MetersController;
use App\Models\MeterReadings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard' , [AdminController::class , 'index'])->name('dashboard.admin');


Route::get('/meter/create' , [MetersController::class , 'create'])->name('meter.create');
Route::post('/meter/store' , [MetersController::class , 'store'])->name('meter.store');


Route::get('/reading/create' , [MeterReadingsController::class , 'create'])->name('reading.create');
Route::post('/reading/store' , [MeterReadingsController::class , 'store'])->name('reading.store');







