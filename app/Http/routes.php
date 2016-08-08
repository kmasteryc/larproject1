<?php

Route::auth();
Route::get('logout', 'Auth\AuthController@getCustomLogout');
Route::post('login', 'Auth\AuthController@postCustomLogin');
Route::get('/test', 'TestController@index');

Route::group(['prefix' => 'playlist','middleware'=>'auth'], function () {
    Route::get('/', 'PlaylistController@index');
    Route::get('create', 'PlaylistController@create');
    Route::get('{playlist}/edit', 'PlaylistController@edit');
    Route::get('{playlist}/delete', 'PlaylistController@delete');
    Route::put('{playlist}', 'PlaylistController@update');
    Route::post('store', 'PlaylistController@store');
});

Route::group(['prefix' => 'session'], function () {
    Route::get('set/{k}/{v}', 'SessionController@set');
    Route::get('get/{k}', 'SessionController@get');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix'=>'nation'], function(){
        Route::get('/', 'NationController@index');
        Route::post('/', 'NationController@store');
        Route::get('{nation}/edit', 'NationController@edit');
        Route::put('{nation}', 'NationController@update');
        Route::get('{nation}/delete', 'NationController@delete');
    });

    Route::group(['prefix' => 'cate'], function () {
        Route::get('{cate}/edit', 'CateController@edit');
        Route::get('/', 'CateController@index');
        Route::get('/{cate}/delete', 'CateController@delete');
        Route::put('/{cate}', 'CateController@update');
        Route::post('/store', 'CateController@store');
    });
    Route::group(['prefix' => 'artist'], function () {
        Route::get('{artist}/edit', 'ArtistController@edit');
        Route::get('/', 'ArtistController@index');
        Route::get('create', 'ArtistController@create');
        Route::get('{artist}/delete', 'ArtistController@delete');
        Route::put('{artist}', 'ArtistController@update');
        Route::post('store', 'ArtistController@store');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('{user}/edit', 'UserController@edit');
        Route::get('/', 'UserController@index');
        Route::get('create', 'UserController@create');
        Route::get('{user}/delete', 'UserController@delete');
        Route::put('{user}', 'UserController@update');
        Route::post('store', 'UserController@store');
    });
    Route::group(['prefix' => 'song'], function () {
        Route::get('{song}/edit', 'SongController@edit');
        Route::get('/', 'SongController@index');
        Route::get('create', 'SongController@create');
        Route::get('{song}/delete', 'SongController@delete');
        Route::put('{song}', 'SongController@update');
        Route::post('store', 'SongController@store');
    });
    Route::group(['prefix' => 'import'], function () {
        Route::get('import_playlist', 'ImportController@importPlaylist');
        Route::get('import_cate', 'ImportController@importCate');
        Route::post('import_playlist', 'ImportController@storePlaylist');
        Route::post('import_cate', 'ImportController@storeCate');
        Route::get('sync_artistimg', 'ImportController@syncArtistImage');
    });
});

Route::group(['prefix' => 'bang-xep-hang'], function () {
    Route::get('{cate}/play.html', 'PlaylistController@show_chart');
    Route::get('{cate}.html', 'ChartController@show');
    Route::get('{cate}/{week_or_month}/{index}.play', 'PlaylistController@show_chart');
    Route::get('{cate}/{week_or_month?}-{index?}/play.html', 'PlaylistController@show_chart')
        ->where([
            'cate' => '[a-zA-Z\-.]+',
            'week_or_month' => '[a-zA-Z]+',
            'index' => '[0-9]+',
            'song_or_playlist' => '[a-zA-Z\-]+'
        ]);
    Route::get('{cate}/{week_or_month?}-{index?}.html', 'ChartController@show')
        ->where([
            'cate' => '[a-zA-Z\-.]+',
            'week_or_month' => '[a-zA-Z]+',
            'index' => '[0-9]+',
            'song_or_playlist' => '[a-zA-Z\-]+'
        ]);
});

Route::group(['prefix' => 'api', 'middleware' => ['api','ajax']], function () {
    Route::get('artist/ajax_search/{search?}', 'ArtistController@ajax_search');
    Route::get('song/ajax_search/{search?}', 'SongController@ajax_search');
    Route::get('song/{song}/increase_view', 'SessionController@increase_view_song');

    Route::get('test', 'APIController@test');
    Route::get('get-songs-in-cate/{cate}', 'APIController@getSongsInCate');
    Route::get('get-songs-in-playlist/{playlist}', 'APIController@getSongsInPlaylist');
    Route::get('get-songs-in-chart/{cate}/{week_or_month}/{index}', 'APIController@getSongsInChart');
    Route::get('get-song/{song}', 'APIController@getSong');
    Route::get('get-songs-by-artist/{artist}', 'APIController@getSongsByArtist');

    Route::get('get-user-playlists/{include_guest?}', 'APIController@getUserPlaylist');
    Route::get('reset-temp-playlist', 'APIController@resetTempPlaylist');
    Route::get('get-ajax-hot-song/{cate}/{page?}', 'APIController@getAjaxHotSong');
    Route::get('get-ajax-hot-playlist/{cate}/{page?}', 'APIController@getAjaxHotPlaylist');
    Route::get('get-albums-by-artist/{artist}', 'APIController@getAlbumsByArtist');
    Route::get('get-nontime-lyrics/{song}', 'APIController@getNontimeLyrics');

    Route::post('add-song-to-playlist/', 'APIController@addSongToPlaylist');
    Route::post('import-playlist-to-playlist/', 'APIController@importPlaylistToPlaylist');
    Route::post('search', 'APIController@search');
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('nghe-si/{artist}', 'ArtistController@show');
Route::get('bai-hat/{song}', 'SongController@show');
Route::get('chu-de/{cate}', 'CateController@show');
Route::get('cate/{cate}', 'CateController@show');
Route::get('playlist/{playlist}', 'PlaylistController@show');
Route::get('artist/{artist}', 'ArtistController@show');
Route::get('song/{song}', 'SongController@show');