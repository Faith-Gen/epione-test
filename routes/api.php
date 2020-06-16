<?php

use App\Http\Controllers\AuthController;
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

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout')->middleware('auth:api');
        Route::post('refresh', 'AuthController@refresh')->middleware('auth:api');
        Route::post('register', 'AuthController@register');
    });

Route::prefix('books')
    ->middleware('auth:api')
    ->name('books.')
    ->group(function () {
        Route::get('', 'BookController@index')->name('index');
        Route::get('{book}', 'BookController@show');
        Route::post('{book}/checkout', 'BookController@checkout');
        Route::post('{book}/return', 'BookController@return');
    });

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth:api', 'librarian'])
    ->group(function () {
        Route::get('{user}', 'UserController@show');
        Route::put('{user}', 'UserController@update');
        Route::put('{user}/books', 'UserController@userBooks');
    });
