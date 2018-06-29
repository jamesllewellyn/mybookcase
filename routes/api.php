<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => "guest"], function () {

    Route::post('interested-user', 'Invitation\InterestedUserController@store');
    Route::get('interested-user', 'Invitation\InterestedUserController@show');
    Route::post('user', 'UserController@store');

});

/***********************
 * Search API
 **********************/
Route::group(["middleware" => ["guest", 'throttle:30,1']], function () {
    Route::get('goodreads', 'Search\GoodReadsAPIController@index');
    Route::get('goodreads/{id}', 'Search\GoodReadsAPIController@show');

});

Route::group(["middleware" => "auth:api"], function () {
    Route::get('new-york-times/best-sellers', 'Search\NewYorkTimesAPIController@index');
    /** User */
    Route::apiResource('user', 'UserController', ['only' => ['index', 'update']]);

    /** User Shelf */
    Route::apiResource('user/{user}/shelf', 'ShelfController');

    /** User Shelf Book*/
    Route::apiResource('user/{user}/shelf/{shelf}/book', 'ShelfBookController');

    /** Public */
    Route::get('user/{handle}/public', 'PublicShelfController@index');
    Route::get('user/{handle}/public/shelf/{shelf}', 'PublicShelfController@show');
    Route::get('user/{handle}/public/shelf/{shelf}/book', 'PublicShelfBookController@index');

    /** Friends */
    Route::apiResource('friend', 'FriendController');
    Route::get('friends', 'FriendSearchController@index');
    /** Create friend request **/
    Route::post('user/{user}/friend-request/{friend}', 'FriendRequestController@create');
    /** accept or decline friend request */
    Route::put('user/{user}/friend-request/{friend}', 'FriendRequestController@update');
    /** Deleted Friend Request */
    Route::delete('user/{user}/friend-request/{friendRequest}', 'FriendRequestController@destroy');
    
});


