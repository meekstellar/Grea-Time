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
    //return view('welcome');
    return redirect('/workers/all/2024-05-25');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/workers/{workers_id}/{date_period}', [App\Http\Controllers\WorkersController::class, 'index'])->name('workers');
Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');
