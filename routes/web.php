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
Route::get('login/oauth', 'Auth\LoginController@redirectToProvider')->name('oauth.login');
Route::get('callback', 'Auth\LoginController@handleProviderCallback')->name('callback');

Route::get('/home', 'HomeController@index')->name('home');

/* Raids */
Route::get('raids',                  [ 'as' => 'raid.index',             'uses' => 'PublicController@raids'           ]);
Route::get('raid/{id}',              [ 'as' => 'raid.view',              'uses' => 'RaidController@view'              ]);
Route::post('/raids',                [ 'as' => 'api.post.raid',          'uses' => 'Api\RaidController@store'         ]);
Route::post('/raids/{id}/attendees', [ 'as' => 'api.post.raid.attendee', 'uses' => 'Api\RaidAttendeeController@store' ]);

/* Raid Fights */
Route::post('/raids/{id}/fights',           [ 'as' => 'api.post.raid.fight',   'uses' => 'Api\RaidFightController@store' ]);
Route::get('raid/{rid}/fight/{id}',         [ 'as' => 'raid.fight.view',       'uses' => 'RaidFightController@view'      ]);
Route::get('raid/{rid}/fight/{id}/import',  [ 'as' => 'raid.fight.import',     'uses' => 'LogsController@importForm'     ]);
Route::post('raid/{rid}/fight/{id}/csv',    [ 'as' => 'raid.fight.csv.store',  'uses' => 'LogsController@store'          ]);

/* Fights */
Route::post('/fight/{id}/lock',   ['as' => 'fight.lock', 'uses' => 'RaidFightController@lock']);
Route::post('/fight/{id}/unlock', ['as' => 'fight.unlock', 'uses' => 'RaidFightController@unlock']);

/* Characters */
Route::get('characters',           [ 'as' => 'character.index',          'uses' => 'PublicController@characters'         ]);
Route::post('/characters',         [ 'as' => 'api.post.character',       'uses' => 'Api\CharacterController@store'       ]);
Route::delete('character/{id}',    [ 'as' => 'character.delete',         'uses' => 'CharactersController@delete'         ]);
Route::post('/character/stats',    [ 'as' => 'api.post.character.stats', 'uses' => 'Api\CharacterStatsController@store'  ]);
Route::delete('/admin/stats/{id}', [ 'as' => 'admin.stat.delete',        'uses' => 'Api\CharacterStatsController@delete' ]);
Route::get('characters/{id}',      [ 'as' => 'character.view',           'uses' => 'CharactersController@view'           ]);

Route::post('/character/claim',   ['as' => 'character.claim',   'uses' => 'CharactersController@claim'        ]);
Route::post('/character/unclaim', ['as' => 'character.unclaim', 'uses' => 'CharactersController@unclaim'      ]);
Route::post('/character/spec',    ['as' => 'character.spec',    'uses' => 'Api\CharacterController@storeSpec' ]);

/* Comparisons */
Route::get('leaderboards',            ['uses' => 'ComparisonController@leaderboards'      ]);
Route::get('compare/{char1}/{char2}', ['uses' => 'ComparisonController@compareCharacters' ]);

/* Administration */
Route::get('admin', [ 'as' => 'admin.index',      'uses' => 'AdminController@index' ]);

Route::group(['prefix' => 'admin'], function () {
    Route::get('stats',      [ 'as' => 'admin.stats',      'uses' => 'AdminController@stats'   ]);
    Route::get('characters', [ 'as' => 'admin.characters', 'uses' => 'AdminController@raiders' ]);
    Route::get('users',      [ 'as' => 'admin.users',      'uses' => 'AdminController@users'   ]);
});

require(__DIR__ . '/pages.php');