<?php

use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/auth/register', function () {
    return view('auth.register');
});

Route::post('/auth/register', 'App\Http\Controllers\AuthController@register')->name('register_form');
Route::post('/auth/login', 'App\Http\Controllers\AuthController@authenticate')->name('login_form');
Route::post('/auth/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

// Base Route
Route::get('/', function () {
    return view('index');
})->middleware('auth');

// User Routes
Route::resource('users', 'App\Http\Controllers\UserController')->middleware('auth');