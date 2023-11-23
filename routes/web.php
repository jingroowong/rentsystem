<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ReportController;
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
Route::get('/agent/{timeslotID}/delete', 'App\Http\Controllers\TimeslotController@destroy')->name('timeslots.destroy');

//Appointment Route
Route::resource('appointments', 'App\Http\Controllers\AppointmentController');
Route::get('/appointments', 'App\Http\Controllers\AppointmentController@index')->name('appointments');
Route::get('agent/appointments', 'App\Http\Controllers\AppointmentController@agentIndex')->name('appointments.agentIndex');
Route::get('/appointments/create/{propertyID}', 'App\Http\Controllers\AppointmentController@create')->name('appointment.create');
Route::get('appointments/{appID}/cancel', 'App\Http\Controllers\AppointmentController@cancel')->name('appointments.cancel');
Route::get('appointments/{appID}/update', 'App\Http\Controllers\AppointmentController@update')->name('appointments.update');
Route::get('appointments/{appID}/updatebyAgent', 'App\Http\Controllers\AppointmentController@updateByAgent')->name('appointments.updateByAgent');

//Notification Route
Route::resource('notifications', 'App\Http\Controllers\NotificationController');
Route::get('/tenant/notifications', 'App\Http\Controllers\NotificationController@tenantIndex')->name('notifications.tenant');
Route::get('/agent/notifications', 'App\Http\Controllers\NotificationController@index')->name('notifications');
Route::get('searchNotification', 'App\Http\Controllers\NotificationController@search')->name('notifications.search');

Route::post('/notifications/mark-as-read', 'App\Http\Controllers\NotificationController@markAsRead')->name('notifications.markAsRead');
Route::post('/notifications/delete','App\Http\Controllers\NotificationController@delete')->name('notifications.delete');
//Property Route
Route::resource('properties', 'App\Http\Controllers\PropertyController');
Route::get('/agent/properties', 'App\Http\Controllers\PropertyController@index')->name('properties');
Route::get('/agent/createProperty', 'App\Http\Controllers\PropertyController@create')->name('createProperty');
Route::get('/agent/{propertyID}/show', 'App\Http\Controllers\PropertyController@showAgent')->name('properties.showAgent');
Route::get('/agent/{propertyID}/delete', 'App\Http\Controllers\PropertyController@destroy')->name('properties.destroy');
Route::post('/agent/{propertyID}/update', 'App\Http\Controllers\PropertyController@update')->name('properties.update');

Route::get('searchProperty', 'App\Http\Controllers\PropertyController@search')->name('properties.search');
Route::get('properties/{propertyID}/apply', 'App\Http\Controllers\PropertyController@apply')->name('properties.apply');
Route::get('properties/{propertyID}/submitApplication', 'App\Http\Controllers\PropertyController@submitApplication')->name('properties.submitApplication');
Route::get('properties/{propertyID}/approve', 'App\Http\Controllers\PropertyController@approve')->name('properties.approve');
Route::get('application', 'App\Http\Controllers\PropertyController@applicationIndex')->name('properties.applicationIndex');
Route::get('properties/{propertyID}/reject', 'App\Http\Controllers\PropertyController@reject')->name('properties.reject');
//Refund Route
Route::resource('refunds', 'App\Http\Controllers\RefundController');

Route::get('/admin/refunds', 'App\Http\Controllers\RefundController@index')->name('refunds');

Route::get('refunds/{propertyRentalID}/create', 'App\Http\Controllers\RefundController@create')->name('refunds.create');
Route::get('refunds/{refundID}/approve', 'App\Http\Controllers\RefundController@approve')->name('refunds.approve');
Route::post('refunds/reject', 'App\Http\Controllers\RefundController@reject')->name('refunds.reject');

//Payment Route
Route::resource('payments', 'App\Http\Controllers\PaymentController');
Route::get('tenant/paymentHistory', 'App\Http\Controllers\PaymentController@index')->name('paymentHistory');
Route::get('payment/{propertyRentalID}/create', 'App\Http\Controllers\PaymentController@create')->name('payments.create');
Route::get('payment/{propertyRentalID}/store', 'App\Http\Controllers\PaymentController@store')->name('payments.store');
Route::get('payment/{propertyRentalID}/release', 'App\Http\Controllers\PaymentController@release')->name('payments.release');

Route::get('/agent/wallet', 'App\Http\Controllers\WalletController@index')->name('agentWallet');
Route::post('/agent/wallet/payment', 'App\Http\Controllers\WalletController@payment')->name('payment');
Route::get('/agent/wallet/make-payment', 'App\Http\Controllers\WalletController@walletPayment')->name('makePayment');
Route::post('/agent/wallet/withdraw', 'App\Http\Controllers\WalletController@withdraw')->name('withdraw');
Route::get('/agent/wallet/withdraw-money', 'App\Http\Controllers\WalletController@walletWithdraw')->name('withdrawMoney');
Route::get('/agent/wallet/topup', 'App\Http\Controllers\WalletController@topUp')->name('topUp');
Route::get('/agent/wallet/topup-money', 'App\Http\Controllers\WalletController@walletTopUp')->name('topUpMoney');
Route::get('/agent/wallet/pending-payment', 'App\Http\Controllers\WalletController@walletPending')->name('pendingPayment');


//Report Route
Route::get('/reports', 'App\Http\Controllers\ReportController@showReports')->name('reports');
Route::post('/reports/generateReport', 'App\Http\Controllers\ReportController@generateReport')->name('reports.generate');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
