<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', function()
{
	return View::make('index');
}));

Route::get('/users', array('as' => 'users', function()
{
	return View::make('users');
}));

Route::get('/plugins', array('as' => 'plugins', function()
{
	return View::make('plugins');
}));

Route::group(array('prefix' => 'api'), function() {
    Route::get('/', function() {
        return 'Hello World';    
    });
    
    Route::resource('plugins', 'PluginsController');
});
