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

Route::group(
    [
        'prefix' =>'home' , 'namespace' => 'End_user'
    ], function() {

        Route::get('/', 'HomeController@index')->name('endUser.home');
        Route::get('category', 'HomeController@category')->name('endUser.category');
        Route::get('product/{id}', 'HomeController@Product')->name('endUser.Product');
});








Route::get('/', function () {
    return view('welcome');
});
