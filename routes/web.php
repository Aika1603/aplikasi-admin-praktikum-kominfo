<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
  'register' => true,
  'reset' => true,
  'verify' => true,
]);

Route::get('/forbidden', function () {
    return view('error.forbidden');
});

Route::group(['middleware' => ['verified']], function() {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('/home', 'HomeController@index')->name('dashboard.index');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::get('/notification', 'NotificationController@index');
    Route::get('/notification/get/{id?}', 'NotificationController@get');
    Route::get('/notification/read-all', 'NotificationController@read_all');
    Route::get('/notification/delete-all', 'NotificationController@delete_all');
    Route::get('/notification/view/{id?}', 'NotificationController@view');
  
    Route::get('/account', 'AccountController@show')->name('account');
    Route::post('/account/change-password', 'AccountController@change_password_process')->name('account.pass');
    Route::post('/account/update', 'AccountController@update_process')->name('account.update');
    Route::post('/account/update-fcm', 'AccountController@update_fcm')->name('account.update_fcm');
    Route::post('/account/update-avatar', 'AccountController@change_avatar_process')->name('account.avatar');

    Route::resource('roles', RoleController::class);
    Route::get('/roles/delete/{id?}', 'RoleController@destroy')->name('roles.delete');
    Route::post('/roles/update/{id?}', 'RoleController@update')->name('roles.update_process');

    Route::resource('permissions', PermissionController::class);
    Route::get('/permissions/delete/{id?}', 'PermissionController@destroy')->name('permissions.delete');
    Route::post('/permissions/update/{id?}', 'PermissionController@update')->name('permissions.update_process');

    Route::resource('users', UsersController::class);
    Route::get('/users/delete/{id?}', 'UsersController@destroy')->name('users.delete');
    Route::post('/users/update/{id?}', 'UsersController@update')->name('users.update_process');

    Route::resource('actions', ActionController::class);
    Route::get('/actions/delete/{id?}', 'ActionController@destroy')->name('actions.delete');
    Route::post('/actions/update/{id?}', 'ActionController@update')->name('actions.update_process');

    Route::resource('menus', MenuController::class);
    Route::get('/menus/delete/{id?}', 'MenuController@destroy')->name('menus.delete');
    Route::post('/menus/update/{id?}', 'MenuController@update')->name('menus.update_process');

    Route::resource('perusahaans', PerusahaanController::class);
    Route::get('/perusahaans/delete/{id?}', 'PerusahaanController@destroy')->name('perusahaans.delete');
    Route::post('/perusahaans/update/{id?}', 'PerusahaanController@update')->name('perusahaans.update_process');

});
