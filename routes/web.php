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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login','UsersController@login')->name('user.login');
Route::post('/login/validate','UsersController@validation')->name('user.validation');
Route::get('/register','UsersController@create')->name('user.create');
Route::post('/user/store','UsersController@store')->name('user.store');
Route::get('/user/verify/{token}','UsersController@verifyEmail')->name('user.verify');
