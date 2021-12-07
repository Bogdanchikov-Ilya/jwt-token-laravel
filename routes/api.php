<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::prefix('auth')->group(function () {
//    Route::group(['namespace' => 'App\Http\Controllers'], function () {
//        Route::post('/signup', 'AuthController@signup');
//        // Route::post('/login', 'AuthController@login');
//        // Route::post('logout', 'App\Http\Controllers\Api\Auth\AuthController@logout')->middleware('auth:sanctum')->name('auth.logout');
//        // Route::get('user', 'App\Http\Controllers\Api\Auth\AuthController@getAuthenticatedUser')->middleware('auth:sanctum')->name('auth.user');
//
//        // Route::post('/password/email', 'App\Http\Controllers\Api\Auth\AuthController@sendPasswordResetLinkEmail')->middleware('throttle:5,1')->name('password.email');
//        // Route::post('/password/reset', 'App\Http\Controllers\Api\Auth\AuthController@resetPassword')->name('password.reset');
//    });
//});


Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('signup', function (Request $request) {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            if(User::create($validatedData)) {
                return response()->json(null, 201);
            }

            return response()->json(null, 404);
        });

    });
});

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'jwt.auth'], function() {
    Route::get('/secret', 'secretController@index');
});
