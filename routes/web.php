<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/admin', ['as' => 'admin.index', 'uses' => 'AdminController@index']);

/* Raids */
Route::get('raids',                  [ 'as' => 'raid.index',          'uses' => 'PublicController@raids'              ]);
Route::get('raid/{id}',              [ 'as' => 'raid.view',           'uses' => 'RaidController@view'                 ]);
Route::post('/raids',                [ 'as' => 'api.post.raid',       'uses' => 'Api\RaidController@store'            ]);
Route::post('/raids/{id}/fights',    [ 'as' => 'api.post.raid.fight', 'uses' => 'Api\RaidFightController@store'       ]);
Route::get('raid/{rid}/fight/{id}',  [ 'as' => 'raid.fight.view',     'uses' => 'RaidFightController@view'            ]);
Route::post('/raids/{id}/attendees', [ 'as' => 'api.post.raid.attendee', 'uses' => 'Api\RaidAttendeeController@store' ]);

/* Characters */
Route::get('characters',   [ 'as' => 'character.index',    'uses' => 'PublicController@characters'   ]);
Route::post('/characters', [ 'as' => 'api.post.character', 'uses' => 'Api\CharacterController@store' ]);
