<?php

use App\Http\Controllers\WhatsAppController;
use Illuminate\Foundation\Mix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Send from mikrotik
Route::get('/send-from-mikrotik', [WhatsAppController::class, 'sendFromMikrotik']);
