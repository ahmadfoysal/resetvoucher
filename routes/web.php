<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\LogController;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('users', UserController::class)->middleware(['auth', 'can:canManageUsers']);

    Route::resource('mikrotiks', MikrotikController::class)->middleware(['auth', 'can:canManageMikrotiks']);
    // Route::get('/', [
    //     VoucherController::class,
    //     'resetVoucherForm'
    // ])->name('home')->middleware('can:canManageResetVouchers');
    // Route::get('/dashboard', [
    //     VoucherController::class,
    //     'resetVoucherForm'
    // ])->name('dashboard')->withoutMiddleware('can:canManageResetVouchers');
    Route::get('/resetvoucher', [VoucherController::class, 'resetVoucherForm'])->name('index.reset')->middleware('can:canManageResetVouchers');
    Route::post('/resetvoucher', [VoucherController::class, 'resetVoucher'])->name('vouchers.reset')->middleware('can:canManageResetVouchers');
    Route::post('/vouchers/toggle', [VoucherController::class, 'toggleVoucher'])->name('vouchers.toggle')->middleware('can:canManageResetVouchers');
    Route::get('/hotspot-users/{mikrotik_id?}', [VoucherController::class, 'getHotspotUsers'])
        ->name('hotspot.users')
        ->middleware('can:canManageResetVouchers');



    Route::get('/logs', [LogController::class, 'index'])->name('logs.index')->middleware('can:canManageSystemLogs');

    Route::post('/users/{id}/loginAs', [UserController::class, 'loginAs'])->name('users.loginAs')
        ->middleware(['auth', 'role:superadmin']);

    Route::get('/switchBack', [UserController::class, 'switchBack'])->name('switchBack')
        ->middleware(['auth']);
});

require __DIR__ . '/auth.php';

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
