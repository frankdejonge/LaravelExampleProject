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
    return view('welcome');
});


Auth::routes();

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')
    ->name('register');

Route::post('register', 'Auth\RegisterController@start')
    ->name('register.start');

Route::get('register/name/{registrationId}', 'Auth\RegisterController@showNameForm')
    ->name('register.name_form');

Route::post('register/name/{registrationId}', 'Auth\RegisterController@processNameForm')
    ->name('register.process_name_form');

Route::get('register/email/{registrationId}', 'Auth\RegisterController@showEmailForm')
    ->name('register.email_form');

Route::post('register/email/{registrationId}', 'Auth\RegisterController@processEmailForm')
    ->name('register.process_email_form');

Route::get('register/password/{registrationId}', 'Auth\RegisterController@showPasswordForm')
    ->name('register.password_form');

Route::post('register/password/{registrationId}', 'Auth\RegisterController@processPasswordForm')
    ->name('register.process_password_form');

Route::get('register/confirm/{registrationId}', 'Auth\RegisterController@showConfirmForm')
    ->name('register.confirm_form');

Route::post('register/confirm/{registrationId}', 'Auth\RegisterController@processConfirmForm')
    ->name('register.process_confirm_form');


Route::get('/home', 'HomeController@index')->name('home');
