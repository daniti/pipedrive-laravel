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
    if (Auth::check()) {
        return \Illuminate\Support\Facades\Redirect::to('home');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login', function () {
    return \Illuminate\Support\Facades\Redirect::to('auth/pipedrive');
})->name('login');

Route::get('/register', function () {
    return \Illuminate\Support\Facades\Redirect::to('home');
})->name('register');

Route::get('password/reset', function () {
    return \Illuminate\Support\Facades\Redirect::to('/');
});

Route::get('password/email', function () {
    return \Illuminate\Support\Facades\Redirect::to('/');
});

Route::get('auth/pipedrive', 'Auth\AuthController@redirectToProvider');
Route::get('auth/pipedrive/callback', 'Auth\AuthController@handleProviderCallback');
