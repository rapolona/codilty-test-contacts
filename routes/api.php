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

Route::post('/upload', 'ContactsController@upload');
Route::post('/validate', 'ContactsController@validateMappedCsv');
Route::get('/group-list', 'ContactsController@groupList');
Route::get('/contact-list/{id}', 'ContactsController@contactList');
