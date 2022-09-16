<?php

use Illuminate\Support\Facades\Route;

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
    return redirect(route('login'));
});
Route::get('/forgot-password', function () {
    return view('auth.passwords.reset');
})->middleware('guest')->name('password.request');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Auth::routes();
Route::group(['middleware' => ['auth']], function() {

    Route::get('/logout', 'LogoutController@index')->name('logout');
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/','ImportUserController@index')->name('users');
        Route::post('/import-data','ImportUserController@import')->name('import-data');
        Route::get('/ajax_data_request','ImportUserController@ajax_data_request')->name('ajax_data_request');
    });
    
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/','BlogController@index')->name('blogs');
        Route::get('/ajax_data_request','BlogController@ajax_data_request')->name('ajax_data_request');
    });

});

// Route::group(['prefix' => 'roles'], function () {
//     Route::get('/','RoleController@index')->name('roles');
//     Route::get('/role-list','RoleController@index');
//     Route::get('/role-ajax-data','RoleController@ajaxSettingData');
//     Route::get('/role-create','RoleController@create')->name('role-create');
//     Route::post('/role-store','RoleController@store')->name('role-save');
//     Route::get('/role-show/{id}','RoleController@show');
//     Route::get('/role-edit/{id}','RoleController@edit');
//     Route::post('/role-update','RoleController@update')->name('role-update');
//     Route::post('/role-delete','RoleController@destroy');
// });