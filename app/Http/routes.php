<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::get('home', [
    'middleware' => 'auth',
    'uses' => 'homeController@index'
]);

Route::get('joinQueue', [
    'middleware' => 'auth',
    'uses' => 'homeController@joinQueue'
]);

Route::get('leaveQueue', [
    'middleware' => 'auth',
    'uses' => 'homeController@leaveQueue'
]);

Route::get('countQueue', [
    'middleware' => 'auth',
    'uses' => 'homeController@countQueue'
]);

Route::get('friendSearch',[
    'middlewere' => 'auth',
    'uses' => 'homeController@friendSearchIndex'
]);



Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');