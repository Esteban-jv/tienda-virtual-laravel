<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'welcome'])->name('main')->middleware('auth');
Route::get('profile',[ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile',[ProfileController::class, 'update'])->name('profile.update');

//Route::resource('products',ProductController::class);
Route::resource('products.carts',ProductCartController::class)->only(['store','destroy']); //Controlador de recursos anidados #php artisan make:controller -m Cart -p Product ProductCartController
Route::resource('carts',CartController::class)->only(['index']);
Route::resource('orders',OrderController::class)->only(['create','store'])->middleware(['verified']);
Route::resource('orders.payments',OrderPaymentController::class)->only(['create','store'])->middleware(['verified']);

Auth::routes([
    'verify' => true,
//    'reset' => false //deshabilita el reestablecimiento de contraseñas
]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // TODO checar por qué sigue apareciendo la ruta al redirigir
