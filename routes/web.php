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

Route::post('interested-user/register', 'Invitation\RegisterInterestedUserController@register');


Route::get('/home/', 'HomeController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout')->name('app.logout');

Route::group(["middleware"=>"guest"], function() {

    Route::get('interested-user', 'Invitation\InterestedUserController@create');

});
