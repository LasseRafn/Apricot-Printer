<?php

/**
 * Welcome
 */
Route::get('/', function()
{
});

/**
 * Application (dashboard)
 */
Route::resource('app/stores', 'Apricot\StoreController');
//Route::resource('app/orders', 'Apricot\OrderController');
//Route::resource('app/modules', 'Apricot\ModulesController');
Route::controller('app', 'Apricot\AppController');

/**
 * Auth
 */
Route::controller('auth', 'Auth\AuthController');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::controller('authorize', 'Apricot\IntegrationController');