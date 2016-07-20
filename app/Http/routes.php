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


Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'ShotController@index']);

Route::get('login', ['as' => 'login', 'uses' => 'TwitchController@login']);
Route::get('logout', ['as' => 'login', 'uses' => 'TwitchController@logout']);
Route::get('twitchAuth', ['as' => 'twitchAuth', 'uses' => 'TwitchController@auth']);

Route::get('submit', ['as' => 'submit', 'uses' => 'ShotController@submit']);
