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

Route::get('/list/users', array('as' => 'users', function()
{
	return View::make('pages.users');
}));

Route::get('/list/plugins', array('as' => 'plugins', function()
{
	return View::make('pages.plugins');
}));

Route::resource('/user', 'PanelController');
Route::controller('/auth', 'AuthController');

Route::group(array('prefix' => 'api'), function() {
    Route::get('/', function() {
        return Blacklist::json(array(
            'message'   => 'API documentation coming soon!'
        )); 
    });
    
    Route::controller('users', 'UserController');
    Route::resource('plugins', 'PluginController');
});
