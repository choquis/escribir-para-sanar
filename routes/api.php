<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

Route::post('/paypal/order', [PayPalController::class, 'order'])->name('paypal.order');
Route::post('/paypal/order/{orderId}/capture', [PayPalController::class, 'capture'])->name('paypal.capture');

Route::post('/eventos/search', [EventController::class, 'search'])
    ->name('eventos.search');
Route::post('/correos/search', [EmailController::class, 'search'])
    ->name('correos.search');