<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\LogController;

// Route::get('/', function () {
//     return view('home');
// })->middleware(['auth', 'verified']);

// Route::get('/dashboard', function () {
//     return view('home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->withoutMiddleware('role:admin');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->withoutMiddleware('role:admin');

    Route::resource('users', UserController::class);
    Route::resource('mikrotiks', MikrotikController::class);
    Route::get('/', [
        VoucherController::class,
        'resetVoucherForm'
    ])->name('home')->withoutMiddleware('role:admin');
    Route::get('/dashboard', [
        VoucherController::class,
        'resetVoucherForm'
    ])->name('dashboard')->withoutMiddleware('role:admin');
    Route::get('/resetvoucher', [VoucherController::class, 'resetVoucherForm'])->name('index.reset')->withoutMiddleware('role:admin');
    Route::post('/resetvoucher', [VoucherController::class, 'resetVoucher'])->name('vouchers.reset')->withoutMiddleware('role:admin');
    Route::post('/vouchers/toggle', [VoucherController::class, 'toggleVoucher'])->name('vouchers.toggle')->withoutMiddleware('role:admin');

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

require __DIR__ . '/auth.php';

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
