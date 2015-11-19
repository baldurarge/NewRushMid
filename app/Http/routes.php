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

Route::get('friendAdd/{friend_Id}',[
    'middlewere' => 'auth',
    'uses' => 'FriendsController@friendAdd'
]);
Route::get('friendAccept/{friend_Id}',[
    'middlewere' => 'auth',
    'uses' => 'FriendsController@friendAccept'
]);

Route::get('markAsRead/{post_Id}',[
    'middlewere' => 'auth',
    'uses' => 'homeController@markAsRead'
]);

Route::get('userInfo/{user_id}',[
   'middlewere' => 'auth',
    'uses' => 'userInfoController@showInfo'
]);

Route::get('userEdit/{user_id}',[
    'middlewere' => 'auth',
    'uses' => 'userInfoController@editUser'
]);

Route::post('edituser/{id}',['middlewere'=>'auth', 'uses' => 'userInfoController@update']);


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');