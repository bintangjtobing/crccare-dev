<?php
Route::get('/login', function () {
    return view('auth.login');
})->name('login.show');
Route::post('/login', 'LoginController@processLogin')->name('login.process');
Route::get('/forgot-password', 'LoginController@forgotPassword');
Route::post('/forgot-password', 'LoginController@processForgotPassword')->name('login.forgotPassword');
Route::post('/reset-password', 'LoginController@processResetPassword')->name('login.resetPassword');
Route::get('/reset-password/{token}', 'LoginController@resetPasswordView')->name('login.resetPasswordView');
Route::get('/sign-out', function () {
    session()->flush();
    auth()->logout();
    return redirect('/')->with('success', 'Has been logged out!');
});

Route::get('/get-filename-count', 'DashboardController@getCountFilename');

Route::post('addHumanImpact', 'DashboardController@addHumanImpact');
Route::get('humanimpactData', 'DashboardController@getHumanImpacts');
Route::post('/register-new-user', 'LoginController@registerNewUser');
Route::get('/getChartValue', 'DashboardController@getVal');
Route::get('/view-data/{id}', 'DashboardController@viewDataScore');

Route::delete('/delete-data-result/{id}', 'DashboardController@deleteDataResult');

// FOR CHART NEEDS
Route::get('/count-data-pie', 'DashboardController@countDataFiles');

Route::group(['middleware' => 'auth'], function () {
    Route::any('/{any}', function () {
        return view('welcome');
    })->where('any', '.*');
});
