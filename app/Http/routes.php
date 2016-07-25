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
Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'session'], function () {
	Route::get('set/{k}/{v}','SessionController@set');
	Route::get('get/{k}','SessionController@get');
});

Route::group(['prefix' => 'cate', 'middleware' => 'auth'], function () {
	Route::get('{cate}','CateController@show');
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
	Route::get('{artist}','ArtistController@show');
	Route::get('{artist}/delete','ArtistController@delete');
	Route::put('{artist}', 'ArtistController@update');
	Route::post('store','ArtistController@store');
	Route::get('ajax_search/{search?}','ArtistController@ajax_search');

});

Route::group(['prefix' => 'song'], function () {

	Route::get('{song}/edit','SongController@edit');
	Route::get('{song}/increase_view',[
		'uses'=>'SessionController@increase_view_song',
		'middleware' => 'ajax'
	]);
	Route::get('/',[
		'uses'=>'SongController@index',
		'middleware' => 'admin'
	]);
	Route::get('create','SongController@create');
	Route::get('{song}/delete','SongController@delete');
	Route::put('{song}', 'SongController@update');
	Route::post('store','SongController@store');
	Route::get('ajax_search/{search?}','SongController@ajax_search');

	Route::get('{song}', 'SongController@show');

});

Route::group(['prefix' => 'playlist'], function () {

	Route::get('/','PlaylistController@index');
	Route::get('create','PlaylistController@create');
    Route::get('{playlist}/edit','PlaylistController@edit');
    Route::get('{playlist}/delete','PlaylistController@delete');
	Route::get('{playlist}/{index?}', 'PlaylistController@show');
	Route::put('{playlist}', 'PlaylistController@update');
	Route::post('store','PlaylistController@store');

});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {

	Route::get('/','UserController@index');
	Route::get('/playlist/create','UserController@create_playlist');
	Route::get('/playlist/{playlist}/edit','UserController@edit_playlist');
	Route::get('/playlist/','UserController@index_playlist');
	Route::post('/playlist/store','UserController@store_playlist');

});

Route::get('/test', function(){
	$playlist = App\Playlist::find(13);
	dd($playlist->image);
});

Route::get('import/create','ImportController@create');
Route::post('import','ImportController@store');
Route::get('radio/{cate?}','RadioController@index');

Route::get('api/get-songs-in-cate/{cate}', 'APIController@getSongsInCate');
Route::get('api/get-songs-in-playlist/{playlist}', 'APIController@getSongsInPlaylist');
Route::get('api/get-song/{song}', 'APIController@getSong');

Route::get('api/get-user-playlists/{include_guest?}', 'APIController@getUserPlaylist');
Route::get('api/reset-temp-playlist', 'APIController@resetTempPlaylist');
Route::get('api/get-ajax-hot-song/{cate}/{page?}', 'APIController@getAjaxHotSong');
Route::get('api/get-ajax-hot-playlist/{cate}/{page?}', 'APIController@getAjaxHotPlaylist');
Route::get('api/get-songs-by-artist/{artist}', 'APIController@getSongsByArtist');
Route::get('api/get-albums-by-artist/{artist}', 'APIController@getAlbumsByArtist');
Route::get('api/get-nontime-lyrics/{song}', 'APIController@getNontimeLyrics');

Route::post('api/add-song-to-playlist/', 'APIController@addSongToPlaylist');
Route::post('api/import-playlist-to-playlist/', 'APIController@importPlaylistToPlaylist');
Route::post('api/search', 'APIController@search');
//Route::resource('API/{type}','APIController');
Route::auth();
Route::get('/home', 'HomeController@index');
