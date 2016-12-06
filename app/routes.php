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
View::share('jsConfig', json_encode(Config::get('javascriptconfig.'.$env)));

Route::controller('landing','Qlink\Controllers\LandingNewController');
Route::controller('landingnew','Qlink\Controllers\LandingNewController');
Route::get('landing', array('as' => 'landing', 'uses' => 'Qlink\Controllers\LandingNewController@welcome'));
Route::get('tokenizer', array('as' => 'tokenizer', 'uses' => 'Qlink\Controllers\LandingNewController@tokenizer'));
Route::get('/', array('as' => 'landing', 'uses' => 'Qlink\Controllers\LandingNewController@welcome'));
Route::get('/newl', array('as' => 'newl', 'uses' => 'Qlink\Controllers\LandingNewController@welcome'));
Route::get('appversion', array('as' => 'appversion', 'uses' => 'Qlink\Controllers\LandingNewController@appversion'));

Route::get('dnstat', array('as' => 'dnstat', 'uses' => 'Qlink\Controllers\LandingNewController@dnStat'));
Route::post('forward', array('as' => 'forward', 'uses' => 'Qlink\Controllers\LandingNewController@forward'));
Route::post('inject', array('as' => 'inject', 'uses' => 'Qlink\Controllers\LandingNewController@inject'));
Route::post('injectios', array('as' => 'injectios', 'uses' => 'Qlink\Controllers\LandingNewController@injectios'));
Route::get('{servnum}/{hash}/{res?}', 'Qlink\Controllers\LandingNewController@seekAndDestroy');
Route::post('readmessage', array('as' => 'readmessage', 'uses' => 'Qlink\Controllers\LandingNewController@readMessage'));
Route::post('readmessageios', array('as' => 'readmessageios', 'uses' => 'Qlink\Controllers\LandingNewController@readMessageios'));
Route::post('gtrkstatus', array('as' => 'gtrkstatus', 'uses' => 'Qlink\Controllers\LandingNewController@gtrkStatus'));

// Corporate
Route::controller('corp', 'Qlink\Controllers\CorpController');
Route::get('main', array('as' => 'corp', 'uses' => 'Qlink\Controllers\CorpController@index'));
