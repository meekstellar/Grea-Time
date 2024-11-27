<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ManagersController;
use App\Http\Controllers\CodeController;

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

Route::get('/home',                     [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/worker',                   [WorkersController::class, 'worker'])->name('worker');
Route::post('/worker',                  [WorkersController::class, 'saveWorker'])->name('saveWorker');
Route::get('/workers',                  [WorkersController::class, 'index'])->name('workers');
Route::post('/addNewWorker',            [WorkersController::class, 'addNewWorker'])->name('addNewWorker');
Route::post('/editWorkerFromClient',    [WorkersController::class, 'editWorkerFromClient'])->name('editWorkerFromClient');
Route::post('/addClientHours',          [WorkersController::class, 'addClientHours'])->name('addClientHours');
Route::post('/changeClientsHours',      [WorkersController::class, 'changeClientsHours'])->name('changeClientsHours');

Route::get('/clients',                  [ClientsController::class, 'index'])->name('clients');
Route::post('/addNewClient',            [ClientsController::class, 'addNewClient'])->name('addNewClient');
Route::post('/editClient',              [ClientsController::class, 'editClient'])->name('editClient');
Route::post('/setFee',                  [ClientsController::class, 'setFee'])->name('setFee');
Route::post('/show_clients_marginality',[ClientsController::class, 'show_clients_marginality'])->name('show_clients_marginality');

Route::get('/managers',                 [ManagersController::class, 'index'])->name('managers');
Route::post('/addNewManager',           [ManagersController::class, 'addNewManager'])->name('addNewManager');
Route::post('/editManager',             [ManagersController::class, 'editManager'])->name('editManager');
Route::post('/removeManager',           [ManagersController::class, 'removeManager'])->name('removeManager');

Route::get('/enter-code',               [CodeController::class, 'showCodeForm'])->name('enter.code');
Route::post('/enter-code',              [CodeController::class, 'storeCode'])->name('code.store');

Route::post('/get-clients', [ClientsController::class, 'getClients'])->name('get.clients');
