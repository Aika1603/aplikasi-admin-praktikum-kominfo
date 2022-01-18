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

//waktu tidak cukup :(
//api belum dibuat basic token
Route::get('/truck/{page?}', 'ApiController@get_truck');
Route::get('/corporation', 'ApiController@get_corporation');
Route::get('/location', 'ApiController@get_location');
Route::get('/power_unit_type', 'ApiController@get_power_unit_type');
