<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome');})->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/eve', [App\Http\Controllers\Auth\EveController::class, 'redirect'])->name('auth.eve');
Route::get('/auth/eve/callback', [App\Http\Controllers\Auth\EveController::class, 'callback'])->name('auth.eve.callback');

Route::get('/status', [App\Http\Controllers\StatusController::class, 'index'])->name('status');