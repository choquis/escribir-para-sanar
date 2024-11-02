<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Mail\InscriptionSuccess;
use App\Models\Order;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/inscribir', [HomeController::class, 'register'])->name('register');
Route::post('/inscribir', [HomeController::class, 'registerCreation'])->name('register');
Route::get('/inscribir/completado', [HomeController::class, 'registerComplete'])->name('register-complete');
Route::post('/suscribir', [HomeController::class, 'subscribe'])->name('subscribe');
Route::get('/suscribir/completado', [HomeController::class, 'subscribeComplete'])->name('subscribe-complete');
Route::get('/mas-informacion', [HomeController::class, 'information'])->name('information');

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

    Route::get('preview-mail/{orderId}', function ($orderId) {
        $order = Order::where('order_key', '=', $orderId)->first();
        try {
            Mail::to($order->email->email)->send(new InscriptionSuccess($order));
        } catch (\Exception $e) {
            Log::error("La captura de la orden " . $orderId . " se completo, pero ocurrio un problema
            al enviar el correo.");
            Log::error($e->getMessage() . " - " . $e->getTraceAsString());
        }
        return new InscriptionSuccess($order);
       });
});
