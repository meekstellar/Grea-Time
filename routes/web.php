<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ManagersController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\SendReminderController;

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
Route::get('/workers',                  [WorkersController::class, 'index'])->name('workers');
Route::post('/worker',                  [WorkersController::class, 'saveWorker'])->name('saveWorker');
Route::post('/addNewWorker',            [WorkersController::class, 'addNewWorker'])->name('addNewWorker');
Route::post('/editWorkerFromClient',    [WorkersController::class, 'editWorkerFromClient'])->name('editWorkerFromClient');
Route::get('/add-rest-day',             [WorkersController::class, 'addRestDay'])->name('addRestDay')->middleware('auth');;
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

# For API
Route::post('/get-clients',    [ClientsController::class, 'getClients'])->name('get.clients')->middleware('auth');
Route::post('/get-salary',     [WorkersController::class, 'getSalary'])->name('get.salary')->middleware('auth');
Route::post('/send-reminder',  [SendReminderController::class,      'sendReminder'])->name('send.reminder')->middleware('auth');

