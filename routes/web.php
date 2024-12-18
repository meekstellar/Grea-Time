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

Route::get('/worker',                   [WorkersController::class, 'worker'])->name('worker')->middleware('auth');
Route::get('/workers',                  [WorkersController::class, 'index'])->name('workers')->middleware('auth');
Route::post('/worker',                  [WorkersController::class, 'saveWorker'])->name('saveWorker')->middleware('auth');
Route::post('/addNewWorker',            [WorkersController::class, 'addNewWorker'])->name('addNewWorker')->middleware('auth');
Route::post('/editWorkerFromClient',    [WorkersController::class, 'editWorkerFromClient'])->name('editWorkerFromClient')->middleware('auth');
Route::post('/add-rest-day',             [WorkersController::class, 'addRestDay'])->name('addRestDay')->middleware('auth')->middleware('auth');
Route::post('/addClientHours',          [WorkersController::class, 'addClientHours'])->name('addClientHours')->middleware('auth');
Route::post('/changeClientsHours',      [WorkersController::class, 'changeClientsHours'])->name('changeClientsHours')->middleware('auth');

Route::get('/clients',                  [ClientsController::class, 'index'])->name('clients')->middleware('auth');
Route::post('/addNewClient',            [ClientsController::class, 'addNewClient'])->name('addNewClient')->middleware('auth');
Route::post('/editClient',              [ClientsController::class, 'editClient'])->name('editClient')->middleware('auth');
Route::post('/setFee',                  [ClientsController::class, 'setFee'])->name('setFee')->middleware('auth');
Route::post('/show_clients_marginality',[ClientsController::class, 'show_clients_marginality'])->name('show_clients_marginality')->middleware('auth');

Route::get('/managers',                 [ManagersController::class, 'index'])->name('managers')->middleware('auth');
Route::post('/addNewManager',           [ManagersController::class, 'addNewManager'])->name('addNewManager')->middleware('auth');
Route::post('/editManager',             [ManagersController::class, 'editManager'])->name('editManager')->middleware('auth');
Route::post('/removeManager',           [ManagersController::class, 'removeManager'])->name('removeManager')->middleware('auth');

Route::get('/enter-code',               [CodeController::class, 'showCodeForm'])->name('enter.code');
Route::post('/enter-code',              [CodeController::class, 'storeCode'])->name('code.store');

# For API
Route::post('/get-clients',    [ClientsController::class, 'getClients'])->name('get.clients')->middleware('auth');
Route::post('/get-salary',     [WorkersController::class, 'getSalary'])->name('get.salary')->middleware('auth');
Route::post('/send-reminder',  [SendReminderController::class,      'sendReminder'])->name('send.reminder')->middleware('auth');

Route::get('/register', function () {
    abort(403, 'Registration is disabled.');
});
Route::post('/register', function () {
    abort(403, 'Registration is disabled.');
});
