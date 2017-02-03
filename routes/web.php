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

Route::get('/', 'NewsController@index');
Route::get('/news/{id}', 'NewsController@news');

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('/admin/', 'DashboardController@index');
    Route::get('/admin/statistics/generals', 'StatisticsController@generals');
    Route::get('/admin/statistics/browsers', 'StatisticsController@browsers');
    Route::get('/admin/statistics/os', 'StatisticsController@os');
    Route::get('/admin/statistics/geos', 'StatisticsController@geos');
    Route::get('/admin/statistics/refs', 'StatisticsController@refs');
    Route::get('/admin/statistics/news', 'StatisticsController@news');
});

Auth::routes();
