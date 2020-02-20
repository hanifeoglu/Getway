<?php

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

Route::get('/', function () {
    return redirect()->route('payments.list');
});

Auth::routes();

Route::get('payments/create', 'PaymentTransacitonsController@create')->name('payments.create')->middleware(['auth']);
Route::post('payments', 'PaymentTransacitonsController@store')->name('payments.store')->middleware(['auth']);
Route::get('payments', 'PaymentTransacitonsController@index')->name('payments.list')->middleware(['auth']);
Route::get('list', 'PaymentTransacitonsController@paymentsList')->name('payments.json')->middleware(['auth']);
Route::get('payments/{key}', 'PaymentTransacitonsController@show')->name('payments.show');
Route::get('payment/{key}', 'PaymentTransacitonsController@detail')->name('payments.detail');
Route::post('payments/{key}', 'PaymentTransacitonsController@makePayment')->name('payments.make');

Route::get('homepage', function () {
    return view('welcome');
});
