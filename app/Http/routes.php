<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
	return view('welcome');
});

Route::group(['prefix' => 'cate', 'middleware' => 'auth'], function () {
	Route::get('{cate}/edit','CateController@edit');
	Route::get('/', 'CateController@index');
	Route::get('/{cate}/delete','CateController@delete');
	Route::put('/{cate}', 'CateController@update');
	Route::post('/store', 'CateController@store');
});

Route::group(['prefix' => 'artist', 'middleware' => 'auth'], function () {

	Route::get('{artist}/edit','ArtistController@edit');
	Route::get('/','ArtistController@index');
	Route::get('create','ArtistController@create');
	Route::get('{artist}/delete','ArtistController@delete');
	Route::put('{artist}', 'ArtistController@update');
	Route::post('store','ArtistController@store');
	Route::get('ajax_search/{search?}','ArtistController@ajax_search');

});

Route::group(['prefix' => 'song', 'middleware' => 'auth'], function () {

	Route::get('{song}/edit','SongController@edit');
	Route::get('/','SongController@index');
	Route::get('create','SongController@create');
	Route::get('{song}/delete','SongController@delete');
	Route::put('{song}', 'SongController@update');
	Route::post('store','SongController@store');
	Route::get('ajax_search/{search?}','SongController@ajax_search');

});

Route::group(['prefix' => 'playlist', 'middleware' => 'auth'], function () {

	Route::get('{playlist}/edit','PlaylistController@edit');
	Route::get('/','PlaylistController@index');
	Route::get('create','PlaylistController@create');
	Route::get('{playlist}/delete','PlaylistController@delete');
	Route::put('{playlist}', 'PlaylistController@update');
	Route::post('store','PlaylistController@store');

});

Route::get('/test', function(){
//	if (Storage::disk('mp3')->files('hehe')) echo 'Exists!';
//	Storage::disk('mp3')->put('my.txt','Welcome!');
//	echo Storage::disk('mp3')->get('my.txt');
});

Route::resource('API','API');
Route::auth();
Route::get('/home', 'HomeController@index');
