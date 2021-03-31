<?php

use Illuminate\Support\Facades\Route;

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

// auth
Auth::routes();

//TODO - dopln only - metody
Route::resource('orders', 'OrderController')->only([ 
    'create', 'store', 'edit', 'update', 'destroy'
]);
Route::get('/orders/{timePeriod?}', 'OrderController@index')->name('orders.index');
Route::get('orders/{order}/pay', 'OrderController@pay')->name('orders.pay');
Route::get('/orders/sortStatus', 'OrderController@sortStatus')->name('orders.sortStatus');
Route::resource('productCategories', 'ProductCategoryController');
Route::resource('products', 'ProductController');
Route::resource('workPositions', 'WorkPositionController');
Route::resource('employees', 'EmployeeController')->only([ //|TODO dopln only pre vsetky ked budes mas hotovo
    'index', 'create', 'store', 'edit', 'update', 'destroy'
]);
Route::get('/employees/shifts', 'EmployeeController@shifts')->name('employees.shifts');



// frontend pages
Route::get('/', 'FrontendController@dashboard')->name('dashboard');
Route::get('/map', 'FrontendController@map')->name('map');
Route::get('/sales', 'FrontendController@sales')->name('sales');
Route::get('/new_order', 'FrontendController@new_order')->name('new_order');
 