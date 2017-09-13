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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('tokens/{token}', 'TokenController@process')->name('token.process');

Route::get('one-click', function () {
    $user = App\User::whereEmail(request()->email)->first();
    $user->notify(new App\Notifications\OneClickSignOn($user));
    return 'sent';
});
