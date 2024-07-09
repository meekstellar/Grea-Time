<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/workers', [App\Http\Controllers\WorkersController::class, 'index'])->name('workers');
Route::get('/reports', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports');
Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');
