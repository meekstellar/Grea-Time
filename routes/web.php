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
    return redirect('/workers');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/worker', [App\Http\Controllers\WorkersController::class, 'worker'])->name('worker');
Route::get('/workers', [App\Http\Controllers\WorkersController::class, 'index'])->name('workers');
Route::post('/addNewWorker', [App\Http\Controllers\WorkersController::class, 'addNewWorker'])->name('addNewWorker');
Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'index'])->name('clients');
Route::post('/addNewClient', [App\Http\Controllers\ClientsController::class, 'addNewClient'])->name('addNewClient');
Route::post('/addClientHours', [App\Http\Controllers\WorkersController::class, 'addClientHours'])->name('addClientHours');
Route::post('/changeClientsHours', [App\Http\Controllers\WorkersController::class, 'changeClientsHours'])->name('changeClientsHours');
Route::post('/setFee', [App\Http\Controllers\ClientsController::class, 'setFee'])->name('setFee');
