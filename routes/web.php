<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/inscribir', [HomeController::class, 'register'])->name('register');
Route::post('/inscribir', [HomeController::class, 'registerCreation'])->name('register');
Route::get('/inscribir/completado', [HomeController::class, 'registerComplete'])->name('register-complete');
Route::post('/suscribir', [HomeController::class, 'subscribe'])->name('subscribe');
Route::get('/suscribir/completado', [HomeController::class, 'subscribeComplete'])->name('subscribe-complete');

Route::prefix('admin')->group(function () {
    Route::get(
        '/',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    Route::post(
        '/autenticar',
        [LoginController::class, 'authenticate']
    )->name('authenticate');

    Route::post(
        '/salir',
        [LoginController::class, 'logout']
    )->name('logout');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resources([
            'eventos' => EventController::class,
            'correos' => EmailController::class,
            'ordenes' => OrderController::class
        ]);
    });
});