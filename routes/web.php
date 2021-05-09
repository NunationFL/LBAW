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
// Home

Route::get('/', 'LandingController@index')->name('landing_page');


// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Movies
Route::get('movie/{id}', 'MovieController@show')->name('movie');
Route::get('api/movie/{movie_id}/feed/{page}','MovieController@getPage');
Route::post('api/movie/{id}/review','ReviewController@create');

//Reviews
Route::get('review/{id}','ReviewController@show')->name('review');
Route::get('api/review/{review_id}','ReviewController@getReview');
Route::delete('api/review/{review_id}', 'ReviewController@delete');
Route::patch('api/review/{review_id}', 'ReviewController@edit');

//User Profile
Route::get('user/{user}','UserController@show')->name('user');