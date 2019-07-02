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
    return view('contenido');
});

Route::get('/test', function () {
    return view('gantt-test');
});



Route::get('/api/item', 'ItemController@index')->name('items.index');
Route::post('/api/item', 'ItemController@store')->name('item.store');
Route::put('/api/item', 'ItemController@update')->name('item.update');
Route::delete('/api/item/{id}', 'ItemController@delete')->name('item.delete');
Route::put('/api/assignSupervisor', 'ItemController@assignSupervisor');



Route::get('/api/sale', 'SaleController@index')->name('sales.index');
Route::post('/api/sale', 'SaleController@store')->name('sales.store');
Route::put('/api/sale', 'SaleController@update')->name('sales.update');
Route::delete('/api/sale/{id}', 'SaleController@delete')->name('sales.delete');


Route::get('/api/report', 'ReportController@index')->name('reports.index');
Route::get('/api/salesReport', 'ReportController@salesReport')->name('reports.salesReport');
Route::get('/api/dateSetup', 'ReportController@dateSetup')->name('reports.dateSetup');
Route::get('/api/reportByMonth', 'ReportController@reportByMonth')->name('reports.reportByMonth');
Route::get('/api/discountByMonth', 'ReportController@discountByMonth')->name('reports.discountByMonth');
Route::get('/api/productByYear', 'ReportController@productByYear')->name('reports.productByYear');
Route::get('/api/salesVersus', 'ReportController@salesVersus')->name('reports.salesVersus');

