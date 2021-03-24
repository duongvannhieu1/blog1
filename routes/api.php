<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'Auth\UserController@register');
Route::post('login', 'Auth\UserController@login');

// Route::middleware('auth:api')->group(function(){
//     Route::get('user_info', 'Auth\UserController@user_info');
// });

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('logout', 'Auth\UserController@logout');
    Route::get('user_info', 'Auth\UserController@user_info');
});
