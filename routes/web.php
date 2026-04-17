<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MeterReadingsController;
use App\Http\Controllers\MetersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\UserController;
use App\Models\MeterReadings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');



Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('admin/dashboard', [DashboardsController::class, 'admin'])->name('dashboard.admin');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/show/{id}', [UserController::class, 'showUser'])->name('user.show');
        Route::get('/users/edit/{id}', [UserController::class, 'editUser'])->name('user.edit');
        Route::put('/users/update/{id}', [UserController::class, 'updateProfile'])->name('user.update');





        // Route::get('/readings', [MeterReadingsController::class, 'index'])->name('readings');
        // Route::get('/reading/create', [MeterReadingsController::class, 'create'])->name('reading.create');
        // Route::post('/reading/store', [MeterReadingsController::class, 'store'])->name('reading.store');
        // Route::get('/reading/show/{reading}', [InvoiceController::class, 'show'])->name('reading.show');



        // Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        // Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        // Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
        // Route::get('/invoices/show/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    });

    // collector 
    Route::middleware(['collector'])->group(function () {
        Route::get('collector/dashboard', [DashboardsController::class, 'collector'])->name('dashboard.collector');
    });

    /// collector and admin 
    Route::middleware(['role:collector,admin'])->group(function () {

        Route::get('/readings', [MeterReadingsController::class, 'index'])->name('readings');
        Route::get('/reading/create', [MeterReadingsController::class, 'create'])->name('reading.create');
        Route::post('/reading/store', [MeterReadingsController::class, 'store'])->name('reading.store');
        Route::get('/reading/show/{reading}', [MeterReadingsController::class, 'show'])->name('reading.show');

        Route::get('/meters', [MetersController::class, 'index'])->name('meters');
        Route::get('/meter/create', [MetersController::class, 'create'])->name('meter.create');
        Route::post('/meter/store', [MetersController::class, 'store'])->name('meter.store');
        Route::get('/meter/show/{id}', [MetersController::class, 'show'])->name('meter.show');
        Route::get('/meter/edit/{id}', [MetersController::class, 'edit'])->name('meter.edit');
        Route::put('/meter/update/{id}', [MetersController::class, 'update'])->name('meter.update');


        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/invoices/show/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/show/{id}', [PaymentController::class, 'show'])->name('payments.show');
    });

    /// repair agent 

    Route::middleware(['role:repair_agent,admin'])->group(function () {
        Route::get('repair_agent/dashboard', [DashboardsController::class, 'repair_agent'])->name('dashboard.repair_agent');
        Route::get('repairs', [RepairController::class, 'index'])->name('repairs');
        Route::get('repairs/create', [RepairController::class, 'create'])->name('repairs.create');
        Route::post('repairs/store', [RepairController::class, 'store'])->name('repairs.store');
        Route::get('repairs/show', [RepairController::class, 'show'])->name('repairs.show');
    });

    // villager
    // Route::middleware()
    Route::middleware(['role:villager,admin,collector'])->group(function () {
        Route::get('villager/dashboard', [DashboardsController::class, 'villager'])->name('dashboard.villager');

        Route::get('/readings', [MeterReadingsController::class, 'index'])->name('readings');
        Route::get('/reading/show/{reading}', [MeterReadingsController::class, 'show'])->name('reading.show');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/show/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        Route::get('/payments/show/{id}', [PaymentController::class, 'show'])->name('payments.show');
    });
});
