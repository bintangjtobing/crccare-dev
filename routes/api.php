<?php

use App\Http\Controllers\DashboardController;
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

// these routes can be used anonymously
Route::post('/users/check-user-data', 'UserController@checkUserData');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/chemicals', 'DashboardController@getChemicals');
    Route::get('/chemicals/{id}', 'DashboardController@getChemicalById');
    Route::post('/chemicals', 'DashboardController@addChemical');
    Route::patch('/chemicals/{id}', 'DashboardController@updateChemical');
    Route::delete('/chemicals/{id}', 'DashboardController@deleteChemical');

    Route::get('/file-chemicals', 'DashboardController@getFileChemicals');
    Route::post('/file-chemicals', 'DashboardController@addFileChemical');
    Route::delete('/file-chemicals/{id}', 'DashboardController@deleteFileChemical');

    Route::get('/files', 'DashboardController@getFiles');
    Route::post('/files/check-file-data', 'DashboardController@checkFile');
    Route::post('/files', 'DashboardController@createFile');

    Route::post('/documents', 'DocumentController@fileStore')->name('dropzone');
    Route::get('/documents/{id}', 'DocumentController@getDocument');

    Route::get('/score-results/{id}', 'DashboardController@getScoreResultById');
    Route::patch('/score-results/{id}', 'DashboardController@updateScore');

    Route::get('/users', 'UserController@getUsers');
    Route::post('/users', 'UserController@addUser');
    Route::delete('/users/{id}', 'UserController@deleteUser');
    Route::get('/users/{id}', 'UserController@getUserById');
    Route::patch('/users/{id}', 'UserController@updateUser');

    // /api/scores?statsData=1 to retrieve all data, this is done so that user can see the normal distribution chart with all data
    // it should be a very specific case and normally users should not see other people's data at all
    // TODO: make the statsData only return data related to statistics
    Route::get('/scores', 'DashboardController@getScore');

    Route::get('/current-user', 'LoginController@getLoggedInUser');
});

Route::middleware('auth:api')->group(function () {
    Route::get('check-file', 'DashboardController@checkFile');
});
