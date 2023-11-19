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
//Timeslot Route
Route::resource('timeslots', 'App\Http\Controllers\TimeslotController');
Route::get('/agent/timeslots', 'App\Http\Controllers\TimeslotController@index')->name('timeslots');

//Appointment Route
Route::resource('appointments', 'App\Http\Controllers\AppointmentController');
Route::get('/appointments', 'App\Http\Controllers\AppointmentController@index')->name('appointments');
Route::get('agent/appointments', 'App\Http\Controllers\AppointmentController@agentIndex')->name('appointments.agentIndex');
Route::get('/appointments/create/{propertyID}', 'App\Http\Controllers\AppointmentController@create')->name('appointment.create');

//Notification Route
Route::resource('notifications', 'App\Http\Controllers\NotificationController');
Route::get('/tenant/notifications', 'App\Http\Controllers\NotificationController@tenantIndex')->name('notifications.tenant');
Route::get('/agent/notifications', 'App\Http\Controllers\NotificationController@index')->name('notifications');

//Property Route
Route::resource('properties', 'App\Http\Controllers\PropertyController');
Route::get('/agent/properties', 'App\Http\Controllers\PropertyController@index')->name('properties');
Route::get('/agent/createProperty', 'App\Http\Controllers\PropertyController@create')->name('createProperty');

//Wallet Route
Route::get('/agent/wallet', 'App\Http\Controllers\WalletController@index')->name('agentWallet');
Route::post('/agent/wallet/payment', 'App\Http\Controllers\WalletController@payment')->name('payment');
Route::get('/agent/wallet/make-payment', 'App\Http\Controllers\WalletController@walletPayment')->name('makePayment');
Route::post('/agent/wallet/withdraw', 'App\Http\Controllers\WalletController@withdraw')->name('withdraw');
Route::get('/agent/wallet/withdraw-money', 'App\Http\Controllers\WalletController@walletWithdraw')->name('withdrawMoney');
Route::post('/agent/wallet/topup', 'App\Http\Controllers\WalletController@topUp')->name('topUp');
Route::get('/agent/wallet/topup-money', 'App\Http\Controllers\WalletController@walletTopUp')->name('topUpMoney');
Route::get('/agent/wallet/pending-payment', 'App\Http\Controllers\WalletController@walletPending')->name('pendingPayment');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
