<?php

use Illuminate\Support\Facades\Auth;
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

define('PAGINATION_COUNT', 10);
Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    // ********************** Language **********************
    Route::group(['prefix' => 'language'], function () {
        Route::get('/', 'LanguageController@index')->name('admin.language');
        Route::get('/create', 'LanguageController@create')->name('admin.language.create');
        Route::post('/store', 'LanguageController@store')->name('admin.language.store');
        Route::get('/edit/{id}', 'LanguageController@edit')->name('admin.language.edit');
        Route::post('/update/{id}', 'LanguageController@update')->name('admin.language.update');
        Route::get('/delete/{id}', 'LanguageController@destroy')->name('admin.language.delete');
    });
    // ********************** Main Categories **********************
    Route::group(['prefix' => 'main_categories'], function () {
        Route::get('/', 'MainCategoryController@index')->name('admin.main_category');
        Route::get('/create', 'MainCategoryController@create')->name('admin.main_category.create');
        Route::post('/store', 'MainCategoryController@store')->name('admin.main_category.store');
        Route::get('/edit/{id}', 'MainCategoryController@edit')->name('admin.main_category.edit');
        Route::post('/update/{id}', 'MainCategoryController@update')->name('admin.main_category.update');
        Route::get('/delete/{id}', 'MainCategoryController@destroy')->name('admin.main_category.delete');
    });
});
Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', 'LoginController@getLogin')->name('get.admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');
});
